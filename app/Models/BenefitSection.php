<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenefitSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_color',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the active benefit section (singleton).
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }
}
