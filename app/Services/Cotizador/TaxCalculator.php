<?php

namespace App\Services\Cotizador;

use App\Models\TaxRate;

class TaxCalculator
{
    /**
     * Calcula impuestos (advalorem, fodinfa, IVA, arancel específico)
     *
     * @param float $productCost Costo del producto
     * @param float $adValorem Tasa ad-valorem del producto (0-1)
     * @param float $arancelEspecifico Arancel específico del producto
     * @param string $shippingMethod Método de envío
     * @param bool $isCourier4x4Valid Si Courier 4x4 aplica (no se cobran impuestos)
     */
    public function calculate(
        float $productCost,
        float $adValorem,
        float $arancelEspecifico,
        string $shippingMethod,
        bool $isCourier4x4Valid
    ): array {
        $impuestoAdvalorem = 0;
        $impuestoFodinfa = 0;
        $impuestoIva = 0;

        if ($shippingMethod !== 'courier4x4' || !$isCourier4x4Valid) {
            $fodinfa = $this->getTaxRate('fodinfa', 0.005);
            $iva = $this->getTaxRate('iva', 0.12);

            $impuestoAdvalorem = $productCost * $adValorem;
            $impuestoFodinfa = $productCost * $fodinfa;
            $impuestoIva = ($productCost + $impuestoAdvalorem + $impuestoFodinfa) * $iva;
        }

        $totalImpuestos = $impuestoAdvalorem + $impuestoFodinfa + $impuestoIva + $arancelEspecifico;

        return [
            'impuestoAdvalorem' => $impuestoAdvalorem,
            'impuestoFodinfa' => $impuestoFodinfa,
            'impuestoIva' => $impuestoIva,
            'arancelEspecifico' => $arancelEspecifico,
            'totalImpuestos' => $totalImpuestos,
            'adValorem' => $adValorem,
            'fodinfa' => $this->getTaxRate('fodinfa', 0.005),
            'iva' => $this->getTaxRate('iva', 0.12),
        ];
    }

    private function getTaxRate(string $name, float $default): float
    {
        $tax = TaxRate::active()->where('name', $name)->first();

        return $tax ? (float) $tax->rate : config("products.taxes.{$name}", $default);
    }
}
