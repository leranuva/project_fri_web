<?php

namespace Database\Seeders;

use App\Models\AlertBanner;
use App\Models\Benefit;
use App\Models\BlogPost;
use App\Models\FooterLink;
use App\Models\FooterSection;
use App\Models\ProcessSection;
use App\Models\ProcessStep;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Store;
use App\Models\StoreSection;
use App\Models\Theme;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class LocalPublicSitePreviewSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment('local')) {
            throw new RuntimeException('Esta vista previa solo se puede cargar en el entorno local.');
        }

        foreach (['carousel' => 6, 'blog' => 4] as $group => $count) {
            for ($index = 1; $index <= $count; $index++) {
                if (! Storage::disk('public')->exists("fri-preview/$group-$index.webp")) {
                    throw new RuntimeException("Falta la imagen local de prueba $group-$index.webp.");
                }
            }
        }

        $products = json_decode(
            Storage::disk('local')->get('fri-preview-products.json')
                ?? throw new RuntimeException('Falta el catálogo público de la vista previa.'),
            true,
            flags: JSON_THROW_ON_ERROR,
        );

        DB::transaction(function () use ($products): void {
            $theme = Theme::firstOrCreate(['name' => 'Flat Rate Imports · Vista previa local'], [
                'primary_color' => '#165B33',
                'secondary_color' => '#165B33',
                'accent_color' => '#BB2528',
                'background_gradient_start' => '#165B33',
                'background_gradient_mid' => '#165B33',
                'background_gradient_end' => '#BB2528',
                'button_color' => '#BB2528',
                'text_color' => '#FFFFFF',
                'text_secondary_color' => 'rgba(255, 255, 255, 0.8)',
            ]);
            $theme->activate();

            $this->loadCarousel();
            $this->loadBlog();
            $this->loadHomepageSections();
            $this->loadProducts($products);
        });

        Cache::forget('cotizador.products');
    }

    private function loadCarousel(): void
    {
        $lcl = 'https://flatrateimports.store/blogs/news/que-es-lcl-y-cuando-es-la-mejor-opcion-para-importar-desde-usa';
        $slides = [
            ['Bienvenido', 'Compras en Estados Unidos y entregas en Ecuador', 'Conoce el proceso', '#como-funciona'],
            ['Compra por internet en USA', 'Recibe tus compras en Ecuador', 'Ver producto', 'https://flatrateimports.store/products/mini-licuadoras-ninja'],
            ['Compra en Estados Unidos con facilidad', 'Recibe el pedido en Ecuador', 'Ver producto', 'https://flatrateimports.store/products/air-fryerninja-dz201-foodi-freidora-de-aire-6-en-1-dualzone'],
            ['Importaciones LCL', 'Comparte espacio en una carga consolidada', 'Ver cómo funciona', $lcl],
            ['Drones', 'Explora opciones de compra', 'Ver productos', 'https://www.amazon.com/s?k=drones'],
            ['Seguimiento de carga marítima LCL', 'Consulta el estado de tu envío', 'Ver seguimiento', 'https://flatrateimports.store/apps/track-order'],
        ];

        Slider::whereIn('title', [
            'Dirección de Casillero Postal GRATIS',
            'Proceso Fácil y Rápido',
            'Más de 10 Años de Experiencia',
            'Seguimiento de Paquetes en Tiempo Real',
        ])->update(['is_active' => false]);

        foreach ($slides as $index => [$title, $subtitle, $cta, $link]) {
            $order = $index + 1;
            Slider::updateOrCreate(['title' => $title], [
                'subtitle' => $subtitle,
                'description' => null,
                'image' => "/storage/fri-preview/carousel-$order.webp",
                'video' => null,
                'cta' => $cta,
                'cta_link' => $link,
                'order' => $order,
                'is_active' => true,
                'title_color' => '#FFFFFF',
                'subtitle_color' => '#FFFFFF',
            ]);
        }
    }

    private function loadBlog(): void
    {
        $news = 'https://flatrateimports.store/blogs/news/';
        $posts = [
            [
                'Cómo Importar Productos desde USA',
                'Todo lo que necesitas saber para importar de USA con Flat Rate.',
                'Conoce los pasos para traer a Ecuador lo que compras por internet en Estados Unidos.',
                'Regístrate para obtener tu casillero. Usa esa dirección al hacer la compra, avisa del envío desde tu panel y consulta la guía original para conocer el proceso de entrega.',
                $news . 'como-funciona-una-importacion',
                'Ir a una tienda',
                'https://www.amazon.com/',
            ],
            [
                null,
                'Cómo importar productos desde USA a Ecuador con nosotros',
                'Descubre cómo recibir en Ecuador pedidos de Amazon, eBay o Apple.',
                'Cotiza con el peso y precio del artículo. Cuando hagas tu pedido, usa tu casillero como dirección de envío y registra la información de la compra para facilitar su identificación.',
                $news . 'como-importar-productos-desde-usa-a-ecuador',
                'Obtener tu casillero',
                null,
            ],
            [
                'Beneficios de Usar un Casillero Postal',
                'Beneficios de Usar un Casillero Postal.',
                'Una dirección en Estados Unidos facilita las compras en tiendas que solo ofrecen entrega local.',
                'El casillero recibe tu pedido en Estados Unidos y te permite registrar las compras antes del envío a Ecuador. Puedes consultar el seguimiento desde tu panel.',
                $news . 'beneficios-de-usar-un-casillero-postal',
                'Ir a una tienda',
                'https://www.macys.com/',
            ],
            [
                null,
                'Tips para Ahorrar en Importaciones',
                'Ideas para estimar el costo de una compra antes de importarla.',
                'Compara métodos de envío, revisa el peso del pedido y usa el cotizador para estimar los cargos. Ten en cuenta el costo de entrega de la tienda al casillero.',
                null,
                'Cotizar mi envío',
                route('cotizador'),
            ],
        ];

        foreach ($posts as $index => [$previousTitle, $title, $excerpt, $content, $link, $cta, $ctaLink]) {
            $order = $index + 1;
            $post = BlogPost::firstOrNew(['title' => $title]);
            if (! $post->exists && $previousTitle) {
                $post = BlogPost::where('title', $previousTitle)->first() ?? $post;
            }
            $post->fill([
                'title' => $title,
                'excerpt' => $excerpt,
                'content' => $content,
                'featured_image_url' => "/storage/fri-preview/blog-$order.webp",
                'link' => $link,
                'cta_text' => $cta,
                'cta_link' => $ctaLink,
                'cta_active' => true,
                'order' => $order,
                'is_active' => true,
                'published_at' => $post->published_at ?? now(),
            ])->save();
        }
    }

    private function loadProducts(array $products): void
    {
        foreach ($products as $key => $data) {
            $product = Product::firstOrNew(['key' => $key]);
            if (! $product->exists) {
                $product->ad_valorem = $data['adValorem'];
                $product->arancel_especifico = $data['arancelEspecifico'];
            }

            $product->name = $data['name'];
            $product->is_active = true;
            $product->save();
        }
    }

    private function loadHomepageSections(): void
    {
        ProcessSection::where('is_active', true)->firstOrFail()->update([
            'subtitle' => 'Compra, avisa desde tu panel y recibe tu pedido en Ecuador.',
            'footer_text' => 'Flat Rate Imports lleva más de siete años gestionando importaciones.',
            'button_text' => '¿Qué es un LCL?',
            'button_link' => 'https://flatrateimports.store/blogs/news/que-es-lcl-y-cuando-es-la-mejor-opcion-para-importar-desde-usa',
        ]);

        ProcessStep::where('step_number', 4)->update([
            'description' => 'Importamos el paquete y lo entregamos en Ecuador.',
        ]);

        AlertBanner::where('is_active', true)->firstOrFail()->update([
            'title' => '¡No olvides alertar tu compra!',
            'description' => 'Avisa de tu compra para que podamos identificar el paquete y evitar retrasos.',
        ]);

        Benefit::where('title', 'Seguridad')->update([
            'description' => 'Más de siete años de experiencia en el manejo de envíos.',
        ]);

        StoreSection::where('is_active', true)->firstOrFail()->update([
            'title' => 'Compra en todas estas tiendas',
            'subtitle' => '¡Y muchas más!',
            'footer_link' => 'https://flatrateimports.store/',
            'footer_link_text' => 'Ir a la tienda',
        ]);

        Store::updateOrCreate(['name' => 'Flat Rate'], [
            'logo_image' => '/logo_fri.png',
            'website_url' => 'https://flatrateimports.store/',
            'order' => 0,
            'is_active' => true,
        ]);

        FooterSection::where('is_active', true)->firstOrFail()->update([
            'copyright_text' => '© ' . date('Y') . ' Flat Rate Imports. All rights reserved.',
        ]);

        FooterLink::updateOrCreate(['label' => 'Preguntas frecuentes', 'type' => 'link'], [
            'url' => 'https://flatrateimports.store/pages/faq',
            'order' => 0,
            'is_active' => true,
        ]);
    }
}
