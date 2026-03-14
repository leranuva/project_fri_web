@php
    $seoTitle = ($title ?? 'Calculadora') . ' | ' . config('app.name');
    $seoDescription = $description ?? 'Calcula el costo de importación a Ecuador.';
@endphp
<x-app-layout :seoTitle="$seoTitle" :seoDescription="$seoDescription">
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl leading-tight text-white">{{ $title ?? 'Calculadora' }}</h2>
    </x-slot>

    <x-ui.container>
        <div class="mb-8">
            <p class="text-white/80 text-lg">{{ $description ?? '' }}</p>
            <a href="{{ route('cotizador') }}" class="auth-form-link inline-block mt-2">Abrir cotizador en nueva pestaña →</a>
        </div>

        <x-ui.card glassmorphism="true" padding="lg">
            <iframe
                src="{{ $embedUrl }}"
                class="w-full border-0 rounded-lg"
                style="min-height: 900px;"
                title="Cotizador de importaciones"
            ></iframe>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>
