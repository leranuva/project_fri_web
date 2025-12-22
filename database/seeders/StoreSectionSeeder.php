<?php

namespace Database\Seeders;

use App\Models\StoreSection;
use Illuminate\Database\Seeder;

class StoreSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StoreSection::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Compra en todas estas tiendas',
                'subtitle' => '¡Y muchas más!',
                'title_color' => '#ffffff',
                'subtitle_color' => 'rgba(255, 255, 255, 0.8)',
                'footer_link' => 'https://flatrateimports.store/',
                'footer_link_text' => 'Revisar todas las tiendas',
                'is_active' => true,
            ]
        );
    }
}
