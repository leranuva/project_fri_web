<?php

namespace Database\Seeders;

use App\Models\BlogSection;
use Illuminate\Database\Seeder;

class BlogSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogSection::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'TEMAS DE INTERÉS',
                'title_color' => '#ffffff',
                'button_text' => 'Ver Blog',
                'button_link' => '#',
                'is_active' => true,
            ]
        );
    }
}
