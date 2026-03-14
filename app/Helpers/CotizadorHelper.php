<?php

namespace App\Helpers;

use App\Data\QuoteData;
use App\Models\Product;
use App\Models\ShippingRate;
use App\Models\TaxRate;
use App\Services\Cotizador\QuoteCalculator;
use App\Services\Cotizador\ShippingCalculator;

class CotizadorHelper
{
    /**
     * Formatea el nombre del producto para mostrar
     */
    public static function formatProductName(string $key): string
    {
        $string = $key;
        
        // Agregar espacios entre letras y números
        $string = preg_replace('/([a-z])([0-9])/i', '$1 $2', $string);
        // Agregar espacios entre letras minúsculas y mayúsculas
        $string = preg_replace('/([a-z])([A-Z])/', '$1 $2', $string);
        // Agregar espacios entre mayúsculas consecutivas seguidas de minúsculas
        $string = preg_replace('/([A-Z])([A-Z][a-z])/', '$1 $2', $string);
        // Reemplazar guiones bajos con barras
        $string = str_replace('_', '/', $string);
        // Reemplazar códigos especiales
        $string = str_replace('PTHO', '(', $string);
        $string = str_replace('PTHC', ')', $string);
        $string = str_replace('EXS', ' ', $string);
        
        return $string;
    }

    /**
     * Calcula el costo de envío según el método, peso y valor FOB
     * Delega a ShippingCalculator (mantenido para compatibilidad)
     */
    public static function calculateShippingCost(string $method, float $weight, float $valueFob = 0): array
    {
        return app(ShippingCalculator::class)->calculate($method, $weight, $valueFob);
    }

    /**
     * Calcula el costo por libra según el método de envío y peso
     * (Método legacy - mantenido para compatibilidad)
     * 
     * @param string $method Método de envío (maritimo, aereo, aereoExpres)
     * @param float $weight Peso total en libras
     * @return float Costo por libra
     * @throws \Exception Si no se encuentra una tarifa para el peso dado
     */
    public static function calculateCostPerPound(string $method, float $weight): float
    {
        if ($method === 'courier4x4') {
            throw new \Exception("Courier 4x4 usa costo fijo, no costo por libra. Use calculateShippingCost() en su lugar.");
        }
        
        $rate = ShippingRate::findRate($method, $weight);
        
        if (!$rate) {
            throw new \Exception("No se encontró una tarifa para el peso {$weight} lbs con el método '{$method}'. Por favor verifique la configuración de tarifas.");
        }
        
        $costPerPound = (float) $rate->cost_per_pound;
        
        // Caso especial para aereo peso exacto 1
        if ($rate->is_special_case && $method === 'aereo' && $weight == 1) {
            return $costPerPound / $weight;
        }
        
        return $costPerPound;
    }

    /**
     * Calcula todos los costos de la cotización
     * Delega a QuoteCalculator (refactorizado)
     */
    public static function calculateQuote(array $data): array
    {
        $quoteData = QuoteData::fromArray($data);
        $calculator = app(QuoteCalculator::class);

        return $calculator->calculate($quoteData);
    }

    /**
     * Valida los datos del formulario
     */
    public static function validate(array $data): array
    {
        $errors = [];
        
        if (empty($data['product']) || $data['product'] === 'selectProducto') {
            $errors[] = 'Por favor seleccione un producto válido.';
        }
        
        // Obtener métodos de envío activos dinámicamente
        $activeMethods = ShippingRate::active()
            ->select('method')
            ->distinct()
            ->pluck('method')
            ->toArray();
        
        if (empty($data['shippingMethod']) || $data['shippingMethod'] === 'selectMetodo') {
            $errors[] = 'Por favor seleccione un método de envío válido.';
        } elseif (!in_array($data['shippingMethod'], $activeMethods)) {
            $errors[] = 'El método de envío seleccionado no está disponible. Por favor seleccione otro método.';
        }
        
        $quantity = (float) ($data['quantity'] ?? 0);
        $weight = (float) ($data['weight'] ?? 0);
        $unitValue = (float) ($data['unitValue'] ?? 0);
        $totalWeight = $weight * $quantity;
        
        if ($quantity <= 0 || $weight <= 0 || $unitValue <= 0) {
            $errors[] = 'Por favor ingrese valores válidos.';
        }
        
        $shippingMethod = $data['shippingMethod'] ?? '';
        
        // Validar peso según las tarifas activas del método seleccionado
        if (!empty($shippingMethod) && in_array($shippingMethod, $activeMethods)) {
            $weightRanges = ShippingRate::getWeightRangesForMethod($shippingMethod);
            
            if ($weightRanges['min_weight'] !== null) {
                // Verificar si hay una tarifa que cubra este peso
                $rate = ShippingRate::findRate($shippingMethod, $totalWeight);
                
                if (!$rate) {
                    // No hay tarifa para este peso, mostrar rango válido
                    $minWeight = $weightRanges['min_weight'];
                    $maxWeight = $weightRanges['max_weight'];
                    $hasUnlimited = $weightRanges['has_unlimited'];
                    
                    if ($totalWeight < $minWeight) {
                        $errors[] = "Para envío {$shippingMethod}, el peso mínimo es de {$minWeight} libras. Peso actual: {$totalWeight} libras.";
                    } elseif ($maxWeight !== null && $totalWeight > $maxWeight && !$hasUnlimited) {
                        $errors[] = "Para envío {$shippingMethod}, el peso máximo es de {$maxWeight} libras. Peso actual: {$totalWeight} libras.";
                    } else {
                        // Peso está fuera de todos los rangos
                        $rangesText = collect($weightRanges['ranges'])->map(function ($range) {
                            if ($range['max'] === null) {
                                return "{$range['min']}+ libras";
                            }
                            return "{$range['min']}-{$range['max']} libras";
                        })->join(', ');
                        $errors[] = "No hay tarifa disponible para el peso {$totalWeight} libras con el método {$shippingMethod}. Rangos disponibles: {$rangesText}.";
                    }
                }
            }
        }
        
        // Validaciones específicas adicionales (siempre aplican)
        $validations = config('products.validations');
        $productKey = $data['product'] ?? '';
        $isPrendas = $productKey === 'PrendasDeVestirYCalzado'
            || stripos($productKey, 'PrendasDeVestir') !== false;

        if ($isPrendas && $totalWeight > $validations['prendas_max_weight']) {
            $errors[] = 'No se puede realizar el envío de prendas de vestir y calzado si el peso excede las ' . $validations['prendas_max_weight'] . ' libras.';
        }
        
        return $errors;
    }
}

