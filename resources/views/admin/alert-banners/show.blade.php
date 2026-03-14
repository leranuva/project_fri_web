<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Detalles del Banner de Alerta') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-6">
                <a href="{{ route('admin.alert-banners.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Banners de Alerta
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                            Detalles del Banner de Alerta
                        </h1>
                        <p class="text-sm sm:text-base text-white/80">
                            Información completa del banner
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.alert-banners.edit', $alertBanner) }}" class="glass-button glass-button-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar
                        </a>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Vista Previa del Banner --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Vista Previa</h3>
                    <div class="max-w-2xl mx-auto">
                        <x-ui.card 
                            glassmorphism="true" 
                            padding="lg" 
                            class="alert-section"
                            style="background: {{ $alertBanner->container_color ?? 'rgba(255, 255, 255, 0.15)' }} !important; {{ $alertBanner->background_color && $alertBanner->background_color !== 'transparent' ? 'background-color: ' . $alertBanner->background_color . ';' : '' }}"
                        >
                            <div class="text-center">
                                <div class="mb-6">
                                    <div class="flex items-center justify-center">
                                        {!! $alertBanner->icon_svg !!}
                                    </div>
                                </div>
                                <h2 
                                    class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4"
                                    style="color: {{ $alertBanner->title_color ?? '#ffffff' }};"
                                >
                                    {{ $alertBanner->title }}
                                </h2>
                                <p 
                                    class="text-lg sm:text-xl mb-8 max-w-2xl mx-auto"
                                    style="color: {{ $alertBanner->description_color ?? '#ffffff' }};"
                                >
                                    {{ $alertBanner->description }}
                                </p>
                                @if($alertBanner->button_text_auth && $alertBanner->button_link_auth)
                                    <a href="{{ $alertBanner->button_link_auth }}" class="glass-button glass-button-lg">
                                        {{ $alertBanner->button_text_auth }}
                                    </a>
                                @endif
                            </div>
                        </x-ui.card>
                    </div>
                </div>

                {{-- Información Básica --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Información Básica</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-white/70 mb-1">ID</p>
                            <p class="text-base font-medium text-white">{{ $alertBanner->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Estado</p>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $alertBanner->is_active ? 'bg-green-500/30 text-green-200' : 'bg-gray-500/30 text-gray-200' }}">
                                {{ $alertBanner->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-sm text-white/70 mb-1">Título</p>
                            <p class="text-base font-medium text-white">{{ $alertBanner->title }}</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-sm text-white/70 mb-1">Descripción</p>
                            <p class="text-base font-medium text-white">{{ $alertBanner->description }}</p>
                        </div>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Configuración de Botones</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-base font-semibold text-white mb-3">Para Usuarios Autenticados</h4>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-sm text-white/70 mb-1">Texto del Botón</p>
                                    <p class="text-base font-medium text-white">{{ $alertBanner->button_text_auth ?? 'No configurado' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-white/70 mb-1">Enlace del Botón</p>
                                    <p class="text-base font-medium text-white font-mono text-sm">{{ $alertBanner->button_link_auth ?? 'No configurado' }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold text-white mb-3">Para Usuarios No Autenticados</h4>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-sm text-white/70 mb-1">Texto del Botón</p>
                                    <p class="text-base font-medium text-white">{{ $alertBanner->button_text_guest ?? 'No configurado' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-white/70 mb-1">Enlace del Botón</p>
                                    <p class="text-base font-medium text-white font-mono text-sm">{{ $alertBanner->button_link_guest ?? 'No configurado' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Icono SVG --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Icono SVG</h3>
                    <div class="mb-4 p-4 bg-white/10 rounded-lg flex items-center justify-center">
                        {!! $alertBanner->icon_svg !!}
                    </div>
                    <div class="p-4 bg-white/5 rounded-lg">
                        <p class="text-sm text-white/70 mb-2">Código SVG:</p>
                        <pre class="text-xs text-white/80 font-mono overflow-x-auto"><code>{{ $alertBanner->icon_svg }}</code></pre>
                    </div>
                </div>

                {{-- Colores --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Colores Configurados</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-white/70 mb-2">Color del Contenedor</p>
                            <div class="flex items-center gap-3">
                                @if(preg_match('/^#[0-9A-Fa-f]{6}$/', $alertBanner->container_color ?? 'rgba(255, 255, 255, 0.15)'))
                                    <div 
                                        class="w-12 h-12 rounded-lg border-2 border-white/30"
                                        style="background-color: {{ $alertBanner->container_color }};"
                                    ></div>
                                    <span class="text-base font-medium text-white font-mono text-sm">{{ $alertBanner->container_color }}</span>
                                @else
                                    <div class="w-12 h-12 rounded-lg border-2 border-white/30 bg-white/10"></div>
                                    <span class="text-base font-medium text-white font-mono text-sm">{{ $alertBanner->container_color ?? 'rgba(255, 255, 255, 0.15)' }}</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-2">Color de Fondo</p>
                            <div class="flex items-center gap-3">
                                @if($alertBanner->background_color && $alertBanner->background_color !== 'transparent')
                                    <div 
                                        class="w-12 h-12 rounded-lg border-2 border-white/30"
                                        style="background-color: {{ $alertBanner->background_color }};"
                                    ></div>
                                    <span class="text-base font-medium text-white font-mono">{{ $alertBanner->background_color }}</span>
                                @else
                                    <div class="w-12 h-12 rounded-lg border-2 border-white/30 bg-transparent"></div>
                                    <span class="text-base font-medium text-white font-mono">Transparente</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-2">Color del Título</p>
                            <div class="flex items-center gap-3">
                                <div 
                                    class="w-12 h-12 rounded-lg border-2 border-white/30"
                                    style="background-color: {{ $alertBanner->title_color ?? '#ffffff' }};"
                                ></div>
                                <span class="text-base font-medium text-white font-mono">{{ $alertBanner->title_color ?? '#ffffff' }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-2">Color de la Descripción</p>
                            <div class="flex items-center gap-3">
                                <div 
                                    class="w-12 h-12 rounded-lg border-2 border-white/30"
                                    style="background-color: {{ $alertBanner->description_color ?? '#ffffff' }};"
                                ></div>
                                <span class="text-base font-medium text-white font-mono">{{ $alertBanner->description_color ?? '#ffffff' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Estado y Fechas --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Estado y Fechas</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-white/70 mb-1">Fecha de Creación</p>
                            <p class="text-base font-medium text-white">{{ $alertBanner->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Última Actualización</p>
                            <p class="text-base font-medium text-white">{{ $alertBanner->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>

