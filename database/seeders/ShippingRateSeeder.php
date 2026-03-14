<?php

namespace Database\Seeders;

use App\Models\ShippingRate;
use Illuminate\Database\Seeder;

class ShippingRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Usa datos de la base de datos de producción (ShippingRateSeederData).
     */
    public function run(): void
    {
        $rates = require __DIR__ . '/data/ShippingRateSeederData.php';

        $this->command->info('Poblando tabla de tarifas de envío...');

        ShippingRate::truncate();

        $sortOrder = 0;
        $courierNote = 'Régimen Courier 4x4 - Arancel fijo $20. Vigente desde 16 de junio de 2025. Peso máximo: 4kg (8.82 lbs), Valor FOB máximo: $400.';

        foreach ($rates as $r) {
            [$method, $minWeight, $maxWeight, $maxValueFob, $costPerPound, $fixedCost, $isActive] = $r;

            $isSpecialCase = ($method === 'courier4x4');
            $notes = $isSpecialCase ? $courierNote : null;

            ShippingRate::create([
                'method' => $method,
                'min_weight' => $minWeight,
                'max_weight' => $maxWeight,
                'max_value_fob' => $maxValueFob,
                'cost_per_pound' => $costPerPound,
                'fixed_cost' => $fixedCost,
                'is_special_case' => $isSpecialCase,
                'notes' => $notes,
                'sort_order' => $sortOrder++,
                'is_active' => (bool) $isActive,
            ]);
        }

        $this->command->info('✓ Tarifas de envío insertadas: ' . count($rates));
    }
}
