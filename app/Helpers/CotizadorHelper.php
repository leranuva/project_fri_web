<?php

namespace App\Helpers;

use App\Models\Product;
use App\Models\ShippingRate;
use App\Models\TaxRate;

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
     * 
     * @param string $method Método de envío (maritimo, aereo, aereoExpres, courier4x4)
     * @param float $weight Peso total en libras
     * @param float $valueFob Valor FOB del producto (requerido para courier4x4)
     * @return array ['cost' => float, 'isCourier4x4Valid' => bool] Costo de envío y si Courier 4x4 cumple condiciones
     * @throws \Exception Si no se encuentra una tarifa para el peso dado
     */
    public static function calculateShippingCost(string $method, float $weight, float $valueFob = 0): array
    {
        // Caso especial: Courier 4x4
        if ($method === 'courier4x4') {
            $validations = config('products.validations');
            $maxWeight = $validations['courier4x4_max_weight'] ?? 8.82; // 4 kg en libras
            $maxValueFob = $validations['courier4x4_max_value_fob'] ?? 400.00;
            
            // Verificar si cumple condiciones
            $isValid = ($weight <= $maxWeight && $valueFob <= $maxValueFob);
            
            if ($isValid) {
                // Si cumple condiciones: buscar tarifa desde la base de datos
                $rate = ShippingRate::active()
                    ->forMethod('courier4x4')
                    ->where('min_weight', '<=', $weight)
                    ->where(function ($query) use ($weight) {
                        $query->whereNull('max_weight')
                              ->orWhere('max_weight', '>=', $weight);
                    })
                    ->ordered()
                    ->first();
                
                if (!$rate) {
                    throw new \Exception("No se encontró tarifa Courier 4x4 para el peso {$weight} lbs.");
                }
                
                // Costo total = (costo por libra * peso) + arancel fijo
                $costPerPound = (float) $rate->cost_per_pound;
                $fixedCost = (float) ($rate->fixed_cost ?? 20.00);
                $shippingCost = ($costPerPound * $weight) + $fixedCost;
                
                return ['cost' => $shippingCost, 'isCourier4x4Valid' => true];
            } else {
                // Si NO cumple condiciones: calcular como método normal (aéreo por defecto)
                $rate = ShippingRate::findRate('aereo', $weight);
                
                if (!$rate) {
                    throw new \Exception("No se encontró una tarifa para el peso {$weight} lbs. Courier 4x4 no aplica y no hay tarifa alternativa.");
                }
                
                $costPerPound = (float) $rate->cost_per_pound;
                
                // Caso especial para aéreo peso exacto 1
                if ($rate->is_special_case && $weight == 1) {
                    $costPerPound = $costPerPound / $weight;
                }
                
                return ['cost' => $costPerPound * $weight, 'isCourier4x4Valid' => false];
            }
        }

        // Métodos tradicionales (costo por libra) - desde base de datos
        $rate = ShippingRate::findRate($method, $weight);
        
        if (!$rate) {
            // Obtener información de rangos para mostrar mensaje más útil
            $weightRanges = ShippingRate::getWeightRangesForMethod($method);
            $minWeight = $weightRanges['min_weight'];
            $maxWeight = $weightRanges['max_weight'];
            
            if ($minWeight === null) {
                throw new \Exception("No hay tarifas activas para el método '{$method}'. Por favor active al menos una tarifa de envío.");
            }
            
            $rangesText = collect($weightRanges['ranges'])->map(function ($range) {
                if ($range['max'] === null) {
                    return "{$range['min']}+ libras";
                }
                return "{$range['min']}-{$range['max']} libras";
            })->join(', ');
            
            if ($weight < $minWeight) {
                throw new \Exception("Para envío {$method}, el peso mínimo es de {$minWeight} libras. Peso actual: {$weight} libras.");
            } elseif ($maxWeight !== null && $weight > $maxWeight && !$weightRanges['has_unlimited']) {
                throw new \Exception("Para envío {$method}, el peso máximo es de {$maxWeight} libras. Peso actual: {$weight} libras.");
            } else {
                throw new \Exception("No hay tarifa disponible para el peso {$weight} lbs con el método '{$method}'. Rangos disponibles: {$rangesText}.");
            }
        }
        
        $costPerPound = (float) $rate->cost_per_pound;
        
        // Caso especial para aereo peso exacto 1
        if ($rate->is_special_case && $method === 'aereo' && $weight == 1) {
            $costPerPound = $costPerPound / $weight;
        }
        
        return ['cost' => $costPerPound * $weight, 'isCourier4x4Valid' => false];
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
     */
    public static function calculateQuote(array $data): array
    {
        // Obtener producto desde la base de datos
        $productModel = Product::findByKey($data['product']);
        
        if (!$productModel || !$productModel->is_active) {
            throw new \Exception('Producto no encontrado o inactivo');
        }

        $quantity = (float) $data['quantity'];
        $unitWeight = (float) $data['weight'];
        $unitValue = (float) $data['unitValue'];
        $shippingMethod = $data['shippingMethod'];
        
        $totalWeight = $unitWeight * $quantity;
        $productCost = $unitValue * $quantity;
        
        // Calcular costo de envío
        $shippingResult = self::calculateShippingCost($shippingMethod, $totalWeight, $productCost);
        $shippingCost = $shippingResult['cost'];
        $isCourier4x4Valid = $shippingResult['isCourier4x4Valid'] ?? false;
        
        // Calcular impuestos desde el modelo de producto
        $adValorem = (float) $productModel->ad_valorem;
        $arancelEspecifico = (float) $productModel->arancel_especifico;
        
        $impuestoAdvalorem = 0;
        $impuestoFodinfa = 0;
        $impuestoIva = 0;
        
        // Obtener impuestos desde la base de datos (solo activos)
        $fodinfaTax = TaxRate::active()->where('name', 'fodinfa')->first();
        $ivaTax = TaxRate::active()->where('name', 'iva')->first();
        $seguroCifTax = TaxRate::active()->where('name', 'seguro_cif')->first();
        
        // Usar valores de la base de datos si existen, sino usar config como fallback
        $fodinfa = $fodinfaTax ? (float) $fodinfaTax->rate : config('products.taxes.fodinfa', 0.005);
        $iva = $ivaTax ? (float) $ivaTax->rate : config('products.taxes.iva', 0.12);
        $seguroCif = $seguroCifTax ? (float) $seguroCifTax->rate : config('products.taxes.seguro_cif', 0.025);
        
        // Lógica especial para Courier 4x4
        if ($shippingMethod === 'courier4x4' && $isCourier4x4Valid) {
            // Courier 4x4 con condiciones válidas: NO se cobran impuestos, solo el costo de envío + arancel fijo
            // Los impuestos ya están en 0
        } else {
            // Para todos los demás métodos (Aéreo, Marítimo, Aéreo Express, Courier 4x4 sin condiciones válidas):
            // Se cobran TODOS los impuestos sin excepciones
            $impuestoAdvalorem = $productCost * $adValorem;
            $impuestoFodinfa = $productCost * $fodinfa;
            $impuestoIva = ($productCost + $impuestoAdvalorem + $impuestoFodinfa) * $iva;
        }
        
        $totalImpuestos = $impuestoAdvalorem + $impuestoFodinfa + $impuestoIva + $arancelEspecifico;
        
        // Seguro CIF (ya obtenido arriba desde la base de datos)
        $seguroCIF = ($productCost + $shippingCost) * $seguroCif;
        $totalCotizacion = $productCost + $shippingCost + $totalImpuestos;
        $totalConSeguro = $totalCotizacion + $seguroCIF;
        
        // Calcular arancel fijo de Courier 4x4 (si aplica)
        $arancelFijoCourier4x4 = 0;
        if ($shippingMethod === 'courier4x4' && $isCourier4x4Valid) {
            // Obtener el arancel fijo desde la tarifa de envío
            $courierRate = ShippingRate::active()
                ->forMethod('courier4x4')
                ->where('min_weight', '<=', $totalWeight)
                ->where(function ($query) use ($totalWeight) {
                    $query->whereNull('max_weight')
                          ->orWhere('max_weight', '>=', $totalWeight);
                })
                ->ordered()
                ->first();
            
            $arancelFijoCourier4x4 = $courierRate ? (float) ($courierRate->fixed_cost ?? 20.00) : 20.00;
        }
        
        return [
            'product' => $data['product'],
            'quantity' => $quantity,
            'weight' => $totalWeight,
            'productCost' => $productCost,
            'shippingCost' => $shippingCost,
            'arancelFijoCourier4x4' => $arancelFijoCourier4x4,
            'impuestoAdvalorem' => $impuestoAdvalorem,
            'impuestoFodinfa' => $impuestoFodinfa,
            'impuestoIva' => $impuestoIva,
            'arancelEspecifico' => $arancelEspecifico,
            'totalImpuestos' => $totalImpuestos,
            'seguroCIF' => $seguroCIF,
            'totalCotizacion' => $totalConSeguro,
            'adValorem' => $adValorem,
            'fodinfa' => $fodinfa,
            'iva' => $iva,
            'isCourier4x4Valid' => $isCourier4x4Valid,
        ];
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
        
        if ($data['product'] === 'PrendasDeVestirYCalzado' && $totalWeight > $validations['prendas_max_weight']) {
            $errors[] = 'No se puede realizar el envío de prendas de vestir y calzado si el peso excede las ' . $validations['prendas_max_weight'] . ' libras.';
        }
        
        return $errors;
    }
}

