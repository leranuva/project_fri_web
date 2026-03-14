<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Detalles del Beneficio') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-6">
                <a href="{{ route('admin.benefits.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Beneficios
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                            Detalles del Beneficio
                        </h1>
                        <p class="text-sm sm:text-base text-white/80">
                            Información completa del beneficio
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.benefits.edit', $benefit) }}" class="glass-button glass-button-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar
                        </a>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Vista Previa del Beneficio --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Vista Previa</h3>
                    <div class="max-w-sm mx-auto">
                        <x-ui.card glassmorphism="true" class="text-center benefit-card">
                            <div class="mb-4">
                                <div class="flex items-center justify-center">
                                    {!! $benefit->icon_svg !!}
                                </div>
                            </div>
                            <h3 
                                class="text-xl font-semibold mb-2"
                                style="color: {{ $benefit->title_color ?? '#ffffff' }};"
                            >
                                {{ $benefit->title }}
                            </h3>
                            <p 
                                class="text-sm sm:text-base"
                                style="color: {{ $benefit->description_color ?? 'rgba(255, 255, 255, 0.8)' }};"
                            >
                                {{ $benefit->description }}
                            </p>
                        </x-ui.card>
                    </div>
                </div>

                {{-- Información Detallada --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-white/60 text-sm mb-1">ID</p>
                        <p class="text-white font-semibold">{{ $benefit->id }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Título</p>
                        <p class="text-white font-semibold">{{ $benefit->title }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Orden</p>
                        <p class="text-white font-semibold">{{ $benefit->order }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Estado</p>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $benefit->is_active ? 'bg-green-500/30 text-green-200' : 'bg-gray-500/30 text-gray-200' }}">
                            {{ $benefit->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-white/60 text-sm mb-1">Descripción</p>
                        <p class="text-white">{{ $benefit->description }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Color del Título</p>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded border-2 border-white/30" style="background-color: {{ $benefit->title_color ?? '#ffffff' }};"></div>
                            <p class="text-white font-mono">{{ $benefit->title_color ?? '#ffffff' }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Color de la Descripción</p>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded border-2 border-white/30" style="background-color: {{ $benefit->description_color ?? '#ffffff' }};"></div>
                            <p class="text-white font-mono">{{ $benefit->description_color ?? '#ffffff' }}</p>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-white/60 text-sm mb-2">Icono SVG</p>
                        <div class="p-4 rounded-lg bg-white/5 border border-white/10">
                            <div class="flex items-center justify-center mb-4">
                                {!! $benefit->icon_svg !!}
                            </div>
                            <pre class="text-xs text-white/60 overflow-x-auto"><code>{{ $benefit->icon_svg }}</code></pre>
                        </div>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Creado</p>
                        <p class="text-white">{{ $benefit->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Actualizado</p>
                        <p class="text-white">{{ $benefit->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>

