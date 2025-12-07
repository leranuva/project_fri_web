<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Detalles del Slide') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-6">
                <a href="{{ route('admin.sliders.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Sliders
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                            Detalles del Slide
                        </h1>
                        <p class="text-sm sm:text-base text-white/80">
                            Información completa del slide
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.sliders.edit', $slider) }}" class="glass-button glass-button-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar
                        </a>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Vista Previa de la Imagen --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Vista Previa</h3>
                    <div class="relative w-full h-64 sm:h-96 rounded-lg overflow-hidden border border-white/20">
                        <img src="{{ $slider->image }}" alt="{{ $slider->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-900/80 via-purple-700/70 to-pink-600/80"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center text-white max-w-2xl px-4">
                                <h2 class="text-2xl sm:text-3xl font-bold mb-2 drop-shadow-lg">{{ $slider->title }}</h2>
                                @if($slider->subtitle)
                                    <p class="text-lg sm:text-xl mb-2 text-white/95 drop-shadow-md">{{ $slider->subtitle }}</p>
                                @endif
                                @if($slider->description)
                                    <p class="text-sm sm:text-base mb-4 text-white/90 drop-shadow-sm">{{ $slider->description }}</p>
                                @endif
                                @if($slider->cta)
                                    <a href="{{ $slider->cta_link ?? '#' }}" class="hero-slider-cta-button inline-block">
                                        {{ $slider->cta }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Información Básica --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Información Básica</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-white/70 mb-1">ID</p>
                            <p class="text-base font-medium text-white">{{ $slider->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Título</p>
                            <p class="text-base font-medium text-white">{{ $slider->title }}</p>
                        </div>
                        @if($slider->subtitle)
                            <div class="sm:col-span-2">
                                <p class="text-sm text-white/70 mb-1">Subtítulo</p>
                                <p class="text-base font-medium text-white">{{ $slider->subtitle }}</p>
                            </div>
                        @endif
                        @if($slider->description)
                            <div class="sm:col-span-2">
                                <p class="text-sm text-white/70 mb-1">Descripción</p>
                                <p class="text-base font-medium text-white">{{ $slider->description }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm text-white/70 mb-1">Orden</p>
                            <p class="text-base font-medium text-white">{{ $slider->order }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Estado</p>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $slider->is_active ? 'bg-green-500/30 text-green-200' : 'bg-gray-500/30 text-gray-200' }}">
                                {{ $slider->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Colores del Texto --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Colores del Texto</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-white/70 mb-2">Color del Título</p>
                            <div class="flex items-center gap-3">
                                <div 
                                    class="w-12 h-12 rounded-lg border-2 border-white/30"
                                    style="background-color: {{ $slider->title_color ?? '#ffffff' }}"
                                ></div>
                                <span class="text-base font-medium text-white font-mono">{{ $slider->title_color ?? '#ffffff' }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-2">Color del Subtítulo</p>
                            <div class="flex items-center gap-3">
                                <div 
                                    class="w-12 h-12 rounded-lg border-2 border-white/30"
                                    style="background-color: {{ $slider->subtitle_color ?? '#ffffff' }}"
                                ></div>
                                <span class="text-base font-medium text-white font-mono">{{ $slider->subtitle_color ?? '#ffffff' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Información de CTA --}}
                @if($slider->cta || $slider->cta_link)
                    <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-4">Botón de Acción (CTA)</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @if($slider->cta)
                                <div>
                                    <p class="text-sm text-white/70 mb-1">Texto del Botón</p>
                                    <p class="text-base font-medium text-white">{{ $slider->cta }}</p>
                                </div>
                            @endif
                            @if($slider->cta_link)
                                <div>
                                    <p class="text-sm text-white/70 mb-1">URL del Botón</p>
                                    <a href="{{ $slider->cta_link }}" target="_blank" class="text-base font-medium text-blue-300 hover:text-blue-200 break-all">
                                        {{ $slider->cta_link }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Información de la Imagen --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Imagen</h3>
                    <div>
                        <p class="text-sm text-white/70 mb-2">URL de la Imagen</p>
                        <a href="{{ $slider->image }}" target="_blank" class="text-base font-medium text-blue-300 hover:text-blue-200 break-all">
                            {{ $slider->image }}
                        </a>
                    </div>
                </div>

                {{-- Estado y Fechas --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Estado y Fechas</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-white/70 mb-1">Fecha de Creación</p>
                            <p class="text-base font-medium text-white">{{ $slider->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Última Actualización</p>
                            <p class="text-base font-medium text-white">{{ $slider->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>

