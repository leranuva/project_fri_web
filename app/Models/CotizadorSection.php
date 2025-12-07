<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizadorSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'title_color',
        'section_title_color',
        'product_label_color',
        'quantity_label_color',
        'weight_label_color',
        'unit_value_label_color',
        'shipping_method_label_color',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the active cotizador section (singleton).
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }
}
