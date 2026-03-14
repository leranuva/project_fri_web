<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_path',
        'is_active',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Scope a query to only include active logos.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order logos by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get the active logo.
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Activate this logo and deactivate others.
     */
    public function activate()
    {
        // Desactivar todos los logos
        static::where('id', '!=', $this->id)->update(['is_active' => false]);
        
        // Activar este logo
        $this->update(['is_active' => true]);
    }
}
