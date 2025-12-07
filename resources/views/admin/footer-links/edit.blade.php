<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Editar Enlace del Footer') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('admin.footer-links.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Enlaces
                </a>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                    Editar Enlace del Footer
                </h1>
                <p class="text-xs sm:text-sm md:text-base text-white/80">
                    Modifica la información del enlace
                </p>
            </div>

            <form method="POST" action="{{ route('admin.footer-links.update', $footerLink) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Etiqueta --}}
                <div>
                    <x-input-label for="label" :value="__('Etiqueta del Enlace')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="label" 
                        name="label" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('label', $footerLink->label)" 
                        required 
                        autofocus 
                        placeholder="Ej: Inicio, Cotizador, Twitter, etc."
                    />
                    <p class="mt-1 text-xs text-white/60">Texto que se mostrará en el enlace</p>
                    <x-input-error class="mt-2" :messages="$errors->get('label')" />
                </div>

                {{-- URL --}}
                <div>
                    <x-input-label for="url" :value="__('URL')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="url" 
                        name="url" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('url', $footerLink->url)" 
                        required 
                        placeholder="https://ejemplo.com o {{ route('home') }}"
                    />
                    <p class="mt-1 text-xs text-white/60">URL completa del enlace (puede ser una ruta interna o externa)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('url')" />
                </div>

                {{-- Tipo --}}
                <div>
                    <x-input-label for="type" :value="__('Tipo de Enlace')" class="text-white/90 mb-2" />
                    <select 
                        id="type" 
                        name="type" 
                        class="auth-form-input"
                        required
                        onchange="toggleIconField()"
                    >
                        <option value="link" {{ old('type', $footerLink->type) === 'link' ? 'selected' : '' }}>Enlace Normal</option>
                        <option value="social" {{ old('type', $footerLink->type) === 'social' ? 'selected' : '' }}>Red Social</option>
                    </select>
                    <p class="mt-1 text-xs text-white/60">Selecciona si es un enlace normal o una red social</p>
                    <x-input-error class="mt-2" :messages="$errors->get('type')" />
                </div>

                {{-- Icono SVG (solo para redes sociales) --}}
                <div id="icon_svg_field" style="display: {{ old('type', $footerLink->type) === 'social' ? 'block' : 'none' }};">
                    <x-input-label for="icon_svg" :value="__('Icono SVG')" class="text-white/90 mb-2" />
                    <textarea 
                        id="icon_svg" 
                        name="icon_svg" 
                        class="auth-form-input font-mono text-xs" 
                        rows="4"
                        placeholder='<svg class="social-icon" viewBox="0 0 24 24">...</svg>'
                    >{{ old('icon_svg', $footerLink->icon_svg) }}</textarea>
                    <p class="mt-1 text-xs text-white/60">Código SVG del icono de la red social (opcional, solo para redes sociales)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('icon_svg')" />
                </div>

                {{-- Orden --}}
                <div>
                    <x-input-label for="order" :value="__('Orden')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="order" 
                        name="order" 
                        type="number" 
                        class="auth-form-input" 
                        :value="old('order', $footerLink->order)" 
                        min="0"
                        placeholder="0"
                    />
                    <p class="mt-1 text-xs text-white/60">Orden de aparición (menor número aparece primero)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('order')" />
                </div>

                {{-- Estado Activo --}}
                <div class="auth-form-checkbox">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1"
                        {{ old('is_active', $footerLink->is_active) ? 'checked' : '' }}
                    >
                    <label for="is_active" class="text-white/90">
                        Enlace activo (se mostrará en el footer)
                    </label>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('is_active')" />

                {{-- Botones de Acción --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3 pt-4 border-t border-white/10">
                    <button type="submit" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center min-w-0">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs sm:text-sm md:text-base truncate">Guardar Cambios</span>
                    </button>
                    <a href="{{ route('admin.footer-links.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center min-w-0" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base truncate">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>

    <script>
        function toggleIconField() {
            const typeSelect = document.getElementById('type');
            const iconField = document.getElementById('icon_svg_field');
            if (typeSelect.value === 'social') {
                iconField.style.display = 'block';
            } else {
                iconField.style.display = 'none';
            }
        }
    </script>
</x-app-layout>





