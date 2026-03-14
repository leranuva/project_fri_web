<?php

namespace Database\Seeders;

use App\Models\TaxRate;
use Illuminate\Database\Seeder;

class TaxRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxes = config('products.taxes', []);
        
        $this->command->info('Poblando tabla de impuestos...');
        
        $taxLabels = [
            'fodinfa' => 'Fodinfa',
            'iva' => 'IVA',
            'seguro_cif' => 'Seguro CIF',
        ];
        
        $taxDescriptions = [
            'fodinfa' => 'Fondo de Desarrollo de la Infraestructura Nacional (0.5%)',
            'iva' => 'Impuesto al Valor Agregado (12%)',
            'seguro_cif' => 'Seguro sobre el valor CIF (Costo, Seguro y Flete) (2.5%)',
        ];
        
        foreach ($taxes as $name => $rate) {
            TaxRate::updateOrCreate(
                ['name' => $name],
                [
                    'name' => $name,
                    'label' => $taxLabels[$name] ?? ucfirst($name),
                    'rate' => $rate,
                    'description' => $taxDescriptions[$name] ?? null,
                    'is_active' => true,
                ]
            );
        }
        
        $this->command->info('✓ Impuestos insertados: ' . count($taxes));
    }
}
