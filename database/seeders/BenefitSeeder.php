<?php

namespace Database\Seeders;

use App\Models\Benefit;
use Illuminate\Database\Seeder;

class BenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $benefits = [
            [
                'title' => 'Dirección GRATIS',
                'description' => 'Obtén una dirección de casillero postal en USA totalmente gratis al registrarte',
                'icon_svg' => '<svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                'order' => 1,
                'is_active' => true,
                'title_color' => '#ffffff',
                'description_color' => '#ffffff',
            ],
            [
                'title' => 'Seguridad',
                'description' => 'Más de 10 años de experiencia garantizando la seguridad de tus envíos',
                'icon_svg' => '<svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>',
                'order' => 2,
                'is_active' => true,
                'title_color' => '#ffffff',
                'description_color' => '#ffffff',
            ],
            [
                'title' => 'Rapidez',
                'description' => 'Procesos optimizados para entregas rápidas y eficientes',
                'icon_svg' => '<svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>',
                'order' => 3,
                'is_active' => true,
                'title_color' => '#ffffff',
                'description_color' => '#ffffff',
            ],
            [
                'title' => 'Precios Competitivos',
                'description' => 'Los mejores precios del mercado para tus importaciones',
                'icon_svg' => '<svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>',
                'order' => 4,
                'is_active' => true,
                'title_color' => '#ffffff',
                'description_color' => '#ffffff',
            ],
            [
                'title' => 'Panel de Usuario',
                'description' => 'Gestiona tus compras, alertas y seguimiento desde un solo lugar',
                'icon_svg' => '<svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
                'order' => 5,
                'is_active' => true,
                'title_color' => '#ffffff',
                'description_color' => '#ffffff',
            ],
            [
                'title' => 'Soporte 24/7',
                'description' => 'Atención al cliente disponible cuando la necesites',
                'icon_svg' => '<svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>',
                'order' => 6,
                'is_active' => true,
                'title_color' => '#ffffff',
                'description_color' => '#ffffff',
            ],
        ];

        foreach ($benefits as $benefit) {
            Benefit::updateOrCreate(
                ['title' => $benefit['title']],
                $benefit
            );
        }
    }
}
