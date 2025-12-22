<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateStoreLogosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * INSTRUCCIONES:
     * 1. En desarrollo, ejecuta: php artisan tinker
     * 2. Ejecuta: \App\Models\Store::whereNotNull('logo_url')->get(['name', 'logo_url'])->toJson();
     * 3. Copia el JSON y pégalo en el array $logosJson abajo
     * 4. Ejecuta este seeder en producción: php artisan db:seed --class=UpdateStoreLogosSeeder
     */
    public function run(): void
    {
        // PEGA AQUÍ EL JSON DE LOS LOGOS DESDE DESARROLLO
        // Para obtenerlo, ejecuta en desarrollo:
        // php artisan tinker
        // \App\Models\Store::whereNotNull('logo_url')->get(['name', 'logo_url'])->toJson();
        
        $logosJson = '[
            {"name":"Amazon","logo_url":"<svg>...</svg>"},
            {"name":"eBay","logo_url":"<svg>...</svg>"}
        ]';
        
        // Si prefieres usar un array PHP directamente:
        $logos = [
            // 'Amazon' => '<svg>...</svg>',
            // 'eBay' => '<svg>...</svg>',
            // Agrega todos los logos aquí
        ];
        
        // Si usas JSON, descomenta esto:
        // $logosArray = json_decode($logosJson, true);
        // foreach ($logosArray as $item) {
        //     $logos[$item['name']] = $item['logo_url'];
        // }
        
        if (empty($logos)) {
            $this->command->warn('⚠️  No hay logos definidos. Por favor, agrega los logos al array $logos.');
            return;
        }
        
        $updated = 0;
        foreach ($logos as $name => $logo) {
            $store = Store::where('name', $name)->first();
            if ($store) {
                $store->update(['logo_url' => $logo]);
                $updated++;
                $this->command->info("✓ Actualizado: {$name}");
            } else {
                $this->command->warn("⚠️  Tienda no encontrada: {$name}");
            }
        }
        
        $this->command->info("\n✅ Total actualizado: {$updated} tiendas");
    }
}



