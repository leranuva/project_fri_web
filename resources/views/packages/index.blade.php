<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Mis Paquetes') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <div class="mb-6 flex flex-wrap gap-4 items-center justify-between">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Dashboard
            </a>
            <a href="{{ route('tracking.index') }}" class="glass-button">Buscar tracking</a>
        </div>

        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <h3 class="text-xl font-semibold text-white mb-4">Agregar paquete</h3>
            <form action="{{ route('packages.store') }}" method="POST" class="flex gap-3 flex-wrap">
                @csrf
                <input type="text" name="tracking_number" value="{{ old('tracking_number') }}"
                    placeholder="Número de tracking o guía"
                    class="flex-1 min-w-[200px] rounded-lg border-white/20 bg-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-white/30">
                <button type="submit" class="glass-button">Agregar</button>
            </form>
            @error('tracking_number')
                <p class="mt-2 text-red-300 text-sm">{{ $message }}</p>
            @enderror
        </x-ui.card>

        <x-ui.card glassmorphism="true" padding="lg">
            <h3 class="text-xl font-semibold text-white mb-4">Mis paquetes</h3>

            @if($packages->isEmpty())
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-white/30 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <p class="text-white/70 mb-4">Aún no tienes paquetes registrados.</p>
                    <p class="text-white/50 text-sm mb-4">Agrega un número de tracking para ver el estado de tus envíos.</p>
                    <a href="{{ route('tracking.index') }}" class="glass-button">Buscar tracking</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-white/20">
                                <th class="py-3 px-4 text-white/70 text-sm font-semibold">Tracking</th>
                                <th class="py-3 px-4 text-white/70 text-sm font-semibold">Transportista</th>
                                <th class="py-3 px-4 text-white/70 text-sm font-semibold">Estado</th>
                                <th class="py-3 px-4 text-white/70 text-sm font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($packages as $package)
                                <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                                    <td class="py-3 px-4 text-white/90 font-mono">{{ $package->tracking_number }}</td>
                                    <td class="py-3 px-4 text-white/90">{{ $package->carrier ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded text-sm
                                            @if($package->status === 'delivered') bg-green-500/30 text-green-200
                                            @elseif($package->status === 'in_transit') bg-blue-500/30 text-blue-200
                                            @else bg-white/20 text-white/90
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $package->status ?? 'pending')) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('packages.show', $package->tracking_number) }}" class="text-white/80 hover:text-white text-sm">Ver detalle</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $packages->links() }}
                </div>
            @endif
        </x-ui.card>
    </x-ui.container>
</x-app-layout>
