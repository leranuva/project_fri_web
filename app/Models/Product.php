<?php

namespace App\Models;

use App\Services\Cotizador\Catalog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        $invalidateCatalog = static function (self $model): void {
            $model->getConnection()->afterCommit(
                static fn () => Cache::forget(Catalog::PRODUCTS_CACHE_KEY)
            );
        };

        static::saved($invalidateCatalog);
        static::deleted($invalidateCatalog);
    }

    protected $fillable = [
        'key',
        'name',
        'arancel_code',
        'arancel_subpartida',
        'ad_valorem',
        'arancel_especifico',
        'new_percent',
        'description',
        'category',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'ad_valorem' => 'decimal:4',
        'arancel_especifico' => 'decimal:2',
        'new_percent' => 'decimal:4',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope para productos activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para ordenar por sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Obtener producto por clave
     */
    public static function findByKey(string $key): ?self
    {
        return static::where('key', $key)->first();
    }
}
