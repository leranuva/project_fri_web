<?php

namespace App\Data;

class QuoteData
{
    public function __construct(
        public string $productKey,
        public float $quantity,
        public float $unitWeight,
        public float $unitValue,
        public string $shippingMethod,
    ) {}

    public function totalWeight(): float
    {
        return $this->unitWeight * $this->quantity;
    }

    public function productCost(): float
    {
        return $this->unitValue * $this->quantity;
    }

    /**
     * Crear desde array (compatibilidad con request)
     */
    public static function fromArray(array $data): self
    {
        return new self(
            productKey: (string) $data['product'],
            quantity: (float) $data['quantity'],
            unitWeight: (float) $data['weight'],
            unitValue: (float) $data['unitValue'],
            shippingMethod: (string) $data['shippingMethod'],
        );
    }

    /**
     * Convertir a array para compatibilidad
     */
    public function toArray(): array
    {
        return [
            'product' => $this->productKey,
            'quantity' => $this->quantity,
            'weight' => $this->unitWeight,
            'unitValue' => $this->unitValue,
            'shippingMethod' => $this->shippingMethod,
        ];
    }
}
