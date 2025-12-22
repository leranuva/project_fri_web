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
                'subtitle' => 'Descubre artículos y noticias relevantes sobre importaciones y comercio internacional.',
                'title_color' => '#ffffff',
                'footer_text' => 'Mantente informado con nuestros artículos sobre importaciones, regulaciones y consejos útiles.',
                'button_text' => 'Ver Blog',
                'button_link' => '#',
                'is_active' => true,
            ]
        );
    }
}
