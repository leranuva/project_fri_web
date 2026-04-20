<?php

namespace App\Services\Cotizador;

use App\Data\QuoteData;
use App\Models\Product;
use App\Models\ShippingRate;

class QuoteCalculator
{
    public function __construct(
        private ShippingCalculator $shippingCalculator,
        private TaxCalculator $taxCalculator,
        private InsuranceCalculator $insuranceCalculator,
        private TotalCalculator $totalCalculator,
    ) {}

    /**
     * Calcula la cotización completa
     *
     * @return array<string, mixed>
     */
    public function calculate(QuoteData $data): array
    {
        $product = Product::findByKey($data->productKey);

        if (!$product || !$product->is_active) {
            throw new \Exception('Producto no encontrado o inactivo');
        }

        $totalWeight = $data->totalWeight();
        $productCost = $data->productCost();

        // 1. Envío
        $shippingResult = $this->shippingCalculator->calculate(
            $data->shippingMethod,
            $totalWeight,
            $productCost
        );
        $shippingCost = $shippingResult['cost'];
        $isCourier4x4Valid = $shippingResult['isCourier4x4Valid'] ?? false;

        // 2. Impuestos
        $adValorem = (float) $product->ad_valorem;
        $arancelEspecifico = (float) $product->arancel_especifico;

        $taxResult = $this->taxCalculator->calculate(
            $productCost,
            $shippingCost,
            $adValorem,
            $arancelEspecifico,
            $data->shippingMethod,
            $isCourier4x4Valid
        );

        // 3. Seguro CIF
        $seguroCIF = $this->insuranceCalculator->calculate($productCost, $shippingCost);

        // 4. Total
        $totalCotizacion = $this->totalCalculator->calculate(
            $shippingCost,
            $taxResult['totalImpuestos'],
            $seguroCIF
        );

        // Arancel fijo Courier 4x4 (solo para mostrar en el desglose)
        $arancelFijoCourier4x4 = $this->getArancelFijoCourier4x4(
            $data->shippingMethod,
            $isCourier4x4Valid,
            $totalWeight
        );

        return [
            'product' => $data->productKey,
            'quantity' => $data->quantity,
            'weight' => $totalWeight,
            'productCost' => $productCost,
            'shippingCost' => $shippingCost,
            'arancelFijoCourier4x4' => $arancelFijoCourier4x4,
            'impuestoAdvalorem' => $taxResult['impuestoAdvalorem'],
            'impuestoFodinfa' => $taxResult['impuestoFodinfa'],
            'impuestoIva' => $taxResult['impuestoIva'],
            'arancelEspecifico' => $taxResult['arancelEspecifico'],
            'totalImpuestos' => $taxResult['totalImpuestos'],
            'seguroCIF' => $seguroCIF,
            'totalCotizacion' => $totalCotizacion,
            'adValorem' => $taxResult['adValorem'],
            'fodinfa' => $taxResult['fodinfa'],
            'iva' => $taxResult['iva'],
            'isCourier4x4Valid' => $isCourier4x4Valid,
        ];
    }

    private function getArancelFijoCourier4x4(string $shippingMethod, bool $isCourier4x4Valid, float $totalWeight): float
    {
        if ($shippingMethod !== 'courier4x4' || !$isCourier4x4Valid) {
            return 0;
        }

        $courierRate = ShippingRate::active()
            ->forMethod('courier4x4')
            ->where('min_weight', '<=', $totalWeight)
            ->where(function ($query) use ($totalWeight) {
                $query->whereNull('max_weight')
                    ->orWhere('max_weight', '>=', $totalWeight);
            })
            ->ordered()
            ->first();

        return $courierRate ? (float) ($courierRate->fixed_cost ?? 20.00) : 20.00;
    }
}
