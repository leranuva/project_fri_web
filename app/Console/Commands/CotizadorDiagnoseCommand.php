<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ShippingRate;
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
            Cache::forget('cotizador.products');
            Cache::forget('cotizador.shipping_methods');
            Cache::forget('cotizador.shipping_ranges');
            $this->info('Caché del cotizador limpiada.');
        }

        return self::SUCCESS;
    }
}
