<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Usa datos de la base de datos de producción (ProductSeederData).
     */
    public function run(): void
    {
        $products = require __DIR__ . '/data/ProductSeederData.php';

        $this->command->info('Poblando tabla de productos...');
        $bar = $this->command->getOutput()->createProgressBar(count($products));
        $bar->start();

        foreach ($products as $data) {
            Product::updateOrCreate(
                ['key' => $data['key']],
                [
                    'key' => $data['key'],
                    'arancel_code' => $data['arancel_code'],
                    'arancel_subpartida' => $data['arancel_subpartida'],
                    'name' => $data['name'],
                    'ad_valorem' => $data['ad_valorem'],
                    'arancel_especifico' => $data['arancel_especifico'] ?? 0,
                    'new_percent' => $data['new_percent'] ?? null,
                    'category' => $data['category'] ?? null,
                    'is_active' => true,
                    'sort_order' => 0,
                ]
            );
            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine();
        $this->command->info('✓ Productos insertados/actualizados: ' . count($products));
    }
}
