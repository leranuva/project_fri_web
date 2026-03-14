<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShippingRate;
use Illuminate\Support\Facades\Cache;

class EmbedController extends Controller
{
    /**
     * Widget embebible del cotizador (Fase 14.2) - para iframe en otras webs
     */
    public function cotizador()
    {
        $products = Cache::remember('cotizador.products', 86400, fn () => Product::active()->ordered()->get());
        $shippingMethods = Cache::remember('cotizador.shipping_methods', 86400, fn () =>
            ShippingRate::active()->select('method')->distinct()->pluck('method')->toArray()
        );
        $shippingMethodRanges = Cache::remember('cotizador.shipping_ranges', 86400, function () {
            $methods = ShippingRate::active()->select('method')->distinct()->pluck('method')->toArray();
            $ranges = [];
            foreach ($methods as $method) {
                $ranges[$method] = ShippingRate::getWeightRangesForMethod($method);
            }
            return $ranges;
        });
        $cotizadorSection = Cache::remember('cotizador.section', 86400, fn () => \App\Models\CotizadorSection::getActive());

        $productsArray = [];
        foreach ($products as $product) {
            $productsArray[$product->key] = [
                'name' => $product->name,
                'adValorem' => (float) $product->ad_valorem,
                'arancelEspecifico' => (float) $product->arancel_especifico,
            ];
        }

        return response()
            ->view('embed.cotizador', compact('products', 'productsArray', 'shippingMethods', 'shippingMethodRanges', 'cotizadorSection'))
            ->header('X-Frame-Options', 'ALLOWALL')
            ->header('Content-Security-Policy', "frame-ancestors *");
    }
}
