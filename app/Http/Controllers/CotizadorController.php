<?php

namespace App\Http\Controllers;

use App\Helpers\CotizadorHelper;
use App\Http\Requests\CalculateQuoteRequest;
use App\Events\LeadCreated;
use App\Models\Lead;
use App\Models\Product;
use App\Models\Quote;
use App\Models\ShippingRate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CotizadorController extends Controller
{
    private const CACHE_TTL = 86400; // 24 horas en segundos

    /**
     * Mostrar la página del cotizador
     */
    public function index()
    {
        $products = $this->getCachedProducts();
        $shippingMethods = $this->getCachedShippingMethods();
        $shippingMethodRanges = $this->getCachedShippingRanges();
        $cotizadorSection = Cache::remember('cotizador.section', self::CACHE_TTL, fn () => \App\Models\CotizadorSection::getActive());

        return view('cotizador', compact('products', 'shippingMethods', 'shippingMethodRanges', 'cotizadorSection'));
    }

    /**
     * Obtener productos con caché. No cachea resultados vacíos (evita caché obsoleta tras migrar/sembrar).
     */
    private function getCachedProducts()
    {
        $products = Cache::remember('cotizador.products', self::CACHE_TTL, function () {
            return Product::active()->ordered()->get();
        });
        if ($products->isEmpty()) {
            Cache::forget('cotizador.products');
            return Product::active()->ordered()->get();
        }
        return $products;
    }

    /**
     * Obtener métodos de envío con caché. No cachea resultados vacíos.
     */
    private function getCachedShippingMethods(): array
    {
        $methods = Cache::remember('cotizador.shipping_methods', self::CACHE_TTL, function () {
            return ShippingRate::active()
                ->select('method')
                ->distinct()
                ->pluck('method')
                ->toArray();
        });
        if (empty($methods)) {
            Cache::forget('cotizador.shipping_methods');
            return ShippingRate::active()
                ->select('method')
                ->distinct()
                ->pluck('method')
                ->toArray();
        }
        return $methods;
    }

    /**
     * Obtener rangos de envío con caché. No cachea resultados vacíos.
     */
    private function getCachedShippingRanges(): array
    {
        $ranges = Cache::remember('cotizador.shipping_ranges', self::CACHE_TTL, function () {
            $methods = ShippingRate::active()->select('method')->distinct()->pluck('method')->toArray();
            $result = [];
            foreach ($methods as $method) {
                $result[$method] = ShippingRate::getWeightRangesForMethod($method);
            }
            return $result;
        });
        if (empty($ranges)) {
            Cache::forget('cotizador.shipping_ranges');
            $methods = ShippingRate::active()->select('method')->distinct()->pluck('method')->toArray();
            $ranges = [];
            foreach ($methods as $method) {
                $ranges[$method] = ShippingRate::getWeightRangesForMethod($method);
            }
        }
        return $ranges;
    }
    
    /**
     * Obtener métodos de envío activos (endpoint API)
     */
    public function getActiveShippingMethods(): JsonResponse
    {
        $methods = $this->getCachedShippingMethods();

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

            return response()->json([
                'success' => true,
                'data' => $quote
            ]);

        } catch (\Exception $e) {
            Log::error('Cotizador calculate error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->validated(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al calcular la cotización: ' . $e->getMessage(),
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }

    /**
     * Obtener todos los datos del cotizador (productos, métodos, rangos)
     * Útil cuando los datos iniciales están vacíos (cache, BD recién migrada)
     */
    public function getData(): JsonResponse
    {
        $products = $this->getCachedProducts();
        $shippingMethods = $this->getCachedShippingMethods();
        $shippingMethodRanges = $this->getCachedShippingRanges();

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
    public function getProducts(): JsonResponse
    {
        $products = $this->getCachedProducts();

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
            \Log::warning('No se pudo guardar cotización en historial: ' . $e->getMessage());
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
            Log::warning('No se pudo guardar lead: ' . $e->getMessage());
        }
    }
}
