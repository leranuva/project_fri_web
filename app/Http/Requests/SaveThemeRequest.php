<?php

namespace App\Http\Requests;

use App\Support\ThemePalette;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class SaveThemeRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = ['name' => ['required', 'string', 'max:255']];

        foreach (array_keys(ThemePalette::DEFAULTS) as $field) {
            $translucent = in_array($field, ThemePalette::TRANSLUCENT_FIELDS, true);
            $rules[$field] = [
                'bail', $translucent ? 'nullable' : 'required', 'string', 'max:64',
                function (string $attribute, mixed $value, Closure $fail) use ($translucent): void {
                    if (ThemePalette::normalize($value, $attribute) === null) {
                        $fail($translucent
                            ? 'Introduce un color hexadecimal, RGB o RGBA válido.'
                            : 'Introduce un color hexadecimal válido.');
                    }
                },
            ];
        }

        return $rules;
    }

    public function paletteData(): array
    {
        $data = $this->validated();

        foreach (ThemePalette::DEFAULTS as $field => $default) {
            $data[$field] = ThemePalette::normalize($data[$field] ?? null, $field) ?? $default;
        }

        return $data;
    }
}
