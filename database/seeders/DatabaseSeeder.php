<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('=== Iniciando proceso de poblamiento de base de datos ===');
        $this->command->newLine();
        
        // Ejecutar seeders en orden (secciones antes de su contenido)
        $this->call([
            UserSeeder::class,
            TaxRateSeeder::class,
            ShippingRateSeeder::class,
            ProductSeeder::class,
            ThemeSeeder::class,
            FooterSectionSeeder::class,
            FooterLinkSeeder::class,
            ProcessSectionSeeder::class,
            ProcessStepSeeder::class,
            BenefitSectionSeeder::class,
            BenefitSeeder::class,
            StoreSectionSeeder::class,
            StoreSeeder::class,
            StoreLogosSeeder::class,
            BlogSectionSeeder::class,
            BlogPostSeeder::class,
            SliderSeeder::class,
            AlertBannerSeeder::class,
            CotizadorSectionSeeder::class,
            SeoPageSeeder::class,
        ]);

        // Limpiar caché del cotizador para que cargue productos y métodos actualizados
        Cache::forget('cotizador.products');
        Cache::forget('cotizador.shipping_methods');
        Cache::forget('cotizador.shipping_ranges');
        $this->command->info('✓ Caché del cotizador limpiada');

        $this->command->newLine();
        $this->command->info('=== Proceso completado exitosamente ===');
    }
}
