<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use Illuminate\Console\Command;

class GenerateBlogPostCommand extends Command
{
    protected $signature = 'blog:generate 
        {--topic= : Tema del artículo (amazon, alibaba, aranceles, courier4x4)}
        {--dry-run : No guardar, solo mostrar}';

    protected $description = 'Genera un artículo de blog desde plantilla (Fase 14.1). Para IA: integrar OpenAI/Claude.';

    private array $templates = [
        'amazon' => [
            'title' => 'Cómo importar desde Amazon a Ecuador',
            'excerpt' => 'Guía completa para comprar en Amazon USA y recibir en Ecuador. Pasos, costos y consejos.',
            'content' => "Comprar en Amazon USA y recibir en Ecuador es más fácil de lo que piensas.\n\nCon Flat Rate Imports puedes:\n- Obtener una dirección de casillero en USA gratis\n- Comprar en Amazon y enviar a nuestra dirección\n- Nosotros importamos y te entregamos en Ecuador\n\nUsa nuestro cotizador para conocer el costo total de importación.",
        ],
        'alibaba' => [
            'title' => 'Cómo importar desde Alibaba a Ecuador',
            'excerpt' => 'Importa productos desde Alibaba a Ecuador. Guía de compra, envío y aranceles.',
            'content' => "Importar desde Alibaba a Ecuador requiere un casillero internacional.\n\nFlat Rate Imports te ofrece:\n- Dirección en USA para recibir tus pedidos\n- Consolidación de paquetes\n- Importación a Ecuador con todos los trámites\n\nCotiza tu envío con nuestra calculadora.",
        ],
        'aranceles' => [
            'title' => 'Aranceles Ecuador 2026 - Guía de importación',
            'excerpt' => 'Conoce los aranceles e impuestos para importar a Ecuador. Ad-valorem, IVA, Fodinfa.',
            'content' => "Los aranceles en Ecuador incluyen:\n- Ad-valorem según partida arancelaria\n- IVA 15%\n- Fodinfa 0.5%\n- Arancel específico para algunos productos\n\nUsa nuestra calculadora de aranceles para estimar el costo.",
        ],
        'courier4x4' => [
            'title' => 'Courier 4x4 Ecuador - Envíos hasta 4kg',
            'excerpt' => 'Courier 4x4: envíos rápidos hasta 4kg y $400. Arancel fijo de $20. Ideal para electrónica.',
            'content' => "El Courier 4x4 es ideal para paquetes pequeños:\n- Hasta 4 kg (8.82 lb)\n- Valor FOB hasta $400\n- Arancel fijo de $20\n- Proceso más rápido\n\nCalcula si tu envío califica con nuestra calculadora Courier 4x4.",
        ],
    ];

    public function handle(): int
    {
        $topic = $this->option('topic') ?? array_rand($this->templates);
        $topic = is_int($topic) ? array_keys($this->templates)[$topic] : $topic;

        if (!isset($this->templates[$topic])) {
            $this->error("Tema no válido. Opciones: " . implode(', ', array_keys($this->templates)));
            return 1;
        }

        $data = $this->templates[$topic];
        $this->info("Generando: {$data['title']}");

        if ($this->option('dry-run')) {
            $this->line(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return 0;
        }

        $maxOrder = BlogPost::max('order') ?? 0;
        BlogPost::create([
            'title' => $data['title'],
            'excerpt' => $data['excerpt'],
            'content' => $data['content'],
            'order' => $maxOrder + 1,
            'is_active' => true,
            'published_at' => now(),
        ]);

        $this->info('Artículo creado.');
        return 0;
    }
}
