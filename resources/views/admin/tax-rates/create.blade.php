<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Crear Nuevo Impuesto') }}
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
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                    Crear Nuevo Impuesto
                </h1>
                <p class="text-xs sm:text-sm md:text-base text-white/80">
                    Completa el formulario para crear un nuevo impuesto en el sistema.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.tax-rates.store') }}" class="space-y-6">
                @csrf

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
                            :value="old('name')" 
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
                            :value="old('label')" 
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
                        >{{ old('description') }}</textarea>
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
                            :value="old('rate', 0)" 
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
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 bg-white/10 border-white/30 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer"
                        />
                        <x-input-label for="is_active" :value="__('Impuesto Activo')" class="ml-3 text-white/90 cursor-pointer" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                </div>

                {{-- Botones de Acción --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 pt-4 border-t border-white/10">
                    <button type="submit" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs sm:text-sm md:text-base">Crear Impuesto</span>
                    </button>
                    <a href="{{ route('admin.tax-rates.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>





