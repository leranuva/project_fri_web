<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Detalle del Paquete') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <div class="mb-6 flex flex-wrap gap-4 items-center justify-between">
            <a href="{{ route('packages.index') }}" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Mis Paquetes
            </a>
            <form action="{{ route('packages.refresh', $package->tracking_number) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="glass-button text-sm">Actualizar información</button>
            </form>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-500/20 rounded-lg text-green-200">
                {{ session('success') }}
            </div>
        @endif

        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="text-center mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                    {{ $package->tracking_number }}
                </h1>
                <p class="text-white/80">Transportista: {{ $package->carrier ?? 'Desconocido' }}</p>
            </div>

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
                $label = $statusLabels[$package->status] ?? ucfirst(str_replace('_', ' ', $package->status ?? 'Pendiente'));
            @endphp
            <div class="flex justify-center mb-6">
                <span class="px-4 py-2 rounded-lg border {{ $color }} font-semibold">{{ $label }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
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
                <div class="mb-6 flex flex-col sm:flex-row items-center gap-4 bg-white/10 rounded-lg p-4">
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
            @endif

            @if($package->tracking_history && count($package->tracking_history) > 0)
                <div>
                    <h3 class="text-xl font-semibold text-white mb-4">Historial</h3>
                    <div class="space-y-4">
                        @foreach($package->tracking_history as $history)
                            <div class="bg-white/10 rounded-lg p-4 border-l-4 border-blue-500/50">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                    <div>
                                        <p class="text-white font-semibold">{{ $history['status'] ?? 'Actualización' }}</p>
                                        @if(isset($history['description']))
                                            <p class="text-white/80 text-sm mt-1">{{ $history['description'] }}</p>
                                        @endif
                                    </div>
                                    @if(isset($history['date']))
                                        <p class="text-white/60 text-sm">{{ \Carbon\Carbon::parse($history['date'])->format('d/m/Y H:i') }}</p>
                                    @endif
                                </div>
                                @if(isset($history['location']))
                                    <p class="text-white/60 text-sm mt-2">📍 {{ $history['location'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-white/60 text-center py-4">No hay historial de tracking disponible.</p>
            @endif
        </x-ui.card>
    </x-ui.container>
</x-app-layout>
