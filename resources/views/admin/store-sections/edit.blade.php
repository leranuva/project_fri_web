<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Configuración de la Sección de Tiendas') }}
        </h2>
    </x-slot>

    <x-ui.container>
        {{-- Mensajes de éxito/error --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-500/20 border border-green-500/30 backdrop-blur-sm">
                <div class="flex items-center gap-2 text-green-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/30 backdrop-blur-sm">
                <div class="flex items-center gap-2 text-red-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

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
                            Configuración de la Sección de Tiendas
                        </h1>
                        <p class="text-xs sm:text-sm md:text-base text-white/80">
                            Edita el título y configuración de la sección "Compra en todas estas tiendas"
                        </p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.store-sections.update', $storeSection) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Título --}}
                <div>
                    <x-input-label for="title" :value="__('Título de la Sección')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="title" 
                        name="title" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('title', $storeSection->title)" 
                        required 
                        placeholder="Ej: Compra en todas estas tiendas"
                        autofocus
                    />
                    <p class="mt-1 text-xs text-white/60">Título principal que aparece en la parte superior de la sección de tiendas</p>
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                {{-- Subtítulo --}}
                <div>
                    <x-input-label for="subtitle" :value="__('Subtítulo')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="subtitle" 
                        name="subtitle" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('subtitle', $storeSection->subtitle)" 
                        placeholder="Ej: ¡Y muchas más!"
                    />
                    <p class="mt-1 text-xs text-white/60">Texto que aparece debajo del título principal</p>
                    <x-input-error class="mt-2" :messages="$errors->get('subtitle')" />
                </div>

                {{-- Color del Título --}}
                <div>
                    <x-input-label for="title_color" :value="__('Color del Título')" class="text-white/90 mb-2" />
                    <div class="flex items-center gap-4">
                        <input 
                            type="color" 
                            id="title_color" 
                            name="title_color" 
                            value="{{ old('title_color', $storeSection->title_color ?? '#ffffff') }}"
                            class="w-20 h-12 rounded-lg border-2 border-white/30 cursor-pointer"
                            style="background: transparent;"
                            onchange="document.getElementById('title_color_hex').value = this.value"
                        >
                        <x-text-input 
                            type="text" 
                            id="title_color_hex" 
                            class="auth-form-input flex-1" 
                            value="{{ old('title_color', $storeSection->title_color ?? '#ffffff') }}"
                            placeholder="#ffffff"
                            pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                            onchange="document.getElementById('title_color').value = this.value"
                        />
                    </div>
                    <p class="mt-1 text-xs text-white/60">Selecciona o ingresa un color hexadecimal para el título</p>
                    <x-input-error class="mt-2" :messages="$errors->get('title_color')" />
                </div>

                {{-- Color del Subtítulo --}}
                <div>
                    <x-input-label for="subtitle_color" :value="__('Color del Subtítulo')" class="text-white/90 mb-2" />
                    <div class="flex items-center gap-4">
                        <input 
                            type="color" 
                            id="subtitle_color" 
                            name="subtitle_color" 
                            value="{{ old('subtitle_color', $storeSection->subtitle_color ?? 'rgba(255, 255, 255, 0.8)') }}"
                            class="w-20 h-12 rounded-lg border-2 border-white/30 cursor-pointer"
                            style="background: transparent;"
                            onchange="document.getElementById('subtitle_color_hex').value = this.value"
                        >
                        <x-text-input 
                            type="text" 
                            id="subtitle_color_hex" 
                            class="auth-form-input flex-1" 
                            value="{{ old('subtitle_color', $storeSection->subtitle_color ?? 'rgba(255, 255, 255, 0.8)') }}"
                            placeholder="rgba(255, 255, 255, 0.8)"
                        />
                    </div>
                    <p class="mt-1 text-xs text-white/60">Selecciona o ingresa un color para el subtítulo (puede ser rgba o hex)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('subtitle_color')" />
                </div>

                {{-- Enlace del Footer --}}
                <div>
                    <x-input-label for="footer_link" :value="__('Enlace del Footer')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="footer_link" 
                        name="footer_link" 
                        type="url" 
                        class="auth-form-input" 
                        :value="old('footer_link', $storeSection->footer_link)" 
                        placeholder="https://flatrateimports.store/"
                    />
                    <p class="mt-1 text-xs text-white/60">URL del enlace que aparece al final de la sección (opcional)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('footer_link')" />
                </div>

                {{-- Texto del Enlace del Footer --}}
                <div>
                    <x-input-label for="footer_link_text" :value="__('Texto del Enlace del Footer')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="footer_link_text" 
                        name="footer_link_text" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('footer_link_text', $storeSection->footer_link_text)" 
                        placeholder="Revisar todas las tiendas"
                    />
                    <p class="mt-1 text-xs text-white/60">Texto que se mostrará en el enlace del footer</p>
                    <x-input-error class="mt-2" :messages="$errors->get('footer_link_text')" />
                </div>

                {{-- Estado Activo --}}
                <div class="auth-form-checkbox">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1"
                        {{ old('is_active', $storeSection->is_active) ? 'checked' : '' }}
                    >
                    <label for="is_active" class="text-white/90">
                        Sección activa (se mostrará en la página de inicio)
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
</x-app-layout>





