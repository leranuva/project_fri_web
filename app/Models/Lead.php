<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'email',
        'producto',
        'valor',
        'pais',
        'score',
        'quote_count',
        'source',
        'metadata',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'metadata' => 'array',
    ];

    /**
     * Calcular score del lead según valor, producto y frecuencia
     */
    public static function calculateScore(?float $valor, ?string $producto, int $quoteCount = 1): int
    {
        $score = 0;

        // Por valor de cotización (hasta 50 puntos)
        if ($valor) {
            if ($valor >= 1000) {
                $score += 50;
            } elseif ($valor >= 500) {
                $score += 35;
            } elseif ($valor >= 200) {
                $score += 20;
            } elseif ($valor >= 50) {
                $score += 10;
            }
        }

        // Por producto de alto valor (hasta 30 puntos)
        $highValueProducts = ['Electronica', 'Laptops', 'Celulares', 'iPhone', 'Electronics'];
        if ($producto) {
            foreach ($highValueProducts as $p) {
                if (stripos($producto, $p) !== false) {
                    $score += 30;
                    break;
                }
            }
        }

        // Por frecuencia de cotizaciones (hasta 20 puntos)
        if ($quoteCount >= 5) {
            $score += 20;
        } elseif ($quoteCount >= 3) {
            $score += 10;
        } elseif ($quoteCount >= 2) {
            $score += 5;
        }

        return min($score, 100);
    }
}
