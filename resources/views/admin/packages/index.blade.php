<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Administración de Paquetes') }}
        </h2>
    </x-slot>

    <x-ui.container>
        {{-- Mensajes --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-500/20 border border-green-500/30 backdrop-blur-sm">
                <div class="flex items-center gap-2 text-green-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                        Gestión de Paquetes
                    </h1>
                    <p class="text-xs sm:text-sm md:text-base text-white/80">
                        Administra los paquetes y su información de tracking
                    </p>
                </div>
                <a href="{{ route('admin.packages.create') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="text-xs sm:text-sm md:text-base">Nuevo Paquete</span>
                </a>
            </div>

            {{-- Búsqueda y Filtros --}}
            <form method="GET" action="{{ route('admin.packages.index') }}" class="mb-6">
                <div class="flex flex-col sm:flex-row gap-4">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Buscar por tracking, transportista, estado..." 
                        class="auth-form-input flex-1"
                    >
                    <select name="status" class="auth-form-input sm:w-48">
                        <option value="">Todos los estados</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="in_transit" {{ request('status') == 'in_transit' ? 'selected' : '' }}>En Tránsito</option>
                        <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>Recibido</option>
                        <option value="in_customs" {{ request('status') == 'in_customs' ? 'selected' : '' }}>En Aduana</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Entregado</option>
                    </select>
                    <button type="submit" class="glass-button glass-button-sm sm:glass-button">
                        Buscar
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.packages.index') }}" class="glass-button glass-button-sm sm:glass-button glass-button-secondary">
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>

            {{-- Vista de tabla para desktop --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20">
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Tracking</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Transportista</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Estado</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Usuario</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Creado</th>
                            <th class="text-right py-3 px-4 text-white/80 font-semibold text-sm">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($packages as $package)
                            <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                                <td class="py-3 px-4 text-white/90 font-mono text-sm">{{ $package->tracking_number }}</td>
                                <td class="py-3 px-4 text-white/90">{{ $package->carrier ?? '-' }}</td>
                                <td class="py-3 px-4">
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
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-white/70 text-sm">
                                    {{ $package->user ? $package->user->name : '-' }}
                                </td>
                                <td class="py-3 px-4 text-white/70 text-sm">{{ $package->created_at->format('d/m/Y') }}</td>
                                <td class="py-3 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.packages.show', $package->id) }}" class="p-2 rounded-lg bg-blue-500/20 hover:bg-blue-500/30 text-blue-300 transition-colors" title="Ver">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.packages.edit', $package->id) }}" class="p-2 rounded-lg bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-300 transition-colors" title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este paquete?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg bg-red-500/20 hover:bg-red-500/30 text-red-300 transition-colors" title="Eliminar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-white/60">
                                    No se encontraron paquetes.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Vista móvil --}}
            <div class="md:hidden space-y-4">
                @forelse($packages as $package)
                    <x-ui.card glassmorphism="true" padding="default">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <p class="text-white font-mono text-sm font-semibold mb-1">{{ $package->tracking_number }}</p>
                                <p class="text-white/70 text-xs">{{ $package->carrier ?? 'Sin transportista' }}</p>
                            </div>
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
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                {{ $label }}
                            </span>
                        </div>
                        <div class="flex items-center gap-4 text-xs text-white/60 mb-4">
                            <span>{{ $package->user ? $package->user->name : 'Sin usuario' }}</span>
                            <span>{{ $package->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.packages.show', $package->id) }}" class="flex-1 glass-button glass-button-sm text-center">
                                Ver
                            </a>
                            <a href="{{ route('admin.packages.edit', $package->id) }}" class="flex-1 glass-button glass-button-sm glass-button-secondary text-center">
                                Editar
                            </a>
                            <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Estás seguro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full glass-button glass-button-sm bg-red-500/20 hover:bg-red-500/30 text-red-300">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </x-ui.card>
                @empty
                    <x-ui.card glassmorphism="true" padding="lg">
                        <p class="text-center text-white/60">No se encontraron paquetes.</p>
                    </x-ui.card>
                @endforelse
            </div>

            {{-- Paginación --}}
            @if($packages->hasPages())
                <div class="mt-6">
                    {{ $packages->links() }}
                </div>
            @endif
        </x-ui.card>
    </x-ui.container>
</x-app-layout>






