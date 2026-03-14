<?php

namespace App\Helpers;

class SeoHelper
{
    /**
     * Obtener título SEO para la página actual
     */
    public static function title(?string $custom = null): string
    {
        return $custom ?? config('seo.default_title');
    }

    /**
     * Obtener descripción SEO para la página actual
     */
    public static function description(?string $custom = null): string
    {
        return $custom ?? config('seo.default_description');
    }

    /**
     * Obtener URL de imagen para Open Graph
     */
    public static function image(?string $custom = null): string
    {
        $path = $custom ?? config('seo.default_image');
        return str_starts_with($path, 'http') ? $path : url($path);
    }

    /**
     * Construir URL de búsqueda en la tienda para un producto
     */
    public static function storeSearchUrl(string $productQuery): string
    {
        $base = rtrim(config('seo.store_url'), '/');
        $path = config('seo.store_search_path', '/search');
        $query = urlencode($productQuery);

        return $base . $path . '?q=' . $query;
    }
}
