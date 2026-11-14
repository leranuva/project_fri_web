<?php

namespace App\Http\Controllers;

use App\Services\Cotizador\Catalog;
use Illuminate\Support\Facades\Cache;

class EmbedController extends Controller
{
    /**
     * Widget embebible del cotizador (Fase 14.2) - para iframe en otras webs
     */
    public function cotizador(Catalog $catalog)
    {
        $products = $catalog->products();
        ['shippingMethods' => $shippingMethods, 'shippingMethodRanges' => $shippingMethodRanges] = $catalog->shipping();
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
