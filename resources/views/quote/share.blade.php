@php
    $seoTitle = 'Cotización de Importación | ' . config('app.name');
    $seoDescription = 'Cotización: ' . ($quoteData['productName'] ?? 'Producto') . ' - Total: $' . number_format($quoteData['totalCotizacion'] ?? 0, 2);
@endphp
<x-guest-layout :seoTitle="$seoTitle" :seoDescription="$seoDescription">
    <div class="py-12 sm:py-16">
        <x-ui.container>
            <x-ui.card glassmorphism="true" padding="lg">
                <div class="text-center mb-6">
                    <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Cotización compartida</h1>
                    <p class="text-white/80">Detalles de la cotización de importación</p>
                </div>

                <div class="space-y-4 mb-8">
                    <div class="flex justify-between py-2 border-b border-white/10">
                        <span class="text-white/70">Producto</span>
                        <span class="text-white font-medium">{{ $quoteData['productName'] ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-white/10">
                        <span class="text-white/70">Cantidad</span>
                        <span class="text-white font-medium">{{ $quoteData['quantity'] ?? 1 }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-white/10">
                        <span class="text-white/70">Peso</span>
                        <span class="text-white font-medium">{{ number_format($quoteData['weight'] ?? 0, 2) }} lb</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-white/10">
                        <span class="text-white/70">Método de envío</span>
                        <span class="text-white font-medium">{{ $quoteData['shippingMethod'] ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between py-4 border-t-2 border-white/20">
                        <span class="text-white font-semibold">Total</span>
                        <span class="text-xl font-bold text-green-300">${{ number_format($quoteData['totalCotizacion'] ?? 0, 2) }}</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('cotizador') }}" class="glass-button glass-button-lg">
                        Crear mi cotización
                    </a>
                    <a href="{{ config('seo.store_url') }}" target="_blank" rel="noopener" class="glass-button glass-button-lg" style="background: rgba(34, 197, 94, 0.2); border-color: rgba(34, 197, 94, 0.4);">
                        Visitar tienda
                    </a>
                </div>
            </x-ui.card>
        </x-ui.container>
    </div>
</x-guest-layout>
