<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ShippingRate;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Agregar campos para courier4x4 si no existen
        Schema::table('shipping_rates', function (Blueprint $table) {
            if (!Schema::hasColumn('shipping_rates', 'fixed_cost')) {
                $table->decimal('fixed_cost', 10, 2)->nullable()->after('cost_per_pound')->comment('Costo fijo (para courier4x4)');
            }
            if (!Schema::hasColumn('shipping_rates', 'max_value_fob')) {
                $table->decimal('max_value_fob', 10, 2)->nullable()->after('max_weight')->comment('Valor FOB máximo en USD (para courier4x4)');
            }
        });

        // Eliminar cualquier tarifa courier4x4 existente antes de crear las nuevas
        ShippingRate::where('method', 'courier4x4')->delete();
        
        // Insertar tarifas courier4x4
        // Courier 4x4: costo por libra según peso (1-8 lbs) + arancel fijo de $20
        // Peso máximo: 8.82 lbs (4 kg), Valor FOB máximo: $400
        // Si no cumple condiciones, se calcula como método normal con todos los impuestos
        
        $courier4x4Rates = [
            ['min' => 1, 'max' => 1, 'cost_per_pound' => 19.8], // Para peso 1: 19.8 / peso
            ['min' => 2, 'max' => 2, 'cost_per_pound' => 11.54],
            ['min' => 3, 'max' => 3, 'cost_per_pound' => 9.8],
            ['min' => 4, 'max' => 4, 'cost_per_pound' => 8.24],
            ['min' => 5, 'max' => 5, 'cost_per_pound' => 7.52],
            ['min' => 6, 'max' => 6, 'cost_per_pound' => 7.23],
            ['min' => 7, 'max' => 7, 'cost_per_pound' => 6.95],
            ['min' => 8, 'max' => 8.82, 'cost_per_pound' => 6.75], // Para 8+ hasta 8.82 usa 6.75
        ];
        
        $sortOrder = 0;
        foreach ($courier4x4Rates as $rate) {
            ShippingRate::create([
                'method' => 'courier4x4',
                'min_weight' => $rate['min'],
                'max_weight' => $rate['max'],
                'max_value_fob' => 400.00,
                'cost_per_pound' => $rate['cost_per_pound'],
                'fixed_cost' => 20.00, // Arancel fijo de $20
                'is_special_case' => true,
                'notes' => "Régimen Courier 4x4 - Costo por libra: \${$rate['cost_per_pound']} + Arancel fijo \$20. Vigente desde 16 de junio de 2025. Peso máximo: 4kg (8.82 lbs), Valor FOB máximo: \$400. Si no cumple condiciones, se calcula como método normal.",
                'sort_order' => $sortOrder++,
                'is_active' => true,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar tarifa courier4x4
        ShippingRate::where('method', 'courier4x4')->delete();

        Schema::table('shipping_rates', function (Blueprint $table) {
            $table->dropColumn(['fixed_cost', 'max_value_fob']);
        });
    }
};
