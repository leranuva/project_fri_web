<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Editar Tarifa de Envío') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('admin.shipping-rates.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Tarifas de Envío
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                            Editar Tarifa de Envío
                        </h1>
                        <p class="text-xs sm:text-sm md:text-base text-white/80 truncate">
                            Modifica la información de la tarifa: <span class="text-white font-semibold capitalize">{{ $shippingRate->method }}</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <a href="{{ route('admin.shipping-rates.show', $shippingRate) }}" class="glass-button glass-button-sm w-full sm:w-auto flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span class="text-xs sm:text-sm md:text-base">Ver Detalles</span>
                        </a>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.shipping-rates.update', $shippingRate) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Información Básica --}}
                <div class="space-y-4 pb-4 border-b border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Información Básica</h3>

                    {{-- Método de Envío --}}
                    <div>
                        <x-input-label for="method" :value="__('Método de Envío')" class="text-white/90 mb-2" />
                        <select 
                            id="method" 
                            name="method" 
                            class="auth-form-input" 
                            required
                        >
                            <option value="">Seleccione un método</option>
                            <option value="maritimo" {{ old('method', $shippingRate->method) === 'maritimo' ? 'selected' : '' }}>Marítimo</option>
                            <option value="aereo" {{ old('method', $shippingRate->method) === 'aereo' ? 'selected' : '' }}>Aéreo</option>
                            <option value="aereoExpres" {{ old('method', $shippingRate->method) === 'aereoExpres' ? 'selected' : '' }}>Aéreo Express</option>
                            <option value="courier4x4" {{ old('method', $shippingRate->method) === 'courier4x4' ? 'selected' : '' }}>Courier 4x4</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('method')" />
                    </div>

                    {{-- Notas --}}
                    <div>
                        <x-input-label for="notes" :value="__('Notas')" class="text-white/90 mb-2" />
                        <textarea 
                            id="notes" 
                            name="notes" 
                            rows="3"
                            class="auth-form-input" 
                            placeholder="Notas adicionales sobre la tarifa (opcional)"
                        >{{ old('notes', $shippingRate->notes) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                    </div>
                </div>

                {{-- Información de Peso y Costos --}}
                <div class="space-y-4 pb-4 border-b border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Información de Peso y Costos</h3>

                    {{-- Peso Mínimo --}}
                    <div>
                        <x-input-label for="min_weight" :value="__('Peso Mínimo (lb)')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="min_weight" 
                            name="min_weight" 
                            type="number" 
                            step="0.01"
                            min="0"
                            class="auth-form-input" 
                            :value="old('min_weight', $shippingRate->min_weight)" 
                            required 
                            placeholder="0.00"
                        />
                        <p class="mt-1 text-xs text-white/60">Peso mínimo en libras</p>
                        <x-input-error class="mt-2" :messages="$errors->get('min_weight')" />
                    </div>

                    {{-- Peso Máximo --}}
                    <div>
                        <x-input-label for="max_weight" :value="__('Peso Máximo (lb)')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="max_weight" 
                            name="max_weight" 
                            type="number" 
                            step="0.01"
                            min="0"
                            class="auth-form-input" 
                            :value="old('max_weight', $shippingRate->max_weight)" 
                            placeholder="Dejar vacío para sin límite"
                        />
                        <p class="mt-1 text-xs text-white/60">Peso máximo en libras (opcional, dejar vacío para sin límite)</p>
                        <x-input-error class="mt-2" :messages="$errors->get('max_weight')" />
                    </div>

                    {{-- Valor FOB Máximo --}}
                    <div>
                        <x-input-label for="max_value_fob" :value="__('Valor FOB Máximo (USD)')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="max_value_fob" 
                            name="max_value_fob" 
                            type="number" 
                            step="0.01"
                            min="0"
                            class="auth-form-input" 
                            :value="old('max_value_fob', $shippingRate->max_value_fob)" 
                            placeholder="Para Courier 4x4: 400.00"
                        />
                        <p class="mt-1 text-xs text-white/60">Valor FOB máximo en USD (opcional, principalmente para Courier 4x4)</p>
                        <x-input-error class="mt-2" :messages="$errors->get('max_value_fob')" />
                    </div>

                    {{-- Costo por Libra --}}
                    <div>
                        <x-input-label for="cost_per_pound" :value="__('Costo por Libra (USD)')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="cost_per_pound" 
                            name="cost_per_pound" 
                            type="number" 
                            step="0.01"
                            min="0"
                            class="auth-form-input" 
                            :value="old('cost_per_pound', $shippingRate->cost_per_pound)" 
                            required 
                            placeholder="0.00"
                        />
                        <p class="mt-1 text-xs text-white/60">Costo por libra en USD (0.00 para Courier 4x4 que usa costo fijo)</p>
                        <x-input-error class="mt-2" :messages="$errors->get('cost_per_pound')" />
                    </div>

                    {{-- Costo Fijo --}}
                    <div>
                        <x-input-label for="fixed_cost" :value="__('Costo Fijo (USD)')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="fixed_cost" 
                            name="fixed_cost" 
                            type="number" 
                            step="0.01"
                            min="0"
                            class="auth-form-input" 
                            :value="old('fixed_cost', $shippingRate->fixed_cost)" 
                            placeholder="Para Courier 4x4: 20.00"
                        />
                        <p class="mt-1 text-xs text-white/60">Costo fijo en USD (opcional, principalmente para Courier 4x4)</p>
                        <x-input-error class="mt-2" :messages="$errors->get('fixed_cost')" />
                    </div>
                </div>

                {{-- Configuración --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white mb-4">Configuración</h3>

                    {{-- Caso Especial --}}
                    <div class="flex items-center p-4 rounded-lg bg-white/5 border border-white/10">
                        <input 
                            id="is_special_case" 
                            name="is_special_case" 
                            type="checkbox" 
                            value="1"
                            {{ old('is_special_case', $shippingRate->is_special_case) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 bg-white/10 border-white/30 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer"
                        />
                        <x-input-label for="is_special_case" :value="__('Caso Especial')" class="ml-3 text-white/90 cursor-pointer" />
                    </div>
                    <p class="text-xs text-white/60 -mt-2">Marcar si es un caso especial (ej: aéreo peso 1, Courier 4x4)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('is_special_case')" />

                    {{-- Estado Activo --}}
                    <div class="flex items-center p-4 rounded-lg bg-white/5 border border-white/10">
                        <input 
                            id="is_active" 
                            name="is_active" 
                            type="checkbox" 
                            value="1"
                            {{ old('is_active', $shippingRate->is_active) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 bg-white/10 border-white/30 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer"
                        />
                        <x-input-label for="is_active" :value="__('Tarifa Activa')" class="ml-3 text-white/90 cursor-pointer" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('is_active')" />

                    {{-- Orden de Visualización --}}
                    <div>
                        <x-input-label for="sort_order" :value="__('Orden de Evaluación')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="sort_order" 
                            name="sort_order" 
                            type="number" 
                            min="0"
                            class="auth-form-input" 
                            :value="old('sort_order', $shippingRate->sort_order)" 
                            placeholder="0"
                        />
                        <p class="mt-1 text-xs text-white/60">Número menor = se evalúa primero</p>
                        <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                    </div>
                </div>

                {{-- Información adicional --}}
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-sm font-semibold text-white/90 mb-3">Información de la Tarifa</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-white/70">ID:</p>
                            <p class="text-white font-medium">{{ $shippingRate->id }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Creado:</p>
                            <p class="text-white font-medium">{{ $shippingRate->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Última actualización:</p>
                            <p class="text-white font-medium">{{ $shippingRate->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Estado:</p>
                            <p class="text-white font-medium">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $shippingRate->is_active ? 'bg-green-500/30 text-green-200' : 'bg-red-500/30 text-red-200' }}">
                                    {{ $shippingRate->is_active ? 'Activo' : 'Inactivo' }}
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
                    <a href="{{ route('admin.shipping-rates.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>





