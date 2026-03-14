<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'url',
        'type',
        'icon_svg',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Scope a query to only include active footer links.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order footer links by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Scope a query to only include links (not social).
     */
    public function scopeLinks($query)
    {
        return $query->where('type', 'link');
    }

    /**
     * Scope a query to only include social links.
     */
    public function scopeSocial($query)
    {
        return $query->where('type', 'social');
    }
}
