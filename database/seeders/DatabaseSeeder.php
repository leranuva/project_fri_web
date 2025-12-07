<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('=== Iniciando proceso de poblamiento de base de datos ===');
        $this->command->newLine();
        
        // Ejecutar seeders en orden
        $this->call([
            UserSeeder::class,
            TaxRateSeeder::class,
            ShippingRateSeeder::class,
            ProductSeeder::class,
            AssignArancelCodesSeeder::class,
        ]);
        
        $this->command->newLine();
        $this->command->info('=== Proceso completado exitosamente ===');
    }
}
