<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Editar Producto') }}
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
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                            Editar Producto
                        </h1>
                        <p class="text-xs sm:text-sm md:text-base text-white/80 truncate">
                            Modifica la información del producto: {{ $product->name }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <a href="{{ route('admin.products.show', $product) }}" class="glass-button glass-button-sm w-full sm:w-auto flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span class="text-xs sm:text-sm md:text-base">Ver Detalles</span>
                        </a>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.products.update', $product) }}" class="space-y-6">
                @csrf
                @method('PATCH')

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
                            :value="old('key', $product->key)" 
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
                            :value="old('name', $product->name)" 
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
                        >{{ old('description', $product->description) }}</textarea>
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
                            :value="old('category', $product->category)" 
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
                            :value="old('arancel_code', $product->arancel_code)" 
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
                            :value="old('arancel_subpartida', $product->arancel_subpartida)" 
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
                            :value="old('ad_valorem', $product->ad_valorem)" 
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
                            :value="old('arancel_especifico', $product->arancel_especifico)" 
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
                            :value="old('new_percent', $product->new_percent)" 
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
                            {{ old('is_active', $product->is_active) ? 'checked' : '' }}
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
                            :value="old('sort_order', $product->sort_order)" 
                            placeholder="0"
                        />
                        <p class="mt-1 text-xs text-white/60">Número menor = aparece primero en las listas</p>
                        <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                    </div>
                </div>

                {{-- Información adicional --}}
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-sm font-semibold text-white/90 mb-3">Información del Producto</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-white/70">ID:</p>
                            <p class="text-white font-medium">{{ $product->id }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Creado:</p>
                            <p class="text-white font-medium">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Última actualización:</p>
                            <p class="text-white font-medium">{{ $product->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Estado:</p>
                            <p class="text-white font-medium">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $product->is_active ? 'bg-green-500/30 text-green-200' : 'bg-red-500/30 text-red-200' }}">
                                    {{ $product->is_active ? 'Activo' : 'Inactivo' }}
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
                    <a href="{{ route('admin.products.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>





