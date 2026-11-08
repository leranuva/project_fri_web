<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        return static::active()->orderByDesc('id')->first();
    }

    public static function activeImageUrl(): string
    {
        return static::getActive()?->imageUrl() ?? asset('logo_fri.png');
    }

    public function imageUrl(): ?string
    {
        $path = ltrim((string) $this->image_path, '/');

        if ($path !== '' && ! str_contains($path, '..')) {
            if (str_starts_with($path, 'storage/logos/')) {
                $disk = Storage::disk('public');
                $key = substr($path, 8);
                if ($disk->exists($key)) {
                    return $disk->url($key);
                }
            } elseif (is_file(public_path($path))) {
                return asset($path);
            }
        }

        return null;
    }

    public function originalKey(): ?string
    {
        return self::sourceKey($this->image_path);
    }

    public static function sourceKey(?string $path): ?string
    {
        if (preg_match('~^storage/logos/([a-z0-9-]+)\.webp$~iD', $path ?? '', $match)) {
            return 'logos/' . $match[1] . '.source';
        }

        return null;
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
