<x-guest-layout>
    <div class="min-h-screen flex flex-col" style="padding-top: 0;">
        <x-ui.container>
            <div class="max-w-4xl mx-auto py-8 sm:py-12">
                {{-- Botón para volver a buscar --}}
                <div class="mb-6">
                    <a 
                        href="{{ route('home') }}#tracking" 
                        class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver a buscar
                    </a>
                </div>

                {{-- Información del paquete --}}
                <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
                    <div class="text-center mb-6">
                        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">
                            Información del Paquete
                        </h1>
                        <p class="text-white/80 text-lg">
                            Número de tracking: <strong class="text-white">{{ $trackingNumber }}</strong>
                        </p>
                    </div>

                    {{-- Estado del paquete --}}
                    <div class="mb-6">
                        <div class="flex items-center justify-center gap-3 mb-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-500/20 text-yellow-300 border-yellow-500/50',
                                    'in_transit' => 'bg-blue-500/20 text-blue-300 border-blue-500/50',
                                    'received' => 'bg-green-500/20 text-green-300 border-green-500/50',
                                    'in_customs' => 'bg-orange-500/20 text-orange-300 border-orange-500/50',
                                    'delivered' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/50',
                                ];
                                $statusLabels = [
                                    'pending' => 'Pendiente',
                                    'in_transit' => 'En Tránsito',
                                    'received' => 'Recibido',
                                    'in_customs' => 'En Aduana',
                                    'delivered' => 'Entregado',
                                ];
                                $color = $statusColors[$status] ?? 'bg-gray-500/20 text-gray-300 border-gray-500/50';
                                $label = $statusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status));
                            @endphp
                            <span class="px-4 py-2 rounded-lg border {{ $color }} font-semibold text-lg">
                                {{ $label }}
                            </span>
                        </div>
                    </div>

                </x-ui.card>
            </div>
        </x-ui.container>
    </div>
</x-guest-layout>
