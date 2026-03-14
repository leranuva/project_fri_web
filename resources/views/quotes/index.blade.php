<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Mis Cotizaciones') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Dashboard
            </a>
        </div>

        <x-ui.card glassmorphism="true" padding="lg">
            <h3 class="text-xl font-semibold text-white mb-4">Historial de cotizaciones</h3>

            @if($quotes->isEmpty())
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-white/30 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <p class="text-white/70 mb-4">Aún no tienes cotizaciones guardadas.</p>
                    <a href="{{ route('cotizador') }}" class="glass-button">Crear cotización</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-white/20">
                                <th class="py-3 px-4 text-white/70 text-sm font-semibold">Fecha</th>
                                <th class="py-3 px-4 text-white/70 text-sm font-semibold">Producto</th>
                                <th class="py-3 px-4 text-white/70 text-sm font-semibold">Peso</th>
                                <th class="py-3 px-4 text-white/70 text-sm font-semibold">Método</th>
                                <th class="py-3 px-4 text-white/70 text-sm font-semibold">Total</th>
                                <th class="py-3 px-4 text-white/70 text-sm font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotes as $quote)
                                <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                                    <td class="py-3 px-4 text-white/90">{{ $quote->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="py-3 px-4 text-white/90">{{ $quote->product?->name ?? $quote->product_key }}</td>
                                    <td class="py-3 px-4 text-white/90">{{ number_format($quote->weight, 2) }} lb</td>
                                    <td class="py-3 px-4 text-white/90">{{ ucfirst($quote->shipping_method) }}</td>
                                    <td class="py-3 px-4 text-white font-semibold">${{ number_format($quote->total, 2) }}</td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('payments.show', $quote) }}" class="text-white/80 hover:text-white text-sm">Pagar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $quotes->links() }}
                </div>
            @endif
        </x-ui.card>

        <div class="mt-4">
            <a href="{{ route('cotizador') }}" class="glass-button">Nueva cotización</a>
        </div>
    </x-ui.container>
</x-app-layout>
