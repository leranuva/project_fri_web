<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\SeoPage;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generar sitemap.xml dinámico (Fase 8)
     */
    public function index(): Response
    {
        $urls = collect();

        // Páginas estáticas principales
        $staticPages = [
            ['url' => route('home'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['url' => route('cotizador'), 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => url('/tracking'), 'priority' => '0.8', 'changefreq' => 'monthly'],
        ];

        foreach ($staticPages as $page) {
            $urls->push($page);
        }

        // Calculadoras virales (Fase 13)
        $urls->push(['url' => route('calculator.aranceles'), 'priority' => '0.8', 'changefreq' => 'monthly']);
        $urls->push(['url' => route('calculator.courier4x4'), 'priority' => '0.8', 'changefreq' => 'monthly']);
        $urls->push(['url' => route('calculator.amazon'), 'priority' => '0.8', 'changefreq' => 'monthly']);

        // Páginas de importación (si existen como rutas o SEO pages)
        $importPages = [
            '/importar-desde-amazon',
            '/importar-desde-aliexpress',
            '/importar-desde-ebay',
        ];

        foreach ($importPages as $path) {
            $urls->push([
                'url' => url($path),
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ]);
        }

        // Páginas SEO dinámicas
        $seoPages = SeoPage::active()->get();
        foreach ($seoPages as $page) {
            $urls->push([
                'url' => url('/' . $page->slug),
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ]);
        }

        // Blog index y posts
        $urls->push(['url' => url('/blog'), 'priority' => '0.7', 'changefreq' => 'weekly']);
        $blogPosts = BlogPost::active()->published()->get();
        foreach ($blogPosts as $post) {
            $slug = \Illuminate\Support\Str::slug($post->title);
            $urls->push([
                'url' => url("/blog/{$post->id}-{$slug}"),
                'priority' => '0.6',
                'changefreq' => 'monthly',
            ]);
        }

        $xml = $this->buildXml($urls);

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
            'Charset' => 'UTF-8',
        ]);
    }

    private function buildXml($urls): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $item) {
            $url = is_array($item) ? $item['url'] : $item;
            $priority = $item['priority'] ?? '0.5';
            $changefreq = $item['changefreq'] ?? 'monthly';

            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($url) . '</loc>' . "\n";
            $xml .= '    <changefreq>' . $changefreq . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $priority . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
