@php
    $paddingClasses = [
        'none' => '',
        'sm' => 'p-3 sm:p-4',
        'md' => 'p-4 sm:p-5',
        'default' => 'p-4 sm:p-6',
        'lg' => 'p-6 sm:p-8',
    ];

    $bgClasses = [
        'white' => 'bg-white',
        'gray' => 'bg-gray-50',
        'gray-100' => 'bg-gray-100',
    ];

    $glassmorphismClasses = $glassmorphism 
        ? 'auth-card-glass' 
        : $bgClasses[$bgColor];
    
    $shadowClasses = $glassmorphism 
        ? 'auth-card-shadow' 
        : ($shadow ? 'shadow-sm sm:shadow-md' : '');
@endphp

<div class="{{ $glassmorphismClasses }} {{ $shadowClasses }} {{ $rounded ? 'rounded-lg sm:rounded-xl' : '' }} {{ $paddingClasses[$padding] ?? $paddingClasses['default'] }} {{ $attributes->get('class') }}">
    {{ $slot }}
</div>
