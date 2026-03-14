<?php

namespace App\Services\Cotizador;

use App\Models\TaxRate;

class InsuranceCalculator
{
    /**
     * Calcula el seguro CIF sobre (productCost + shippingCost)
     */
    public function calculate(float $productCost, float $shippingCost): float
    {
        $seguroCif = $this->getSeguroCifRate();

        return ($productCost + $shippingCost) * $seguroCif;
    }

    private function getSeguroCifRate(): float
    {
        $tax = TaxRate::active()->where('name', 'seguro_cif')->first();

        return $tax ? (float) $tax->rate : config('products.taxes.seguro_cif', 0.025);
    }
}
