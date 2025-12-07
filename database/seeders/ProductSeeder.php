<?php

namespace Database\Seeders;

use App\Helpers\CotizadorHelper;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = config('products.products', []);
        
        $this->command->info('Poblando tabla de productos...');
        
        $bar = $this->command->getOutput()->createProgressBar(count($products));
        $bar->start();
        
        foreach ($products as $key => $data) {
            Product::updateOrCreate(
                ['key' => $key],
                [
                    'key' => $key,
                    'name' => CotizadorHelper::formatProductName($key),
                    'ad_valorem' => $data['adValorem'],
                    'arancel_especifico' => $data['arancelEspecifico'] ?? 0.0,
                    'new_percent' => $data['newPercent'] ?? null,
                    'is_active' => true,
                    'sort_order' => 0,
                ]
            );
            $bar->advance();
        }
        
        $bar->finish();
        $this->command->newLine();
        $this->command->info('✓ Productos insertados: ' . count($products));
    }
}
