@props(['src' => null, 'alt' => 'Flat Rate Imports'])

<img src="{{ $src ?? $brandLogoUrl }}" alt="{{ $alt }}"
    {{ $attributes->merge(['style' => 'width: calc(var(--brand-logo-size, 100%) * 0.9); height: calc(var(--brand-logo-size, 100%) * 0.9); flex-shrink: 0; max-width: none; object-fit: contain;']) }}>
