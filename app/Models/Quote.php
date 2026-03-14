<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quote extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'product_key',
        'weight',
        'fob',
        'quantity',
        'shipping_method',
        'total',
        'details',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'fob' => 'decimal:2',
        'total' => 'decimal:2',
        'details' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope para cotizaciones de un usuario
     */
    public function scopeForUser($query, ?int $userId)
    {
        if ($userId) {
            return $query->where('user_id', $userId);
        }

        return $query->whereNull('user_id');
    }
}
