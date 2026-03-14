<?php

namespace App\Services\Cotizador;

use App\Models\ShippingRate;

class ShippingCalculator
{
    /**
     * Calcula el costo de envío según el método, peso y valor FOB
     *
     * @return array{cost: float, isCourier4x4Valid: bool}
     */
    public function calculate(string $method, float $weight, float $valueFob = 0): array
    {
        if ($method === 'courier4x4') {
            return $this->calculateCourier4x4($weight, $valueFob);
        }

        return $this->calculateStandard($method, $weight);
    }

    private function calculateCourier4x4(float $weight, float $valueFob): array
    {
        $validations = config('products.validations');
        $maxWeight = $validations['courier4x4_max_weight'] ?? 8.82;
        $maxValueFob = $validations['courier4x4_max_value_fob'] ?? 400.00;

        $isValid = ($weight <= $maxWeight && $valueFob <= $maxValueFob);

        if ($isValid) {
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

            $costPerPound = (float) $rate->cost_per_pound;
            $fixedCost = (float) ($rate->fixed_cost ?? 20.00);
            $shippingCost = ($costPerPound * $weight) + $fixedCost;

            return ['cost' => $shippingCost, 'isCourier4x4Valid' => true];
        }

        // Courier 4x4 no aplica: usar aéreo como alternativa
        $rate = ShippingRate::findRate('aereo', $weight);

        if (!$rate) {
            throw new \Exception("No se encontró una tarifa para el peso {$weight} lbs. Courier 4x4 no aplica y no hay tarifa alternativa.");
        }

        $costPerPound = (float) $rate->cost_per_pound;
        if ($rate->is_special_case && $weight == 1) {
            $costPerPound = $costPerPound / $weight;
        }

        return ['cost' => $costPerPound * $weight, 'isCourier4x4Valid' => false];
    }

    private function calculateStandard(string $method, float $weight): array
    {
        $rate = ShippingRate::findRate($method, $weight);

        if (!$rate) {
            $this->throwWeightRangeException($method, $weight);
        }

        $costPerPound = (float) $rate->cost_per_pound;
        if ($rate->is_special_case && $method === 'aereo' && $weight == 1) {
            $costPerPound = $costPerPound / $weight;
        }

        return ['cost' => $costPerPound * $weight, 'isCourier4x4Valid' => false];
    }

    private function throwWeightRangeException(string $method, float $weight): void
    {
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
        }
        if ($maxWeight !== null && $weight > $maxWeight && !$weightRanges['has_unlimited']) {
            throw new \Exception("Para envío {$method}, el peso máximo es de {$maxWeight} libras. Peso actual: {$weight} libras.");
        }

        throw new \Exception("No hay tarifa disponible para el peso {$weight} lbs con el método '{$method}'. Rangos disponibles: {$rangesText}.");
    }
}
