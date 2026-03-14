@php
    $variantClasses = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white border-transparent',
        'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-800 border-transparent',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white border-transparent',
        'success' => 'bg-green-600 hover:bg-green-700 text-white border-transparent',
        'outline' => 'bg-transparent hover:bg-gray-100 text-gray-700 border-gray-300',
    ];

    $sizeClasses = [
        'sm' => 'text-sm px-3 py-1.5 sm:px-4 sm:py-2',
        'default' => 'text-sm px-4 py-2 sm:px-6 sm:py-3',
        'lg' => 'text-base px-6 py-3 sm:px-8 sm:py-4',
    ];

    $widthClass = $fullWidth ? 'w-full sm:w-auto' : '';
@endphp

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "inline-flex items-center justify-center font-medium rounded-md border transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 {$variantClasses[$variant]} {$sizeClasses[$size]} {$widthClass}"]) }}
>
    {{ $slot }}
</button>
