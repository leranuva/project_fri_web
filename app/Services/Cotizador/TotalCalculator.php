<?php

namespace App\Services\Cotizador;

class TotalCalculator
{
    /**
     * Calcula el total final de la cotización (productCost + shipping + impuestos + seguro CIF)
     */
    public function calculate(
        float $productCost,
        float $shippingCost,
        float $totalImpuestos,
        float $seguroCIF
    ): float {
        return $productCost + $shippingCost + $totalImpuestos + $seguroCIF;
    }
}
