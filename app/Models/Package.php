<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Package extends Model
{
    protected $fillable = [
        'user_id',
        'tracking_number',
        'carrier',
        'status',
        'origin',
        'destination',
        'description',
        'weight',
        'value',
        'shipped_date',
        'estimated_delivery',
        'delivered_date',
        'tracking_history',
        'notes',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'value' => 'decimal:2',
        'shipped_date' => 'date',
        'estimated_delivery' => 'date',
        'delivered_date' => 'date',
        'tracking_history' => 'array',
    ];

    /**
     * Relación con el usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Buscar paquete por número de tracking
     */
    public static function findByTracking(string $trackingNumber): ?self
    {
        return static::where('tracking_number', $trackingNumber)->first();
    }

    /**
     * Scope para buscar por número de tracking (búsqueda flexible)
     */
    public function scopeByTracking($query, string $trackingNumber)
    {
        return $query->where('tracking_number', 'like', "%{$trackingNumber}%");
    }
}
