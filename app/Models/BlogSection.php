<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'title_color',
        'footer_text',
        'button_text',
        'button_link',
        'cta_button_text',
        'cta_button_visible',
        'cta_button_animated',
        'cta_button_bg_color',
        'cta_button_border_color',
        'cta_button_text_color',
        'cta_button_url_base',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'cta_button_visible' => 'boolean',
            'cta_button_animated' => 'boolean',
        ];
    }

    /**
     * Get the active blog section (singleton).
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }
}
