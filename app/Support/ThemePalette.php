<?php

namespace App\Support;

use App\Models\Theme;

final class ThemePalette
{
    public const DEFAULTS = [
        'primary_color' => '#667eea',
        'secondary_color' => '#764ba2',
        'accent_color' => '#f093fb',
        'background_gradient_start' => '#667eea',
        'background_gradient_mid' => '#764ba2',
        'background_gradient_end' => '#f093fb',
        'text_color' => '#ffffff',
        'text_secondary_color' => 'rgba(255, 255, 255, 0.8)',
        'button_color' => 'rgba(255, 255, 255, 0.3)',
    ];

    public const TRANSLUCENT_FIELDS = ['text_secondary_color', 'button_color'];

    public static function normalize(mixed $value, string $field): ?string
    {
        if (! is_string($value) || strlen($value) > 64) {
            return null;
        }

        $value = strtolower(trim($value));
        if (preg_match('/^#(?:[a-f0-9]{3}|[a-f0-9]{6})$/D', $value)) {
            return strlen($value) === 4
                ? '#' . $value[1] . $value[1] . $value[2] . $value[2] . $value[3] . $value[3]
                : $value;
        }

        if (! in_array($field, self::TRANSLUCENT_FIELDS, true)) {
            return null;
        }

        if (preg_match('/^rgb\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*\)$/D', $value, $match)) {
            $match[4] = '1';
        } elseif (! preg_match('/^rgba\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(0(?:\.\d+)?|1(?:\.0+)?|\.\d+)\s*\)$/D', $value, $match)) {
            return null;
        }

        [$red, $green, $blue] = array_map('intval', array_slice($match, 1, 3));
        if (max($red, $green, $blue) > 255) {
            return null;
        }

        $alpha = ltrim($match[4], '0');
        if ($alpha === '' || str_starts_with($alpha, '.')) {
            $alpha = '0' . $alpha;
        }

        return "rgba($red, $green, $blue, $alpha)";
    }

    public static function values(?Theme $theme): array
    {
        $palette = self::DEFAULTS;
        foreach ($palette as $field => $default) {
            $palette[$field] = self::normalize($theme?->{$field}, $field) ?? $default;
        }

        return $palette;
    }

    public static function cssVariables(array $palette): string
    {
        $variables = [];
        foreach (self::DEFAULTS as $field => $default) {
            $color = self::normalize($palette[$field] ?? null, $field) ?? $default;
            $variables[] = '--theme-' . str_replace('_', '-', $field) . ': ' . $color;
        }

        return implode('; ', $variables) . ';';
    }
}
