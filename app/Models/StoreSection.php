<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'title_color',
        'subtitle_color',
        'footer_link',
        'footer_link_text',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the active store section (singleton).
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }
}
