<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Crear Nuevo Producto') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Productos
                </a>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                    Crear Nuevo Producto
                </h1>
                <p class="text-xs sm:text-sm md:text-base text-white/80">
                    Completa el formulario para crear un nuevo producto en el sistema.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.products.store') }}" class="space-y-6">
                @csrf

                {{-- Información Básica --}}
                <div class="space-y-4 pb-4 border-b border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Información Básica</h3>

                    {{-- Clave (Key) --}}
                    <div>
                        <x-input-label for="key" :value="__('Clave del Producto')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="key" 
                            name="key" 
                            type="text" 
                            class="auth-form-input" 
                            :value="old('key')" 
                            required 
                            autofocus 
                            placeholder="Ej: Laptos, Tablets, Smartphones"
                        />
                        <p class="mt-1 text-xs text-white/60">Clave única para identificar el producto (sin espacios, usar mayúsculas)</p>
                        <x-input-error class="mt-2" :messages="$errors->get('key')" />
                    </div>

                    {{-- Nombre --}}
                    <div>
                        <x-input-label for="name" :value="__('Nombre del Producto')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="name" 
                            name="name" 
                            type="text" 
                            class="auth-form-input" 
                            :value="old('name')" 
                            required 
                            placeholder="Ej: Laptops, Tablets, Smartphones"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <x-input-label for="description" :value="__('Descripción')" class="text-white/90 mb-2" />
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="3"
                            class="auth-form-input" 
                            placeholder="Descripción detallada del producto (opcional)"
                        >{{ old('description') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    {{-- Categoría --}}
                    <div>
                        <x-input-label for="category" :value="__('Categoría')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="category" 
                            name="category" 
                            type="text" 
                            class="auth-form-input" 
                            :value="old('category')" 
                            placeholder="Ej: Electrónica, Ropa, Accesorios (opcional)"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('category')" />
                    </div>
                </div>

                {{-- Información de Aranceles --}}
                <div class="space-y-4 pb-4 border-b border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Información de Aranceles</h3>

                    {{-- Código Arancel --}}
                    <div>
                        <x-input-label for="arancel_code" :value="__('Código Arancel (NANDINA)')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="arancel_code" 
                            name="arancel_code" 
                            type="text" 
                            class="auth-form-input" 
                            :value="old('arancel_code')" 
                            placeholder="Ej: 8471.30.11.00"
                        />
                        <p class="mt-1 text-xs text-white/60">Código NANDINA del producto (opcional)</p>
                        <x-input-error class="mt-2" :messages="$errors->get('arancel_code')" />
                    </div>

                    {{-- Subpartida Arancelaria --}}
                    <div>
                        <x-input-label for="arancel_subpartida" :value="__('Subpartida Arancelaria')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="arancel_subpartida" 
                            name="arancel_subpartida" 
                            type="text" 
                            class="auth-form-input" 
                            :value="old('arancel_subpartida')" 
                            placeholder="Ej: 8471.30.11"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('arancel_subpartida')" />
                    </div>

                    {{-- Ad-Valorem --}}
                    <div>
                        <x-input-label for="ad_valorem" :value="__('Ad-Valorem (%)')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="ad_valorem" 
                            name="ad_valorem" 
                            type="number" 
                            step="0.0001"
                            min="0"
                            max="1"
                            class="auth-form-input" 
                            :value="old('ad_valorem', 0)" 
                            required 
                            placeholder="Ej: 0.30 para 30%"
                        />
                        <p class="mt-1 text-xs text-white/60">Ingrese como decimal (0.30 = 30%)</p>
                        <x-input-error class="mt-2" :messages="$errors->get('ad_valorem')" />
                    </div>

                    {{-- Arancel Específico --}}
                    <div>
                        <x-input-label for="arancel_especifico" :value="__('Arancel Específico (USD)')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="arancel_especifico" 
                            name="arancel_especifico" 
                            type="number" 
                            step="0.01"
                            min="0"
                            class="auth-form-input" 
                            :value="old('arancel_especifico', 0)" 
                            placeholder="0.00"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('arancel_especifico')" />
                    </div>

                    {{-- New Percent --}}
                    <div>
                        <x-input-label for="new_percent" :value="__('Porcentaje Adicional (%)')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="new_percent" 
                            name="new_percent" 
                            type="number" 
                            step="0.0001"
                            min="0"
                            max="1"
                            class="auth-form-input" 
                            :value="old('new_percent')" 
                            placeholder="Ej: 0.10 para 10% (opcional)"
                        />
                        <p class="mt-1 text-xs text-white/60">Porcentaje adicional para algunos productos (opcional)</p>
                        <x-input-error class="mt-2" :messages="$errors->get('new_percent')" />
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
                        <x-input-label for="is_active" :value="__('Producto Activo')" class="ml-3 text-white/90 cursor-pointer" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('is_active')" />

                    {{-- Orden de Visualización --}}
                    <div>
                        <x-input-label for="sort_order" :value="__('Orden de Visualización')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="sort_order" 
                            name="sort_order" 
                            type="number" 
                            min="0"
                            class="auth-form-input" 
                            :value="old('sort_order', 0)" 
                            placeholder="0"
                        />
                        <p class="mt-1 text-xs text-white/60">Número menor = aparece primero en las listas</p>
                        <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 pt-4 border-t border-white/10">
                    <button type="submit" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs sm:text-sm md:text-base">Crear Producto</span>
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>

