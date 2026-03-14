<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'primary_color',
        'secondary_color',
        'accent_color',
        'background_gradient_start',
        'background_gradient_mid',
        'background_gradient_end',
        'text_color',
        'text_secondary_color',
        'button_color',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the active theme.
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Activate this theme (deactivates all others).
     */
    public function activate()
    {
        // Deactivate all themes
        static::where('is_active', true)->update(['is_active' => false]);
        
        // Activate this theme
        $this->update(['is_active' => true]);
    }
}
