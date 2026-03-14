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
                            Número de tracking: <strong class="text-white">{{ $package->tracking_number }}</strong>
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
                                $color = $statusColors[$package->status] ?? 'bg-gray-500/20 text-gray-300 border-gray-500/50';
                                $label = $statusLabels[$package->status] ?? ucfirst(str_replace('_', ' ', $package->status));
                            @endphp
                            <span class="px-4 py-2 rounded-lg border {{ $color }} font-semibold text-lg">
                                {{ $label }}
                            </span>
                        </div>
                    </div>

                    {{-- Información detallada --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        @if($package->carrier)
                            <div class="bg-white/10 rounded-lg p-4">
                                <p class="text-white/60 text-sm mb-1">Transportista</p>
                                <p class="text-white font-semibold">{{ $package->carrier }}</p>
                            </div>
                        @endif

                        @if($package->weight)
                            <div class="bg-white/10 rounded-lg p-4">
                                <p class="text-white/60 text-sm mb-1">Peso</p>
                                <p class="text-white font-semibold">{{ number_format($package->weight, 2) }} lbs</p>
                            </div>
                        @endif

                        @if($package->value)
                            <div class="bg-white/10 rounded-lg p-4">
                                <p class="text-white/60 text-sm mb-1">Valor Declarado</p>
                                <p class="text-white font-semibold">${{ number_format($package->value, 2) }} USD</p>
                            </div>
                        @endif

                        @if($package->shipped_date)
                            <div class="bg-white/10 rounded-lg p-4">
                                <p class="text-white/60 text-sm mb-1">Fecha de Envío</p>
                                <p class="text-white font-semibold">{{ $package->shipped_date->format('d/m/Y') }}</p>
                            </div>
                        @endif

                        @if($package->estimated_delivery)
                            <div class="bg-white/10 rounded-lg p-4">
                                <p class="text-white/60 text-sm mb-1">Entrega Estimada</p>
                                <p class="text-white font-semibold">{{ $package->estimated_delivery->format('d/m/Y') }}</p>
                            </div>
                        @endif

                        @if($package->delivered_date)
                            <div class="bg-white/10 rounded-lg p-4">
                                <p class="text-white/60 text-sm mb-1">Fecha de Entrega</p>
                                <p class="text-white font-semibold">{{ $package->delivered_date->format('d/m/Y') }}</p>
                            </div>
                        @endif
                    </div>

                    @if($package->origin || $package->destination)
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold text-white mb-4">Ruta</h3>
                            <div class="flex flex-col sm:flex-row items-center gap-4 bg-white/10 rounded-lg p-4">
                                @if($package->origin)
                                    <div class="flex-1 text-center">
                                        <p class="text-white/60 text-sm mb-1">Origen</p>
                                        <p class="text-white font-semibold">{{ $package->origin }}</p>
                                    </div>
                                @endif
                                @if($package->origin && $package->destination)
                                    <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                @endif
                                @if($package->destination)
                                    <div class="flex-1 text-center">
                                        <p class="text-white/60 text-sm mb-1">Destino</p>
                                        <p class="text-white font-semibold">{{ $package->destination }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($package->description)
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold text-white mb-2">Descripción</h3>
                            <p class="text-white/80">{{ $package->description }}</p>
                        </div>
                    @endif

                    @if($package->notes)
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold text-white mb-2">Notas</h3>
                            <p class="text-white/80">{{ $package->notes }}</p>
                        </div>
                    @endif

                    {{-- Historial de tracking --}}
                    @if($package->tracking_history && count($package->tracking_history) > 0)
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-4">Historial de Tracking</h3>
                            <div class="space-y-4">
                                @foreach($package->tracking_history as $history)
                                    <div class="bg-white/10 rounded-lg p-4 border-l-4 border-blue-500/50">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                            <div>
                                                <p class="text-white font-semibold">
                                                    {{ $history['status'] ?? 'Actualización' }}
                                                </p>
                                                @if(isset($history['description']))
                                                    <p class="text-white/80 text-sm mt-1">
                                                        {{ $history['description'] }}
                                                    </p>
                                                @endif
                                            </div>
                                            @if(isset($history['date']))
                                                <p class="text-white/60 text-sm">
                                                    {{ \Carbon\Carbon::parse($history['date'])->format('d/m/Y H:i') }}
                                                </p>
                                            @endif
                                        </div>
                                        @if(isset($history['location']))
                                            <p class="text-white/60 text-sm mt-2">
                                                📍 {{ $history['location'] }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </x-ui.card>

                {{-- Botón para buscar otro paquete --}}
                <div class="text-center">
                    <a 
                        href="{{ route('home') }}#tracking" 
                        class="glass-button glass-button-lg"
                    >
                        Buscar Otro Paquete
                    </a>
                </div>
            </div>
        </x-ui.container>
    </div>
</x-guest-layout>






