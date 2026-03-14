<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteShare extends Model
{
    protected $fillable = [
        'token',
        'quote_data',
        'views',
        'expires_at',
    ];

    protected $casts = [
        'quote_data' => 'array',
        'expires_at' => 'datetime',
    ];

    public static function generateToken(): string
    {
        do {
            $token = bin2hex(random_bytes(12));
        } while (static::where('token', $token)->exists());

        return $token;
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
