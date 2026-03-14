<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Ver Paquete') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-6">
                <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-4 text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Paquetes
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                    Paquete: {{ $package->tracking_number }}
                </h1>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-white/60 text-sm mb-1">Número de Tracking</p>
                        <p class="text-white font-mono font-semibold">{{ $package->tracking_number }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Transportista</p>
                        <p class="text-white">{{ $package->carrier ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Estado</p>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-500/30 text-yellow-200',
                                'in_transit' => 'bg-blue-500/30 text-blue-200',
                                'received' => 'bg-green-500/30 text-green-200',
                                'in_customs' => 'bg-orange-500/30 text-orange-200',
                                'delivered' => 'bg-emerald-500/30 text-emerald-200',
                            ];
                            $statusLabels = [
                                'pending' => 'Pendiente',
                                'in_transit' => 'En Tránsito',
                                'received' => 'Recibido',
                                'in_customs' => 'En Aduana',
                                'delivered' => 'Entregado',
                            ];
                            $color = $statusColors[$package->status] ?? 'bg-gray-500/30 text-gray-200';
                            $label = $statusLabels[$package->status] ?? ucfirst(str_replace('_', ' ', $package->status));
                        @endphp
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $color }} inline-block">
                            {{ $label }}
                        </span>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Usuario</p>
                        <p class="text-white">{{ $package->user ? $package->user->name . ' (' . $package->user->email . ')' : 'Sin asignar' }}</p>
                    </div>
                </div>

                @if($package->origin || $package->destination)
                    <div>
                        <p class="text-white/60 text-sm mb-2">Ruta</p>
                        <div class="flex items-center gap-4 bg-white/10 rounded-lg p-4">
                            @if($package->origin)
                                <div class="flex-1">
                                    <p class="text-white/60 text-xs mb-1">Origen</p>
                                    <p class="text-white">{{ $package->origin }}</p>
                                </div>
                            @endif
                            @if($package->origin && $package->destination)
                                <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            @endif
                            @if($package->destination)
                                <div class="flex-1">
                                    <p class="text-white/60 text-xs mb-1">Destino</p>
                                    <p class="text-white">{{ $package->destination }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @if($package->weight)
                        <div>
                            <p class="text-white/60 text-sm mb-1">Peso</p>
                            <p class="text-white font-semibold">{{ number_format($package->weight, 2) }} lbs</p>
                        </div>
                    @endif
                    @if($package->value)
                        <div>
                            <p class="text-white/60 text-sm mb-1">Valor Declarado</p>
                            <p class="text-white font-semibold">${{ number_format($package->value, 2) }} USD</p>
                        </div>
                    @endif
                    @if($package->shipped_date)
                        <div>
                            <p class="text-white/60 text-sm mb-1">Fecha de Envío</p>
                            <p class="text-white">{{ $package->shipped_date->format('d/m/Y') }}</p>
                        </div>
                    @endif
                    @if($package->estimated_delivery)
                        <div>
                            <p class="text-white/60 text-sm mb-1">Entrega Estimada</p>
                            <p class="text-white">{{ $package->estimated_delivery->format('d/m/Y') }}</p>
                        </div>
                    @endif
                    @if($package->delivered_date)
                        <div>
                            <p class="text-white/60 text-sm mb-1">Fecha de Entrega</p>
                            <p class="text-white">{{ $package->delivered_date->format('d/m/Y') }}</p>
                        </div>
                    @endif
                </div>

                @if($package->description)
                    <div>
                        <p class="text-white/60 text-sm mb-2">Descripción</p>
                        <p class="text-white">{{ $package->description }}</p>
                    </div>
                @endif

                @if($package->notes)
                    <div>
                        <p class="text-white/60 text-sm mb-2">Notas</p>
                        <p class="text-white">{{ $package->notes }}</p>
                    </div>
                @endif

                @if($package->tracking_history && count($package->tracking_history) > 0)
                    <div>
                        <p class="text-white/60 text-sm mb-4">Historial de Tracking</p>
                        <div class="space-y-3">
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
                @endif

                <div class="flex gap-4 pt-4 border-t border-white/10">
                    <a href="{{ route('admin.packages.edit', $package->id) }}" class="glass-button glass-button-lg">
                        Editar Paquete
                    </a>
                    <a href="{{ route('tracking.show', $package->tracking_number) }}" target="_blank" class="glass-button glass-button-lg glass-button-secondary">
                        Ver en Página Pública
                    </a>
                </div>
            </div>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>






