<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Editar Impuesto') }}
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
                            Editar Impuesto
                        </h1>
                        <p class="text-xs sm:text-sm md:text-base text-white/80 truncate">
                            Modifica la información del impuesto: <span class="text-white font-semibold">{{ $taxRate->label }}</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <a href="{{ route('admin.tax-rates.show', $taxRate) }}" class="glass-button glass-button-sm w-full sm:w-auto flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span class="text-xs sm:text-sm md:text-base">Ver Detalles</span>
                        </a>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.tax-rates.update', $taxRate) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Información Básica --}}
                <div class="space-y-4 pb-4 border-b border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Información Básica</h3>

                    {{-- Nombre --}}
                    <div>
                        <x-input-label for="name" :value="__('Nombre del Impuesto')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="name" 
                            name="name" 
                            type="text" 
                            class="auth-form-input" 
                            :value="old('name', $taxRate->name)" 
                            required 
                            autofocus 
                            placeholder="Ej: fodinfa, iva, seguro_cif"
                        />
                        <p class="mt-1 text-xs text-white/60">Nombre único para identificar el impuesto (sin espacios, usar minúsculas y guiones bajos)</p>
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    {{-- Etiqueta --}}
                    <div>
                        <x-input-label for="label" :value="__('Etiqueta')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="label" 
                            name="label" 
                            type="text" 
                            class="auth-form-input" 
                            :value="old('label', $taxRate->label)" 
                            required 
                            placeholder="Ej: Fodinfa, IVA, Seguro CIF"
                        />
                        <p class="mt-1 text-xs text-white/60">Etiqueta para mostrar en la interfaz</p>
                        <x-input-error class="mt-2" :messages="$errors->get('label')" />
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <x-input-label for="description" :value="__('Descripción')" class="text-white/90 mb-2" />
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="3"
                            class="auth-form-input" 
                            placeholder="Descripción detallada del impuesto (opcional)"
                        >{{ old('description', $taxRate->description) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>
                </div>

                {{-- Información de Tasa --}}
                <div class="space-y-4 pb-4 border-b border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Información de Tasa</h3>

                    {{-- Tasa --}}
                    <div>
                        <x-input-label for="rate" :value="__('Tasa del Impuesto (%)')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="rate" 
                            name="rate" 
                            type="number" 
                            step="0.0001"
                            min="0"
                            max="1"
                            class="auth-form-input" 
                            :value="old('rate', $taxRate->rate)" 
                            required 
                            placeholder="Ej: 0.12 para 12%, 0.005 para 0.5%"
                        />
                        <p class="mt-1 text-xs text-white/60">Ingrese como decimal (0.12 = 12%, 0.005 = 0.5%)</p>
                        <x-input-error class="mt-2" :messages="$errors->get('rate')" />
                    </div>
                </div>

                {{-- Configuración --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white mb-4">Configuración</h3>

                    {{-- Estado Activo --}}
                    <div class="flex items-center p-4 rounded-lg bg-white/5 border border-white/10">
                        <input 
                            id="is_active" 
                            name="is_active" 
                            type="checkbox" 
                            value="1"
                            {{ old('is_active', $taxRate->is_active) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 bg-white/10 border-white/30 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer"
                        />
                        <x-input-label for="is_active" :value="__('Impuesto Activo')" class="ml-3 text-white/90 cursor-pointer" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                </div>

                {{-- Información adicional --}}
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-sm font-semibold text-white/90 mb-3">Información del Impuesto</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-white/70">ID:</p>
                            <p class="text-white font-medium">{{ $taxRate->id }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Creado:</p>
                            <p class="text-white font-medium">{{ $taxRate->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Última actualización:</p>
                            <p class="text-white font-medium">{{ $taxRate->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Estado:</p>
                            <p class="text-white font-medium">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $taxRate->is_active ? 'bg-green-500/30 text-green-200' : 'bg-red-500/30 text-red-200' }}">
                                    {{ $taxRate->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 pt-4 border-t border-white/10">
                    <button type="submit" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs sm:text-sm md:text-base">Guardar Cambios</span>
                    </button>
                    <a href="{{ route('admin.tax-rates.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>





