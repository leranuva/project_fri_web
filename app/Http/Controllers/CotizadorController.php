<?php

namespace App\Http\Controllers;

use App\Helpers\CotizadorHelper;
use App\Http\Requests\CalculateQuoteRequest;
use App\Events\LeadCreated;
use App\Models\Lead;
use App\Models\Product;
use App\Models\Quote;
use App\Models\ShippingRate;
use App\Services\Cotizador\Catalog;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CotizadorController extends Controller
{
    private const CACHE_TTL = 86400; // 24 horas en segundos

    /**
     * Mostrar la página del cotizador
     */
    public function index(Catalog $catalog)
    {
        $products = $catalog->products();
        ['shippingMethods' => $shippingMethods, 'shippingMethodRanges' => $shippingMethodRanges] = $catalog->shipping();
        $cotizadorSection = Cache::remember('cotizador.section', self::CACHE_TTL, fn () => \App\Models\CotizadorSection::getActive());

        return view('cotizador', compact('products', 'shippingMethods', 'shippingMethodRanges', 'cotizadorSection'));
    }

    /**
     * Obtener métodos de envío activos (endpoint API)
     */
    public function getActiveShippingMethods(Catalog $catalog): JsonResponse
    {
        $methods = $catalog->shipping()['shippingMethods'];

        return response()->json([
            'success' => true,
            'data' => $methods
        ]);
    }

    /**
     * Calcular cotización (endpoint API)
     */
    public function calculate(CalculateQuoteRequest $request): JsonResponse
    {
        try {
            // Obtener métodos de envío activos dinámicamente
            $activeMethods = ShippingRate::active()
                ->select('method')
                ->distinct()
                ->pluck('method')
                ->toArray();

            if (empty($activeMethods)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay métodos de envío disponibles. Por favor configure las tarifas de envío.',
                    'errors' => ['No hay métodos de envío configurados']
                ], 422);
            }

            $data = $request->validated();

            // Validaciones de negocio usando el Helper
            $errors = CotizadorHelper::validate($data);
            if (!empty($errors)) {
                return response()->json([
                    'success' => false,
                    'errors' => $errors,
                    'message' => $errors[0]
                ], 422);
            }

            // Cache de cotización (misma entrada = mismo resultado)
            $cacheKey = 'cotizador.quote.v3.' . md5(json_encode($data));
            $quote = Cache::remember($cacheKey, 3600, fn () => CotizadorHelper::calculateQuote($data));

            // Formatear nombre del producto
            $quote['productName'] = CotizadorHelper::formatProductName($data['product']);

            // Guardar en historial de cotizaciones
            $this->saveQuote($data, $quote);

            // Guardar lead (Fase 11)
            $this->saveLead($data, $quote);

            $quote['shareToken'] = \Illuminate\Support\Facades\Crypt::encryptString(json_encode([
                'purpose' => 'quote-share',
                'expires' => now()->addHour()->timestamp,
                'quote' => [
                    'productName' => $quote['productName'],
                    'quantity' => $quote['quantity'],
                    'weight' => $quote['weight'],
                    'shippingMethod' => $data['shippingMethod'],
                    'totalCotizacion' => $quote['totalCotizacion'],
                ],
            ], JSON_THROW_ON_ERROR));

            return response()->json([
                'success' => true,
                'data' => $quote
            ]);

        } catch (\Exception $e) {
            Log::error('No se pudo calcular la cotización', ['exception_type' => $e::class]);

            return response()->json([
                'success' => false,
                'message' => 'No se pudo calcular la cotización. Intenta de nuevo.',
            ], 500);
        }
    }

    /**
     * Obtener todos los datos del cotizador (productos, métodos, rangos)
     * Útil cuando los datos iniciales están vacíos (cache, BD recién migrada)
     */
    public function getData(Catalog $catalog): JsonResponse
    {
        $products = $catalog->products();
        ['shippingMethods' => $shippingMethods, 'shippingMethodRanges' => $shippingMethodRanges] = $catalog->shipping();

        $productsArray = [];
        foreach ($products as $product) {
            $productsArray[$product->key] = [
                'name' => $product->name,
                'adValorem' => (float) $product->ad_valorem,
                'arancelEspecifico' => (float) $product->arancel_especifico,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'products' => $productsArray,
                'shippingMethods' => $shippingMethods,
                'shippingMethodRanges' => $shippingMethodRanges,
            ],
        ]);
    }

    /**
     * Obtener lista de productos (endpoint API)
     */
    public function getProducts(Catalog $catalog): JsonResponse
    {
        $products = $catalog->products();

        $formattedProducts = [];
        foreach ($products as $product) {
            $formattedProducts[] = [
                'key' => $product->key,
                'name' => $product->name,
                'adValorem' => (float) $product->ad_valorem,
                'arancelEspecifico' => (float) $product->arancel_especifico,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $formattedProducts
        ]);
    }

    /**
     * Guardar cotización en el historial
     */
    private function saveQuote(array $data, array $quote): void
    {
        try {
            $product = Product::findByKey($data['product']);

            Quote::create([
                'user_id' => auth()->id(),
                'product_id' => $product?->id,
                'product_key' => $data['product'],
                'weight' => $quote['weight'],
                'fob' => $quote['productCost'],
                'quantity' => (int) $data['quantity'],
                'shipping_method' => $data['shippingMethod'],
                'total' => $quote['totalCotizacion'],
                'details' => $quote,
            ]);
        } catch (\Throwable $e) {
            \Log::warning('No se pudo guardar cotización en historial', ['exception_type' => $e::class]);
        }
    }

    /**
     * Guardar o actualizar lead (Fase 11)
     */
    private function saveLead(array $data, array $quote): void
    {
        try {
            $email = $data['email'] ?? auth()->user()?->email ?? null;
            if (!$email) {
                return;
            }

            $productName = CotizadorHelper::formatProductName($data['product']);
            $valor = (float) ($quote['totalCotizacion'] ?? 0);
            $pais = $data['pais'] ?? 'Ecuador';

            $existing = Lead::where('email', $email)->first();
            $quoteCount = $existing ? $existing->quote_count + 1 : 1;
            $score = Lead::calculateScore($valor, $productName, $quoteCount);

            $payload = [
                'email' => $email,
                'producto' => $productName,
                'valor' => $valor,
                'pais' => $pais,
                'score' => $score,
                'quote_count' => $quoteCount,
                'source' => 'cotizador',
                'metadata' => [
                    'product_key' => $data['product'],
                    'shipping_method' => $data['shippingMethod'] ?? null,
                ],
            ];

            if ($existing) {
                $existing->update($payload);
            } else {
                $lead = Lead::create($payload);
                event(new LeadCreated($lead));
            }
        } catch (\Throwable $e) {
            Log::warning('No se pudo guardar lead', ['exception_type' => $e::class]);
        }
    }
}
