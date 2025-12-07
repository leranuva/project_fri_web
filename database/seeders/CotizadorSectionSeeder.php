<?php

namespace Database\Seeders;

use App\Models\CotizadorSection;
use Illuminate\Database\Seeder;

class CotizadorSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Poblando tabla de configuración del cotizador...');
        
        $section = [
            'title' => 'Cotizador de Importaciones',
            'description' => 'Completa el formulario para obtener una cotización personalizada de tus importaciones.',
            'title_color' => '#ffffff',
            'section_title_color' => '#ffffff',
            'product_label_color' => '#ffffff',
            'quantity_label_color' => '#ffffff',
            'weight_label_color' => '#ffffff',
            'unit_value_label_color' => '#ffffff',
            'shipping_method_label_color' => '#ffffff',
            'is_active' => true,
        ];

        CotizadorSection::updateOrCreate(
            ['id' => 1],
            $section
        );

        $this->command->info('✓ Configuración del cotizador insertada correctamente');
    }
}
