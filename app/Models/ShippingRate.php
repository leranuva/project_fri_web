<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'method',
        'min_weight',
        'max_weight',
        'max_value_fob',
        'cost_per_pound',
        'fixed_cost',
        'is_special_case',
        'notes',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'min_weight' => 'decimal:2',
        'max_weight' => 'decimal:2',
        'max_value_fob' => 'decimal:2',
        'cost_per_pound' => 'decimal:2',
        'fixed_cost' => 'decimal:2',
        'is_special_case' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope para tarifas activas
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para método específico
     */
    public function scopeForMethod($query, string $method)
    {
        return $query->where('method', $method);
    }

    /**
     * Scope para ordenar por sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('min_weight');
    }

    /**
     * Buscar tarifa por peso y método
     */
    public static function findRate(string $method, float $weight): ?self
    {
        return static::active()
            ->forMethod($method)
            ->where('min_weight', '<=', $weight)
            ->where(function ($query) use ($weight) {
                $query->whereNull('max_weight')
                      ->orWhere('max_weight', '>=', $weight);
            })
            ->ordered()
            ->first();
    }

    /**
     * Obtener el peso mínimo de las tarifas activas para un método
     */
    public static function getMinWeightForMethod(string $method): ?float
    {
        $rate = static::active()
            ->forMethod($method)
            ->orderBy('min_weight')
            ->first();
        
        return $rate ? (float) $rate->min_weight : null;
    }

    /**
     * Obtener el peso máximo de las tarifas activas para un método
     */
    public static function getMaxWeightForMethod(string $method): ?float
    {
        $rate = static::active()
            ->forMethod($method)
            ->whereNotNull('max_weight')
            ->orderByDesc('max_weight')
            ->first();
        
        return $rate ? (float) $rate->max_weight : null;
    }

    /**
     * Obtener información de rangos de peso para un método
     */
    public static function getWeightRangesForMethod(string $method): array
    {
        $rates = static::active()
            ->forMethod($method)
            ->ordered()
            ->get();
        
        if ($rates->isEmpty()) {
            return [
                'min_weight' => null,
                'max_weight' => null,
                'has_unlimited' => false,
                'ranges' => []
            ];
        }
        
        $minWeight = $rates->min('min_weight');
        $maxWeight = $rates->whereNotNull('max_weight')->max('max_weight');
        $hasUnlimited = $rates->whereNull('max_weight')->isNotEmpty();
        
        $ranges = $rates->map(function ($rate) {
            return [
                'min' => (float) $rate->min_weight,
                'max' => $rate->max_weight ? (float) $rate->max_weight : null,
            ];
        })->toArray();
        
        return [
            'min_weight' => (float) $minWeight,
            'max_weight' => $maxWeight ? (float) $maxWeight : null,
            'has_unlimited' => $hasUnlimited,
            'ranges' => $ranges
        ];
    }
}
