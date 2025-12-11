<?php

namespace App\Console\Commands;

use App\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportStoreLogos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stores:import-logos {--file=store_logos.json : Nombre del archivo de importación}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa los logos SVG de las tiendas desde un archivo JSON';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->option('file');
        $filepath = storage_path('app/' . $filename);

        if (!File::exists($filepath)) {
            $this->error("❌ El archivo no existe: {$filepath}");
            $this->line('');
            $this->comment("💡 Asegúrate de subir el archivo JSON a: storage/app/");
            return Command::FAILURE;
        }

        $this->info('📥 Importando logos de tiendas...');

        $content = File::get($filepath);
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('❌ Error al decodificar el archivo JSON: ' . json_last_error_msg());
            return Command::FAILURE;
        }

        if (empty($data)) {
            $this->warn('⚠️  El archivo está vacío.');
            return Command::FAILURE;
        }

        $updated = 0;
        $notFound = 0;

        foreach ($data as $item) {
            if (!isset($item['name']) || !isset($item['logo_url'])) {
                $this->warn("⚠️  Item inválido: " . json_encode($item));
                continue;
            }

            $store = Store::where('name', $item['name'])->first();

            if ($store) {
                $store->update(['logo_url' => $item['logo_url']]);
                $updated++;
                $this->line("  ✓ Actualizado: {$item['name']}");
            } else {
                $notFound++;
                $this->warn("  ⚠️  Tienda no encontrada: {$item['name']}");
            }
        }

        $this->line('');
        $this->info("✅ Importación completada!");
        $this->info("📊 Total actualizado: {$updated}");
        
        if ($notFound > 0) {
            $this->warn("⚠️  Tiendas no encontradas: {$notFound}");
        }

        $this->line('');
        $this->comment("🔄 Limpia la caché con: php artisan view:clear && php artisan view:cache");

        return Command::SUCCESS;
    }
}
