<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Configuración de la Sección "¿Cómo Funciona?"') }}
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
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                            Configuración de la Sección "¿Cómo Funciona?"
                        </h1>
                        <p class="text-xs sm:text-sm md:text-base text-white/80">
                            Edita el título, subtítulo y texto de la sección de pasos del proceso
                        </p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.process-sections.update', $processSection) }}" class="space-y-6">
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
                        :value="old('title', $processSection->title)" 
                        required 
                        placeholder="Ej: ¿CÓMO FUNCIONA FLAT RATE IMPORTS?"
                        autofocus
                    />
                    <p class="mt-1 text-xs text-white/60">Título principal que aparece en la parte superior de la sección</p>
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                {{-- Subtítulo --}}
                <div>
                    <x-input-label for="subtitle" :value="__('Subtítulo de la Sección')" class="text-white/90 mb-2" />
                    <textarea 
                        id="subtitle" 
                        name="subtitle" 
                        class="auth-form-input" 
                        rows="3"
                        placeholder="Ej: El proceso es fácil: compras, alertas en tu panel de usuario, recibimos en la casilla, importamos."
                    >{{ old('subtitle', $processSection->subtitle) }}</textarea>
                    <p class="mt-1 text-xs text-white/60">Subtítulo que aparece debajo del título principal</p>
                    <x-input-error class="mt-2" :messages="$errors->get('subtitle')" />
                </div>

                {{-- Texto del Footer --}}
                <div>
                    <x-input-label for="footer_text" :value="__('Texto Debajo de los Cards')" class="text-white/90 mb-2" />
                    <textarea 
                        id="footer_text" 
                        name="footer_text" 
                        class="auth-form-input" 
                        rows="4"
                        placeholder="Ej: FLAT RATE IMPORTS tiene más de 10 años en el mercado, ofreciendo seguridad y rapidez en tus entregas."
                    >{{ old('footer_text', $processSection->footer_text) }}</textarea>
                    <p class="mt-1 text-xs text-white/60">Texto que aparece debajo de los cards de pasos del proceso</p>
                    <x-input-error class="mt-2" :messages="$errors->get('footer_text')" />
                </div>

                {{-- Botón --}}
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-base font-semibold text-white mb-4">Botón Debajo de los Cards</h3>
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="button_text" :value="__('Texto del Botón')" class="text-white/90 mb-2" />
                            <x-text-input 
                                id="button_text" 
                                name="button_text" 
                                type="text" 
                                class="auth-form-input" 
                                :value="old('button_text', $processSection->button_text)" 
                                placeholder="Ej: Más Información"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('button_text')" />
                        </div>
                        <div>
                            <x-input-label for="button_link" :value="__('Enlace del Botón')" class="text-white/90 mb-2" />
                            <x-text-input 
                                id="button_link" 
                                name="button_link" 
                                type="text" 
                                class="auth-form-input" 
                                :value="old('button_link', $processSection->button_link)" 
                                placeholder="Ej: /cotizador o route('cotizador')"
                            />
                            <p class="mt-1 text-xs text-white/60">Puedes usar rutas de Laravel (ej: route('cotizador')) o URLs directas (ej: /cotizador)</p>
                            <x-input-error class="mt-2" :messages="$errors->get('button_link')" />
                        </div>
                    </div>
                </div>

                {{-- Estado Activo --}}
                <div class="auth-form-checkbox">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1"
                        {{ old('is_active', $processSection->is_active) ? 'checked' : '' }}
                    >
                    <label for="is_active" class="text-white/90">
                        Sección activa (se mostrará en la página de inicio)
                    </label>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('is_active')" />

                {{-- Información adicional --}}
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-sm font-semibold text-white/90 mb-3">Información de la Sección</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-white/70">ID:</p>
                            <p class="text-white font-medium">{{ $processSection->id }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Creado:</p>
                            <p class="text-white font-medium">{{ $processSection->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Última actualización:</p>
                            <p class="text-white font-medium">{{ $processSection->updated_at->format('d/m/Y H:i') }}</p>
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
                    <a href="{{ route('admin.process-steps.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base">Gestionar Pasos</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>

