<?php

namespace App\Services\Cotizador;

use App\Models\Product;
use App\Models\ShippingRate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class Catalog
{
    public const PRODUCTS_CACHE_KEY = 'cotizador.products';

    public const SHIPPING_CACHE_KEY = 'cotizador.shipping_catalog';

    private const CACHE_TTL = 86400;

    public function products(): Collection
    {
        $products = Cache::get(self::PRODUCTS_CACHE_KEY);
        if ($products instanceof Collection && $products->isNotEmpty()) {
            return $products;
        }

        $products = Product::active()->ordered()->get();
        if ($products->isNotEmpty()) {
            Cache::put(self::PRODUCTS_CACHE_KEY, $products, self::CACHE_TTL);
        }

        return $products;
    }

    public function shipping(): array
    {
        $ranges = Cache::get(self::SHIPPING_CACHE_KEY);
        if ($ranges === null) {
            $ranges = ShippingRate::active()
                ->orderBy('id')
                ->get(['method', 'min_weight', 'max_weight', 'sort_order'])
                ->groupBy('method')
                ->map(fn (Collection $rates) => ShippingRate::summarizeWeightRanges($rates->sortBy(['sort_order', 'min_weight'])->values()))
                ->all();

            if ($ranges !== []) {
                Cache::put(self::SHIPPING_CACHE_KEY, $ranges, self::CACHE_TTL);
            }
        }

        return [
            'shippingMethods' => array_keys($ranges),
            'shippingMethodRanges' => $ranges,
        ];
    }
}
