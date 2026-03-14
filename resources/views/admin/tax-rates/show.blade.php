<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Detalles del Impuesto') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('admin.tax-rates.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Impuestos
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                            Detalles del Impuesto
                        </h1>
                        <p class="text-xs sm:text-sm md:text-base text-white/80">
                            Información completa del impuesto: <span class="text-white font-semibold">{{ $taxRate->label }}</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <a href="{{ route('admin.tax-rates.edit', $taxRate) }}" class="glass-button glass-button-sm w-full sm:w-auto flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span class="text-xs sm:text-sm md:text-base">Editar</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Información Básica --}}
                <div class="p-4 sm:p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Información Básica
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-white/70 mb-1">ID</p>
                            <p class="text-base font-medium text-white font-mono">{{ $taxRate->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Nombre</p>
                            <p class="text-base font-semibold text-white font-mono">{{ $taxRate->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Etiqueta</p>
                            <p class="text-base font-semibold text-white">{{ $taxRate->label }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Estado</p>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $taxRate->is_active ? 'bg-green-500/30 text-green-200 border border-green-500/30' : 'bg-red-500/30 text-red-200 border border-red-500/30' }}">
                                {{ $taxRate->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        @if($taxRate->description)
                        <div class="sm:col-span-2">
                            <p class="text-sm text-white/70 mb-1">Descripción</p>
                            <p class="text-base text-white/90 leading-relaxed">{{ $taxRate->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Información de Tasa --}}
                <div class="p-4 sm:p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Información de Tasa
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-white/5 rounded-lg p-4 border border-white/10">
                            <p class="text-xs text-white/70 mb-2">Tasa del Impuesto</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($taxRate->rate * 100, 2) }}%</p>
                            <p class="text-xs text-white/60 mt-1">Decimal: {{ number_format($taxRate->rate, 4) }}</p>
                        </div>
                    </div>
                </div>

                {{-- Metadatos --}}
                <div class="p-4 sm:p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Metadatos
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-white/70 mb-1">Fecha de Creación</p>
                            <p class="text-base font-medium text-white">{{ $taxRate->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-white/70 mb-1">Última Actualización</p>
                            <p class="text-base font-medium text-white">{{ $taxRate->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>





