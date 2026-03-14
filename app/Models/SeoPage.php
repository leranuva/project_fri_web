<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeoPage extends Model
{
    protected $fillable = [
        'keyword',
        'slug',
        'title',
        'content',
        'product_id',
        'store_link',
        'is_active',
        'meta_description',
        'og_image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function findBySlug(string $slug): ?self
    {
        return static::active()->where('slug', $slug)->first();
    }
}
