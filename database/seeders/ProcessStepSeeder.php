<?php

namespace Database\Seeders;

use App\Models\ProcessStep;
use Illuminate\Database\Seeder;

class ProcessStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $processSteps = [
            [
                'step_number' => 1,
                'title' => 'Compras',
                'description' => 'Compra en tu tienda online favorita y envía al casillero',
                'icon_svg' => '<svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'step_number' => 2,
                'title' => 'Alertas',
                'description' => 'Recibe alertas en tu panel de usuario cuando llegue tu paquete',
                'icon_svg' => '<svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'step_number' => 3,
                'title' => 'Recibimos',
                'description' => 'Recibimos tu paquete en nuestra casilla postal en USA',
                'icon_svg' => '<svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'step_number' => 4,
                'title' => 'Importamos',
                'description' => 'Importamos y entregamos hasta tus manos de forma segura',
                'icon_svg' => '<svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        $this->command->info('Poblando tabla de pasos del proceso...');
        
        $bar = $this->command->getOutput()->createProgressBar(count($processSteps));
        $bar->start();

        foreach ($processSteps as $stepData) {
            ProcessStep::updateOrCreate(
                ['step_number' => $stepData['step_number']],
                $stepData
            );
            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine();
        $this->command->info('✓ Pasos del proceso insertados: ' . count($processSteps));
    }
}
