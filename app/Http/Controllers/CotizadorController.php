<?php

namespace App\Http\Controllers;

use App\Helpers\CotizadorHelper;
use App\Mail\QuoteEmail;
use App\Models\Product;
use App\Models\ShippingRate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CotizadorController extends Controller
{
    /**
     * Mostrar la página del cotizador
     */
    public function index()
    {
        // Obtener productos activos desde la base de datos
        $products = Product::active()->ordered()->get();
        
        // Obtener métodos de envío únicos activos desde la base de datos
        $shippingMethods = ShippingRate::active()
            ->select('method')
            ->distinct()
            ->pluck('method')
            ->toArray();
        
        // Obtener rangos de peso para cada método activo
        $shippingMethodRanges = [];
        foreach ($shippingMethods as $method) {
            $shippingMethodRanges[$method] = ShippingRate::getWeightRangesForMethod($method);
        }
        
        // Obtener configuración del cotizador
        $cotizadorSection = \App\Models\CotizadorSection::getActive();
        
        return view('cotizador', compact('products', 'shippingMethods', 'shippingMethodRanges', 'cotizadorSection'));
    }
    
    /**
     * Obtener métodos de envío activos (endpoint API)
     */
    public function getActiveShippingMethods(): JsonResponse
    {
        $methods = ShippingRate::active()
            ->select('method')
            ->distinct()
            ->pluck('method')
            ->toArray();
        
        return response()->json([
            'success' => true,
            'data' => $methods
        ]);
    }

    /**
     * Calcular cotización (endpoint API)
     */
    public function calculate(Request $request): JsonResponse
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
            
            // Validar datos básicos con métodos activos dinámicos
            $data = $request->validate([
                'product' => 'required|string',
                'quantity' => 'required|numeric|min:0.01',
                'weight' => 'required|numeric|min:0.01',
                'unitValue' => 'required|numeric|min:0.01',
                'shippingMethod' => ['required', 'string', 'in:' . implode(',', $activeMethods)],
            ]);

            // Validaciones de negocio usando el Helper
            $errors = CotizadorHelper::validate($data);
            if (!empty($errors)) {
                return response()->json([
                    'success' => false,
                    'errors' => $errors,
                    'message' => $errors[0] // Primer error como mensaje principal
                ], 422);
            }

            // Calcular cotización
            $quote = CotizadorHelper::calculateQuote($data);

            // Formatear nombre del producto
            $quote['productName'] = CotizadorHelper::formatProductName($data['product']);

            return response()->json([
                'success' => true,
                'data' => $quote
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al calcular la cotización: ' . $e->getMessage(),
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }

    /**
     * Obtener lista de productos (endpoint API)
     */
    public function getProducts(): JsonResponse
    {
        $products = Product::active()->ordered()->get();
        
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
     * Enviar cotización por email
     */
    public function sendEmail(Request $request): JsonResponse
    {
        try {
            // Validar datos
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'subject' => 'nullable|string|max:255',
                'message' => 'nullable|string',
                'pdf' => 'required|string', // Base64 del PDF
                'quoteData' => 'required|array',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors()->all()
                ], 422);
            }

            $email = $request->input('email');
            $subject = $request->input('subject', 'Cotización de Importación');
            $message = $request->input('message', '');
            $pdfBase64 = $request->input('pdf');
            $quoteData = $request->input('quoteData');

            // Enviar email
            Mail::to($email)->send(new QuoteEmail($subject, $message, $pdfBase64, $quoteData));

            return response()->json([
                'success' => true,
                'message' => 'Cotización enviada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el email: ' . $e->getMessage(),
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }
}
