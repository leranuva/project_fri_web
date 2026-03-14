<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Detalles del Logo') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-6">
                <a href="{{ route('admin.logos.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Logos
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                            Detalles del Logo
                        </h1>
                        <p class="text-sm sm:text-base text-white/80">
                            Información completa del logotipo
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.logos.edit', $logo) }}" class="glass-button glass-button-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar
                        </a>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Vista del Logo --}}
                @if($logo->image_path)
                    <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-4">Vista del Logo</h3>
                        <div class="flex justify-center">
                            <img src="{{ asset($logo->image_path) }}" alt="{{ $logo->name ?? 'Logo' }}" class="max-w-md h-auto rounded-lg border border-white/20 shadow-lg">
                        </div>
                    </div>
                @endif

                {{-- Información Básica --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Información Básica</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-white/70 mb-1">ID</p>
                            <p class="text-base font-medium text-white">{{ $logo->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Nombre</p>
                            <p class="text-base font-medium text-white">{{ $logo->name ?? 'Sin nombre' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Ruta de la Imagen</p>
                            <p class="text-base font-medium text-white break-all">{{ $logo->image_path ?? 'No disponible' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Estado</p>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $logo->is_active ? 'bg-green-500/30 text-green-200' : 'bg-gray-500/30 text-gray-200' }}">
                                {{ $logo->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Orden</p>
                            <p class="text-base font-medium text-white">{{ $logo->order }}</p>
                        </div>
                    </div>
                </div>

                {{-- Información de Fechas --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Información de Fechas</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-white/70 mb-1">Fecha de Creación</p>
                            <p class="text-base font-medium text-white">{{ $logo->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Última Actualización</p>
                            <p class="text-base font-medium text-white">{{ $logo->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Acciones Rápidas --}}
                @if(!$logo->is_active)
                    <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-4">Acciones</h3>
                        <form method="POST" action="{{ route('admin.logos.activate', $logo) }}" class="inline">
                            @csrf
                            <button type="submit" class="glass-button glass-button-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Activar este Logo
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>

