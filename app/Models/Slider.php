<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'video',
        'cta',
        'cta_link',
        'order',
        'is_active',
        'title_color',
        'subtitle_color',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Scope a query to only include active sliders.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order sliders by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get YouTube embed URL if the video URL is from YouTube, null otherwise.
     * Supports: youtube.com/watch?v=ID, youtu.be/ID, youtube.com/embed/ID
     */
    public static function getYouTubeEmbedUrl(?string $url): ?string
    {
        if (!$url || !str_contains($url, 'youtube') && !str_contains($url, 'youtu.be')) {
            return null;
        }
        $id = null;
        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $m)) {
            $id = $m[1];
        } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $m)) {
            $id = $m[1];
        } elseif (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $url, $m)) {
            $id = $m[1];
        }
        if (!$id) {
            return null;
        }
        return 'https://www.youtube.com/embed/' . $id . '?autoplay=1&mute=1&loop=1&playlist=' . $id . '&controls=0&showinfo=0&rel=0';
    }

    /**
     * Check if the video URL is from YouTube.
     */
    public static function isYouTubeUrl(?string $url): bool
    {
        return self::getYouTubeEmbedUrl($url) !== null;
    }
}
