<?php

namespace Database\Seeders;

use App\Models\ProcessSection;
use Illuminate\Database\Seeder;

class ProcessSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Poblando tabla de configuración de sección de proceso...');
        
        $section = [
            'title' => '¿CÓMO FUNCIONA FLAT RATE IMPORTS?',
            'subtitle' => 'El proceso es fácil: compras, alertas en tu panel de usuario, recibimos en la casilla, importamos.',
            'footer_text' => 'FLAT RATE IMPORTS tiene más de 10 años en el mercado, ofreciendo seguridad y rapidez en tus entregas.',
            'button_text' => 'Más Información',
            'button_link' => '/cotizador',
            'is_active' => true,
        ];

        ProcessSection::updateOrCreate(
            ['id' => 1],
            $section
        );

        $this->command->info('✓ Configuración de sección insertada correctamente');
    }
}
