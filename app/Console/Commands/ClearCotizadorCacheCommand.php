<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearCotizadorCacheCommand extends Command
{
    protected $signature = 'cotizador:clear-cache';

    protected $description = 'Limpiar la caché de productos y métodos de envío del cotizador';

    public function handle(): int
    {
        Cache::forget('cotizador.products');
        Cache::forget('cotizador.shipping_methods');
        Cache::forget('cotizador.shipping_ranges');

        $this->info('Caché del cotizador limpiada correctamente.');

        return self::SUCCESS;
    }
}
