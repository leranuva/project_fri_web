<?php

namespace App\Console\Commands;

use App\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ExportStoreLogos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stores:export-logos {--file=store_logos.json : Nombre del archivo de exportación}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exporta los logos SVG de las tiendas a un archivo JSON';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📤 Exportando logos de tiendas...');

        $stores = Store::whereNotNull('logo_url')
            ->where('logo_url', '!=', '')
            ->get(['id', 'name', 'logo_url']);

        if ($stores->isEmpty()) {
            $this->warn('⚠️  No se encontraron tiendas con logos.');
            return Command::FAILURE;
        }

        $data = $stores->map(function ($store) {
            return [
                'name' => $store->name,
                'logo_url' => $store->logo_url,
            ];
        })->toArray();

        $filename = $this->option('file');
        $filepath = storage_path('app/' . $filename);

        File::put($filepath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        $this->info("✅ Logos exportados exitosamente a: {$filepath}");
        $this->info("📊 Total de logos exportados: " . count($data));
        $this->line('');
        $this->comment("📋 Archivo generado: {$filepath}");
        $this->comment("📤 Sube este archivo a producción y ejecuta: php artisan stores:import-logos");

        return Command::SUCCESS;
    }
}
