<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
            'published_at' => 'immutable_datetime',
        ];
    }

    public static function getActive(): ?self
    {
        return static::where('is_active', true)->orderBy('id')->first();
    }

    public static function lockForPublication(): void
    {
        static::orderBy('id')->lockForUpdate()->get(['id']);
    }

    public function activate(): void
    {
        DB::transaction(function (): void {
            static::lockForPublication();
            $theme = static::findOrFail($this->getKey());
            if ($theme->is_active) {
                return;
            }

            static::where('is_active', true)->update(['is_active' => false]);
            // Bind the timestamp explicitly to retain microseconds for restore ordering.
            static::whereKey($theme->getKey())->update([
                'is_active' => true,
                'published_at' => now()->format('Y-m-d H:i:s.u'),
            ]);
        }, 3);

        $this->refresh();
    }
}
