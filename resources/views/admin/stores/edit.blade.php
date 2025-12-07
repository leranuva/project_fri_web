<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Editar Tienda') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('admin.stores.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Tiendas
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                            Editar Tienda
                        </h1>
                        <p class="text-xs sm:text-sm md:text-base text-white/80 truncate">
                            Modifica la información de la tienda: {{ $store->name }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <a href="{{ route('admin.stores.show', $store) }}" class="glass-button glass-button-sm w-full sm:w-auto flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span class="text-xs sm:text-sm md:text-base">Ver Detalles</span>
                        </a>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.stores.update', $store) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Nombre --}}
                <div>
                    <x-input-label for="name" :value="__('Nombre de la Tienda')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="name" 
                        name="name" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('name', $store->name)" 
                        required 
                        autofocus 
                        placeholder="Ej: Amazon"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                {{-- Código SVG del Logo --}}
                <div>
                    <x-input-label for="logo_url" :value="__('Código SVG del Logo')" class="text-white/90 mb-2" />
                    <textarea
                        id="logo_url" 
                        name="logo_url" 
                        rows="6"
                        class="auth-form-input font-mono text-sm" 
                        placeholder='<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">...</svg>'
                    >{{ old('logo_url', $store->logo_url) }}</textarea>
                    <p class="mt-1 text-xs text-white/60">Ingresa el código SVG completo del logo de la tienda (opcional)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('logo_url')" />
                    
                    {{-- Vista previa del logo --}}
                    <div id="logo_preview" class="mt-4 p-4 rounded-xl bg-white/5 border border-white/10" style="display: {{ $store->logo_url ? 'block' : 'none' }};">
                        <p class="text-sm text-white/70 mb-2">Vista previa del logo:</p>
                        <div class="flex items-center justify-center p-4 bg-white/10 rounded-lg min-h-[80px]">
                            <div id="preview_logo_content" class="max-w-full max-h-32 flex items-center justify-center">
                                {!! $store->logo_url ?? '' !!}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- URL del Sitio Web --}}
                <div>
                    <x-input-label for="website_url" :value="__('URL del Sitio Web')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="website_url" 
                        name="website_url" 
                        type="url" 
                        class="auth-form-input" 
                        :value="old('website_url', $store->website_url)" 
                        placeholder="https://www.tienda.com"
                    />
                    <p class="mt-1 text-xs text-white/60">URL del sitio web de la tienda (opcional, se usará como enlace al hacer clic en el logo)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('website_url')" />
                </div>

                {{-- Orden --}}
                <div>
                    <x-input-label for="order" :value="__('Orden')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="order" 
                        name="order" 
                        type="number" 
                        class="auth-form-input" 
                        :value="old('order', $store->order)" 
                        min="0"
                        placeholder="0"
                    />
                    <p class="mt-1 text-xs text-white/60">Las tiendas se mostrarán ordenadas por este número (menor = primero)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('order')" />
                </div>

                {{-- Estado Activo --}}
                <div class="auth-form-checkbox">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1"
                        {{ old('is_active', $store->is_active) ? 'checked' : '' }}
                    >
                    <label for="is_active" class="text-white/90">
                        Tienda activa (se mostrará en la sección "Compra en todas estas tiendas")
                    </label>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('is_active')" />

                {{-- Botones de Acción --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 pt-4 border-t border-white/10">
                    <button type="submit" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs sm:text-sm md:text-base">Guardar Cambios</span>
                    </button>
                    <a href="{{ route('admin.stores.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>

    <script>
        // Vista previa del logo SVG
        document.getElementById('logo_url').addEventListener('input', function(e) {
            const preview = document.getElementById('logo_preview');
            const previewContent = document.getElementById('preview_logo_content');
            const logoSvg = e.target.value.trim();
            
            if (logoSvg) {
                previewContent.innerHTML = logoSvg;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        });
    </script>
</x-app-layout>





