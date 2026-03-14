<?php

namespace Database\Seeders;

use App\Models\SeoPage;
use Illuminate\Database\Seeder;

class SeoPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'keyword' => 'importar iphone ecuador',
                'slug' => 'importar-iphone-desde-amazon-a-ecuador',
                'title' => 'Cómo importar iPhone desde Amazon a Ecuador',
                'content' => '<p>Importar un iPhone desde Amazon a Ecuador es un proceso sencillo con Flat Rate Imports. Te guiamos paso a paso:</p><ul><li>Compra tu iPhone en Amazon USA</li><li>Usa nuestra dirección de casillero en USA</li><li>Recibimos el paquete y lo importamos</li><li>Te entregamos en Ecuador</li></ul><p>Usa el cotizador para conocer el costo total de importación.</p>',
                'store_link' => 'https://flatrateimports.store/search?q=iphone',
                'meta_description' => 'Guía para importar iPhone desde Amazon a Ecuador. Costos, aranceles y proceso con Flat Rate Imports.',
                'is_active' => true,
            ],
            [
                'keyword' => 'importar laptop ecuador',
                'slug' => 'importar-laptop-desde-amazon-a-ecuador',
                'title' => 'Importar Laptop desde Amazon a Ecuador',
                'content' => '<p>Importa tu laptop desde Amazon USA a Ecuador con Flat Rate Imports. Incluye envío, impuestos y seguro.</p><p>Calcula el costo total con nuestro cotizador integrado.</p>',
                'store_link' => 'https://flatrateimports.store/search?q=laptop',
                'meta_description' => 'Importa laptops desde Amazon a Ecuador. Cotiza envío, impuestos y costos totales.',
                'is_active' => true,
            ],
            [
                'keyword' => 'importar desde amazon ecuador',
                'slug' => 'importar-desde-amazon',
                'title' => 'Importar desde Amazon a Ecuador',
                'content' => '<p>Flat Rate Imports te permite comprar en Amazon USA y recibir en Ecuador. Proceso simple: compras, envías a nuestro casillero, importamos y entregamos.</p><p>Usa el cotizador para estimar costos.</p>',
                'store_link' => 'https://flatrateimports.store/',
                'meta_description' => 'Importa desde Amazon USA a Ecuador. Casillero postal, cotizador y envío seguro.',
                'is_active' => true,
            ],
            [
                'keyword' => 'importar desde aliexpress ecuador',
                'slug' => 'importar-desde-aliexpress',
                'title' => 'Importar desde AliExpress a Ecuador',
                'content' => '<p>Importa productos desde AliExpress a Ecuador con Flat Rate Imports. Recibe en nuestro casillero en USA y te lo enviamos a Ecuador.</p>',
                'store_link' => 'https://flatrateimports.store/',
                'meta_description' => 'Importa desde AliExpress a Ecuador. Casillero en USA y envío a Ecuador.',
                'is_active' => true,
            ],
            [
                'keyword' => 'importar desde ebay ecuador',
                'slug' => 'importar-desde-ebay',
                'title' => 'Importar desde eBay a Ecuador',
                'content' => '<p>Compra en eBay USA y recibe en Ecuador. Flat Rate Imports te ofrece casillero postal y servicio de importación.</p>',
                'store_link' => 'https://flatrateimports.store/',
                'meta_description' => 'Importa desde eBay a Ecuador. Casillero postal y envío seguro.',
                'is_active' => true,
            ],
            // Comparadores (Fase 14.3)
            [
                'keyword' => 'mejor courier ecuador',
                'slug' => 'mejor-courier-ecuador',
                'title' => 'Mejor Courier Ecuador 2026 - Comparativa',
                'content' => '<p>Compara los mejores servicios de courier para importar a Ecuador. Flat Rate Imports ofrece Courier 4x4, aéreo y marítimo con precios competitivos.</p><p>Usa el cotizador para comparar costos según tu envío.</p>',
                'store_link' => 'https://flatrateimports.store/',
                'meta_description' => 'Comparativa de couriers para importar a Ecuador. Precios, tiempos y opciones.',
                'is_active' => true,
            ],
            [
                'keyword' => 'costos importar amazon ecuador',
                'slug' => 'costos-importar-amazon-ecuador',
                'title' => 'Costos de Importar desde Amazon a Ecuador',
                'content' => '<p>¿Cuánto cuesta importar desde Amazon a Ecuador? Incluye envío, aranceles, IVA y seguro. Calcula con nuestra herramienta gratuita.</p>',
                'store_link' => 'https://flatrateimports.store/search?q=amazon',
                'meta_description' => 'Costos reales de importar desde Amazon a Ecuador. Calculadora gratuita.',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            SeoPage::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
