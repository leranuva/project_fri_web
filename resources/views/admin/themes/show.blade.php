<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Detalles del Tema') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-6">
                <a href="{{ route('admin.themes.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Temas
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                            Detalles del Tema: {{ $theme->name }}
                        </h1>
                        <p class="text-sm sm:text-base text-white/80">
                            Información completa del tema
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
                        <a href="{{ route('admin.themes.edit', $theme) }}" class="glass-button glass-button-sm w-full sm:w-auto flex items-center justify-center min-w-0">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span class="text-xs sm:text-sm truncate">Editar</span>
                        </a>
                        @if(!$theme->is_active)
                            <form action="{{ route('admin.themes.activate', $theme) }}" method="POST" class="w-full sm:w-auto">
                                @csrf
                                <button type="submit" class="glass-button glass-button-sm w-full sm:w-auto flex items-center justify-center min-w-0" style="background: rgba(59, 130, 246, 0.3);">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-xs sm:text-sm truncate">Activar</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Vista Previa del Tema --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Vista Previa del Tema</h3>
                    <div class="space-y-4">
                        {{-- Gradiente de Fondo --}}
                        <div>
                            <p class="text-white/70 text-sm mb-2">Gradiente de Fondo:</p>
                            <div class="w-full h-32 rounded-lg border-2 border-white/20" style="background: linear-gradient(135deg, {{ $theme->background_gradient_start }}, {{ $theme->background_gradient_mid }}, {{ $theme->background_gradient_end }});"></div>
                        </div>
                        {{-- Colores Principales --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <p class="text-white/70 text-sm mb-2">Color Primario:</p>
                                <div class="flex items-center gap-2">
                                    <div class="w-12 h-12 rounded border-2 border-white/30" style="background-color: {{ $theme->primary_color }};"></div>
                                    <p class="text-white font-mono">{{ $theme->primary_color }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-white/70 text-sm mb-2">Color Secundario:</p>
                                <div class="flex items-center gap-2">
                                    <div class="w-12 h-12 rounded border-2 border-white/30" style="background-color: {{ $theme->secondary_color }};"></div>
                                    <p class="text-white font-mono">{{ $theme->secondary_color }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-white/70 text-sm mb-2">Color de Acento:</p>
                                <div class="flex items-center gap-2">
                                    <div class="w-12 h-12 rounded border-2 border-white/30" style="background-color: {{ $theme->accent_color }};"></div>
                                    <p class="text-white font-mono">{{ $theme->accent_color }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Información Detallada --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-white/60 text-sm mb-1">ID</p>
                        <p class="text-white font-semibold">{{ $theme->id }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Nombre</p>
                        <p class="text-white font-semibold">{{ $theme->name }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Estado</p>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $theme->is_active ? 'bg-green-500/30 text-green-200' : 'bg-gray-500/30 text-gray-200' }}">
                            {{ $theme->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Color de Texto Principal</p>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded border-2 border-white/30" style="background-color: {{ $theme->text_color }};"></div>
                            <p class="text-white font-mono">{{ $theme->text_color }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Color de Texto Secundario</p>
                        <p class="text-white font-mono">{{ $theme->text_secondary_color }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Color de Botones</p>
                        <p class="text-white font-mono">{{ $theme->button_color }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Creado</p>
                        <p class="text-white">{{ $theme->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Actualizado</p>
                        <p class="text-white">{{ $theme->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>


