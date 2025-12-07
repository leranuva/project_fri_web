<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Cómo Importar Productos desde USA',
                'excerpt' => 'Guía completa sobre el proceso de importación de productos desde Estados Unidos a tu país.',
                'content' => 'Contenido completo del artículo sobre importación de productos...',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Beneficios de Usar un Casillero Postal',
                'excerpt' => 'Descubre todas las ventajas de tener una dirección de casillero postal en USA.',
                'content' => 'Contenido completo del artículo sobre beneficios del casillero postal...',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Tips para Ahorrar en Importaciones',
                'excerpt' => 'Consejos prácticos para reducir costos en tus importaciones y maximizar tus ahorros.',
                'content' => 'Contenido completo del artículo sobre tips para ahorrar...',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::updateOrCreate(
                ['title' => $post['title']],
                [
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'content' => $post['content'],
                    'featured_image_url' => null,
                    'link' => null,
                    'order' => $post['order'],
                    'is_active' => $post['is_active'],
                    'published_at' => now(),
                ]
            );
        }
    }
}
