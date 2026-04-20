<?php

namespace App\Services\Cotizador;

class TotalCalculator
{
    /**
     * Total mostrado al cliente: envío + impuestos + seguro CIF.
     * El valor del producto no se suma aquí (solo alimenta el cálculo de impuestos y del seguro).
     */
    public function calculate(
        float $shippingCost,
        float $totalImpuestos,
        float $seguroCIF
    ): float {
        return $shippingCost + $totalImpuestos + $seguroCIF;
    }
}
