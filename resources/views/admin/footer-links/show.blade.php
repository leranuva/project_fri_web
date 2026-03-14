<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Detalles del Enlace del Footer') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('admin.footer-links.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Enlaces
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                            Detalles del Enlace
                        </h1>
                        <p class="text-xs sm:text-sm md:text-base text-white/80">
                            Información completa del enlace del footer
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('admin.footer-links.edit', $footerLink) }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center min-w-0">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span class="text-xs sm:text-sm md:text-base truncate">Editar</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Información General --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-white/80 mb-2">ID</label>
                        <p class="text-white/90">{{ $footerLink->id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-white/80 mb-2">Estado</label>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $footerLink->is_active ? 'bg-green-500/30 text-green-200' : 'bg-gray-500/30 text-gray-200' }}">
                            {{ $footerLink->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-white/80 mb-2">Etiqueta</label>
                        <p class="text-white/90">{{ $footerLink->label }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-white/80 mb-2">Tipo</label>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $footerLink->type === 'social' ? 'bg-purple-500/30 text-purple-200' : 'bg-blue-500/30 text-blue-200' }}">
                            {{ $footerLink->type === 'social' ? 'Red Social' : 'Enlace' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-white/80 mb-2">URL</label>
                        <a href="{{ $footerLink->url }}" target="_blank" rel="noopener noreferrer" class="text-blue-300 hover:text-blue-200 break-all">
                            {{ $footerLink->url }}
                        </a>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-white/80 mb-2">Orden</label>
                        <p class="text-white/90">{{ $footerLink->order }}</p>
                    </div>
                </div>

                {{-- Icono SVG (si existe) --}}
                @if($footerLink->icon_svg)
                    <div>
                        <label class="block text-sm font-semibold text-white/80 mb-2">Icono SVG</label>
                        <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                            <div class="flex items-center justify-center p-4 bg-white/10 rounded-lg mb-3">
                                <div class="w-12 h-12 text-white">
                                    {!! $footerLink->icon_svg !!}
                                </div>
                            </div>
                            <pre class="text-xs text-white/70 font-mono overflow-x-auto"><code>{{ $footerLink->icon_svg }}</code></pre>
                        </div>
                    </div>
                @endif

                {{-- Fechas --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-white/10">
                    <div>
                        <label class="block text-sm font-semibold text-white/80 mb-2">Creado</label>
                        <p class="text-white/70 text-sm">{{ $footerLink->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-white/80 mb-2">Actualizado</label>
                        <p class="text-white/70 text-sm">{{ $footerLink->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>





