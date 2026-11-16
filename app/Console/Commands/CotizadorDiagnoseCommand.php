<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ShippingRate;
use App\Services\Cotizador\Catalog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CotizadorDiagnoseCommand extends Command
{
    protected $signature = 'cotizador:diagnose {--clear : Limpiar caché del cotizador}';

    protected $description = 'Diagnosticar productos y métodos de envío del cotizador';

    public function handle(): int
    {
        $productCount = Product::active()->count();
        $methods = ShippingRate::active()->select('method')->distinct()->pluck('method')->toArray();

        $this->info("Productos activos: {$productCount}");
        $this->info('Métodos de envío: ' . (empty($methods) ? 'ninguno' : implode(', ', $methods)));

        if ($productCount === 0 || empty($methods)) {
            $this->warn('No hay datos. Ejecuta: php artisan db:seed --force');
        }

        if ($this->option('clear')) {
            Cache::forget(Catalog::PRODUCTS_CACHE_KEY);
            Cache::forget('cotizador.shipping_methods');
            Cache::forget('cotizador.shipping_ranges');
            Cache::forget(Catalog::SHIPPING_CACHE_KEY);
            $this->info('Caché del cotizador limpiada.');
        }

        return self::SUCCESS;
    }
}
