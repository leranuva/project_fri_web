<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Pagar Cotización') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <div class="mb-6">
            <a href="{{ route('quotes.index') }}" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Mis Cotizaciones
            </a>
        </div>

        @if(session('info'))
            <div class="mb-4 p-4 bg-blue-500/20 rounded-lg text-blue-200">
                {{ session('info') }}
            </div>
        @endif

        <x-ui.card glassmorphism="true" padding="lg">
            <h3 class="text-xl font-semibold text-white mb-4">Resumen de la cotización</h3>
            <div class="space-y-2 mb-6">
                <p class="text-white/80"><span class="text-white/60">Producto:</span> {{ $quote->product?->name ?? $quote->product_key }}</p>
                <p class="text-white/80"><span class="text-white/60">Peso:</span> {{ number_format($quote->weight, 2) }} lb</p>
                <p class="text-white/80"><span class="text-white/60">Método:</span> {{ ucfirst($quote->shipping_method) }}</p>
                <p class="text-xl font-bold text-white mt-4">Total: ${{ number_format($quote->total, 2) }} USD</p>
            </div>

            <p class="text-white/60 text-sm mb-4">
                Integración de pago (Stripe, PayPal, etc.) pendiente de configurar. 
                Configure las credenciales en <code class="bg-white/10 px-1 rounded">config/services.php</code>.
            </p>

            <form action="{{ route('payments.process', $quote) }}" method="POST">
                @csrf
                <button type="submit" class="glass-button" disabled>
                    Pagar (próximamente)
                </button>
            </form>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>
