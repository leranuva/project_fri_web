<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'featured_image_url',
        'link',
        'cta_text',
        'cta_link',
        'cta_active',
        'order',
        'is_active',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'cta_active' => 'boolean',
            'order' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Get the CTA link URL (uses store URL if not set or invalid).
     */
    public function getCtaUrlAttribute(): string
    {
        if ($this->cta_link && filter_var($this->cta_link, FILTER_VALIDATE_URL)) {
            return $this->cta_link;
        }
        return config('seo.store_url');
    }

    /**
     * Get the CTA button text (uses default if not set).
     */
    public function getCtaLabelAttribute(): string
    {
        return $this->cta_text ?: 'Ir a la tienda';
    }

    /**
     * Scope a query to only include active blog posts.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order blog posts by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Scope a query to only include published blog posts.
     */
    public function scopePublished($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            });
    }
}
