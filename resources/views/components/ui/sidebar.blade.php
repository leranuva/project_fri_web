@php
    $positionClasses = [
        'left' => 'lg:left-0',
        'right' => 'lg:right-0',
    ];

    $widthClass = "w-full lg:w-{$width}";
@endphp

<aside 
    x-data="{ open: false }"
    class="hidden lg:block fixed top-0 bottom-0 {{ $positionClasses[$position] }} {{ $widthClass }} bg-white border-r border-gray-200 overflow-y-auto z-40"
    {{ $attributes }}
>
    {{ $slot }}
</aside>

<!-- Mobile Sidebar Toggle (opcional, se puede usar con Alpine.js) -->
<div x-show="open" 
     x-cloak
     class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-30"
     @click="open = false">
</div>
