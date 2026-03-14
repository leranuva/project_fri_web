<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Configuración de la Sección de Beneficios') }}
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
                <a href="{{ route('admin.benefits.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Beneficios
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                            Configuración de la Sección de Beneficios
                        </h1>
                        <p class="text-xs sm:text-sm md:text-base text-white/80">
                            Edita el título principal de la sección "¿Por qué elegir Flat Rate Imports?"
                        </p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.benefit-sections.update', $benefitSection) }}" class="space-y-6">
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
                        :value="old('title', $benefitSection->title)" 
                        required 
                        placeholder="Ej: ¿Por qué elegir Flat Rate Imports?"
                        autofocus
                    />
                    <p class="mt-1 text-xs text-white/60">Título principal que aparece en la parte superior de la sección de beneficios</p>
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                {{-- Color del Título --}}
                <div>
                    <x-input-label for="title_color" :value="__('Color del Título')" class="text-white/90 mb-2" />
                    <div class="flex items-center gap-4">
                        <input 
                            type="color" 
                            id="title_color" 
                            name="title_color" 
                            value="{{ old('title_color', $benefitSection->title_color ?? '#ffffff') }}"
                            class="w-20 h-12 rounded-lg border-2 border-white/30 cursor-pointer"
                            style="background: transparent;"
                            onchange="document.getElementById('title_color_hex').value = this.value"
                        >
                        <x-text-input 
                            type="text" 
                            id="title_color_hex" 
                            class="auth-form-input flex-1" 
                            value="{{ old('title_color', $benefitSection->title_color ?? '#ffffff') }}"
                            placeholder="#ffffff"
                            pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                            onchange="document.getElementById('title_color').value = this.value"
                        />
                    </div>
                    <p class="mt-1 text-xs text-white/60">Selecciona o ingresa un color hexadecimal para el título</p>
                    <x-input-error class="mt-2" :messages="$errors->get('title_color')" />
                </div>

                {{-- Estado Activo --}}
                <div class="auth-form-checkbox">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1"
                        {{ old('is_active', $benefitSection->is_active) ? 'checked' : '' }}
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
                    <a href="{{ route('admin.benefits.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>

