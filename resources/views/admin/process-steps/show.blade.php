<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Detalles del Paso del Proceso') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-6">
                <a href="{{ route('admin.process-steps.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Pasos del Proceso
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                            Detalles del Paso del Proceso
                        </h1>
                        <p class="text-sm sm:text-base text-white/80">
                            Información completa del paso
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.process-steps.edit', $processStep) }}" class="glass-button glass-button-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar
                        </a>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Vista Previa del Paso --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Vista Previa</h3>
                    <div class="max-w-sm mx-auto">
                        <x-ui.card glassmorphism="true" class="text-center process-step">
                            <div class="mb-4">
                                <div class="w-16 h-16 mx-auto bg-white/20 rounded-full flex items-center justify-center mb-4">
                                    <span class="text-2xl font-bold text-white">{{ $processStep->step_number }}</span>
                                </div>
                                <div class="flex items-center justify-center">
                                    {!! $processStep->icon_svg !!}
                                </div>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-white">{{ $processStep->title }}</h3>
                            <p class="text-white/80 text-sm sm:text-base">
                                {{ $processStep->description }}
                            </p>
                        </x-ui.card>
                    </div>
                </div>

                {{-- Información Básica --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Información Básica</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-white/70 mb-1">ID</p>
                            <p class="text-base font-medium text-white">{{ $processStep->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Número del Paso</p>
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                                <span class="text-lg font-bold text-white">{{ $processStep->step_number }}</span>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-sm text-white/70 mb-1">Título</p>
                            <p class="text-base font-medium text-white">{{ $processStep->title }}</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-sm text-white/70 mb-1">Descripción</p>
                            <p class="text-base font-medium text-white">{{ $processStep->description }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Orden</p>
                            <p class="text-base font-medium text-white">{{ $processStep->order }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Estado</p>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $processStep->is_active ? 'bg-green-500/30 text-green-200' : 'bg-gray-500/30 text-gray-200' }}">
                                {{ $processStep->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Icono SVG --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Icono SVG</h3>
                    <div class="mb-4 p-4 bg-white/10 rounded-lg flex items-center justify-center">
                        {!! $processStep->icon_svg !!}
                    </div>
                    <div class="p-4 bg-white/5 rounded-lg">
                        <p class="text-sm text-white/70 mb-2">Código SVG:</p>
                        <pre class="text-xs text-white/80 font-mono overflow-x-auto"><code>{{ $processStep->icon_svg }}</code></pre>
                    </div>
                </div>

                {{-- Estado y Fechas --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Estado y Fechas</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-white/70 mb-1">Fecha de Creación</p>
                            <p class="text-base font-medium text-white">{{ $processStep->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Última Actualización</p>
                            <p class="text-base font-medium text-white">{{ $processStep->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>







