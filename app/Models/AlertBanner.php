<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertBanner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'icon_svg',
        'button_text_auth',
        'button_link_auth',
        'button_text_guest',
        'button_link_guest',
        'background_color',
        'title_color',
        'description_color',
        'container_color',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include active alert banners.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
