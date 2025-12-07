<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Dirección de Casillero Postal GRATIS',
                'subtitle' => 'Te ofrecemos una dirección de casillero postal en USA totalmente GRATIS al registrarte',
                'description' => 'Compra en tu tienda online favorita, envía al casillero y nosotros lo importaremos hasta entregar en tus manos.',
                'image' => 'https://images.unsplash.com/photo-1566576912321-58a32b37819a?w=1200&h=600&fit=crop',
                'cta' => 'Registrarse Gratis',
                'cta_link' => '/register',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Proceso Fácil y Rápido',
                'subtitle' => 'El proceso es fácil: compras, alertas en tu panel, recibimos en la casilla, importamos',
                'description' => 'Gestiona todo desde tu panel de usuario. Recibe alertas cuando llegue tu paquete y sigue el proceso en tiempo real.',
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&h=600&fit=crop',
                'cta' => 'Ver Cómo Funciona',
                'cta_link' => '#como-funciona',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Más de 10 Años de Experiencia',
                'subtitle' => 'Seguridad y rapidez en tus entregas',
                'description' => 'Flat Rate Imports tiene más de 10 años en el mercado, ofreciendo seguridad y rapidez en tus entregas con la confianza que necesitas.',
                'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=1200&h=600&fit=crop',
                'cta' => 'Conocer Más',
                'cta_link' => '#beneficios',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Seguimiento de Paquetes en Tiempo Real',
                'subtitle' => 'Rastrea tus envíos desde cualquier lugar',
                'description' => 'Con nuestro sistema de tracking, podrás seguir el estado de tu paquete en cada etapa del proceso de importación.',
                'image' => 'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=1200&h=600&fit=crop',
                'cta' => 'Rastrear Paquete',
                'cta_link' => '#tracking',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        $this->command->info('Poblando tabla de sliders...');
        
        $bar = $this->command->getOutput()->createProgressBar(count($sliders));
        $bar->start();

        foreach ($sliders as $sliderData) {
            Slider::updateOrCreate(
                ['title' => $sliderData['title']],
                $sliderData
            );
            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine();
        $this->command->info('✓ Sliders insertados: ' . count($sliders));
    }
}
