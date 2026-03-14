@php
    // Patrón de rejilla responsiva: grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3
    $cols = $cols ?? 1;
    $colsSm = $colsSm ?? 2;
    $colsMd = $colsMd ?? 3;
    $gap = $gap ?? 'default';
    
    $gapClasses = [
        'none' => 'gap-0',
        'sm' => 'gap-4',
        'default' => 'gap-6',
        'lg' => 'gap-8',
    ];
    
    // Construir clases de columnas según el patrón especificado
    // grid-cols-1 sm:grid-cols-2 md:grid-cols-3
    $gridCols = "grid-cols-{$cols}";
    if ($colsSm > $cols) {
        $gridCols .= " sm:grid-cols-{$colsSm}";
    }
    if ($colsMd > $colsSm) {
        $gridCols .= " md:grid-cols-{$colsMd}";
    }
@endphp

<div class="grid {{ $gapClasses[$gap] }} {{ $gridCols }} {{ $attributes->get('class') }}">
    {{ $slot }}
</div>
