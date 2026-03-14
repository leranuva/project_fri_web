@php
    $seoTitle = $page->title . ' | ' . config('app.name');
    $seoDescription = $page->meta_description ?? \Illuminate\Support\Str::limit(strip_tags($page->content ?? ''), 160);
    $seoImage = $page->og_image ? (str_starts_with($page->og_image, 'http') ? $page->og_image : url($page->og_image)) : \App\Helpers\SeoHelper::image();
    $cotizadorUrl = route('cotizador') . ($page->product ? '?product=' . urlencode($page->product->key) : '');
@endphp
<x-app-layout :seoTitle="$seoTitle" :seoDescription="$seoDescription" :seoImage="$seoImage">
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl leading-tight text-white">{{ $page->title }}</h2>
    </x-slot>

    <x-ui.container>
        <div class="prose prose-invert max-w-none text-white/90 mb-8">
            {!! $page->content !!}
        </div>

        {{-- Cotizador --}}
        <x-ui.card glassmorphism="true" padding="lg" class="mb-8">
            <h3 class="text-xl font-semibold text-white mb-6">Calcula el costo de importar</h3>
            <p class="text-white/80 text-sm mb-4">Usa el cotizador para obtener una cotización detallada:</p>
            <a href="{{ $cotizadorUrl }}" class="glass-button glass-button-lg">
                Ir al Cotizador
            </a>
        </x-ui.card>

        {{-- Botón a ecommerce --}}
        @if($page->store_link)
            <a href="{{ $page->store_link }}" target="_blank" rel="noopener noreferrer" class="glass-button glass-button-lg inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Comprar en la tienda
            </a>
        @else
            <a href="{{ \App\Helpers\SeoHelper::storeSearchUrl($page->keyword) }}" target="_blank" rel="noopener noreferrer" class="glass-button glass-button-lg inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Buscar en la tienda
            </a>
        @endif
    </x-ui.container>
</x-app-layout>
