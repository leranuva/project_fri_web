@props(['src' => null, 'alt' => 'Flat Rate Imports'])

<img src="{{ $src ?? $brandLogoUrl }}" alt="{{ $alt }}" {{ $attributes }}>
