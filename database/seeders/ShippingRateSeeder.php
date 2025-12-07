<?php

namespace Database\Seeders;

use App\Models\ShippingRate;
use Illuminate\Database\Seeder;

class ShippingRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shippingRates = config('products.shipping_rates', []);
        
        $this->command->info('Poblando tabla de tarifas de envío...');
        
        // Limpiar tarifas existentes
        ShippingRate::truncate();
        
        $totalRates = 0;
        $sortOrder = 0;
        
        foreach ($shippingRates as $method => $rates) {
            foreach ($rates as $rate) {
                [$minWeight, $maxWeight, $costPerPound] = $rate;
                
                // Determinar si es caso especial (aereo peso 1)
                $isSpecialCase = ($method === 'aereo' && $minWeight == 1 && $maxWeight == 1);
                
                ShippingRate::create([
                    'method' => $method,
                    'min_weight' => $minWeight,
                    'max_weight' => $maxWeight,
                    'cost_per_pound' => $costPerPound,
                    'is_special_case' => $isSpecialCase,
                    'sort_order' => $sortOrder++,
                    'is_active' => true,
                ]);
                
                $totalRates++;
            }
        }
        
        $this->command->info("✓ Tarifas de envío insertadas: {$totalRates}");
    }
}
