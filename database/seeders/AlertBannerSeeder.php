<?php

namespace Database\Seeders;

use App\Models\AlertBanner;
use Illuminate\Database\Seeder;

class AlertBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Poblando tabla de banners de alerta...');
        
        $banner = [
            'title' => '¡NO OLVIDES ALERTAR TU COMPRA!',
            'description' => 'Alertar la compra evitará retrasos en la importación y permitirá identificar el paquete con facilidad.',
            'icon_svg' => '<svg class="w-16 h-16 mx-auto text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>',
            'button_text_auth' => 'Alertar Compra',
            'button_link_auth' => '/dashboard',
            'button_text_guest' => 'Registrarse para Alertar',
            'button_link_guest' => '/register',
            'is_active' => true,
        ];

        AlertBanner::updateOrCreate(
            ['title' => $banner['title']],
            $banner
        );

        $this->command->info('✓ Banner de alerta insertado correctamente');
    }
}
