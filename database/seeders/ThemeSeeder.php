<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themes = [
            [
                'name' => 'Tema Púrpura (Por Defecto)',
                'primary_color' => '#667eea',
                'secondary_color' => '#764ba2',
                'accent_color' => '#f093fb',
                'background_gradient_start' => '#667eea',
                'background_gradient_mid' => '#764ba2',
                'background_gradient_end' => '#f093fb',
                'text_color' => '#ffffff',
                'text_secondary_color' => 'rgba(255, 255, 255, 0.8)',
                'button_color' => 'rgba(255, 255, 255, 0.3)',
                'is_active' => true,
            ],
            [
                'name' => 'Tema Azul',
                'primary_color' => '#3b82f6',
                'secondary_color' => '#1e40af',
                'accent_color' => '#60a5fa',
                'background_gradient_start' => '#3b82f6',
                'background_gradient_mid' => '#1e40af',
                'background_gradient_end' => '#60a5fa',
                'text_color' => '#ffffff',
                'text_secondary_color' => 'rgba(255, 255, 255, 0.8)',
                'button_color' => 'rgba(255, 255, 255, 0.3)',
                'is_active' => false,
            ],
            [
                'name' => 'Tema Verde',
                'primary_color' => '#10b981',
                'secondary_color' => '#059669',
                'accent_color' => '#34d399',
                'background_gradient_start' => '#10b981',
                'background_gradient_mid' => '#059669',
                'background_gradient_end' => '#34d399',
                'text_color' => '#ffffff',
                'text_secondary_color' => 'rgba(255, 255, 255, 0.8)',
                'button_color' => 'rgba(255, 255, 255, 0.3)',
                'is_active' => false,
            ],
            [
                'name' => 'Tema Dance Studio',
                'primary_color' => '#e91e63',
                'secondary_color' => '#9c27b0',
                'accent_color' => '#ff9800',
                'background_gradient_start' => '#e91e63',
                'background_gradient_mid' => '#9c27b0',
                'background_gradient_end' => '#ff9800',
                'text_color' => '#ffffff',
                'text_secondary_color' => 'rgba(255, 255, 255, 0.9)',
                'button_color' => 'rgba(255, 255, 255, 0.25)',
                'is_active' => false,
            ],
        ];

        $this->command->info('Poblando tabla de temas...');

        $bar = $this->command->getOutput()->createProgressBar(count($themes));
        $bar->start();

        foreach ($themes as $themeData) {
            Theme::updateOrCreate(
                ['name' => $themeData['name']],
                $themeData
            );
            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine();
        $this->command->info('✓ Temas insertados: ' . count($themes));
    }
}
