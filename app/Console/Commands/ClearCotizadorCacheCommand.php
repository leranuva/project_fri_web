<?php

namespace App\Console\Commands;

use App\Services\Cotizador\Catalog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearCotizadorCacheCommand extends Command
{
    protected $signature = 'cotizador:clear-cache';

    protected $description = 'Limpiar la caché de productos y métodos de envío del cotizador';

    public function handle(): int
    {
        Cache::forget(Catalog::PRODUCTS_CACHE_KEY);
        Cache::forget('cotizador.shipping_methods');
        Cache::forget('cotizador.shipping_ranges');
        Cache::forget(Catalog::SHIPPING_CACHE_KEY);

        $this->info('Caché del cotizador limpiada correctamente.');

        return self::SUCCESS;
    }
}
