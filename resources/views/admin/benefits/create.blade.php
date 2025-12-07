<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Crear Nuevo Beneficio') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('admin.benefits.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Beneficios
                </a>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                    Crear Nuevo Beneficio
                </h1>
                <p class="text-xs sm:text-sm md:text-base text-white/80">
                    Completa el formulario para crear un nuevo beneficio en la sección "¿Por qué elegir Flat Rate Imports?"
                </p>
            </div>

            <form method="POST" action="{{ route('admin.benefits.store') }}" class="space-y-6">
                @csrf

                {{-- Título --}}
                <div>
                    <x-input-label for="title" :value="__('Título')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="title" 
                        name="title" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('title')" 
                        required 
                        autofocus 
                        placeholder="Ej: Dirección GRATIS"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                {{-- Descripción --}}
                <div>
                    <x-input-label for="description" :value="__('Descripción')" class="text-white/90 mb-2" />
                    <textarea 
                        id="description" 
                        name="description" 
                        class="auth-form-input" 
                        rows="4"
                        required
                        placeholder="Ej: Obtén una dirección de casillero postal en USA totalmente gratis al registrarte"
                    >{{ old('description') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                {{-- Color del Título --}}
                <div>
                    <x-input-label for="title_color" :value="__('Color del Título')" class="text-white/90 mb-2" />
                    <div class="flex items-center gap-4">
                        <input 
                            type="color" 
                            id="title_color" 
                            name="title_color" 
                            value="{{ old('title_color', '#ffffff') }}"
                            class="w-20 h-12 rounded-lg border-2 border-white/30 cursor-pointer"
                            style="background: transparent;"
                            onchange="document.getElementById('title_color_hex').value = this.value"
                        >
                        <x-text-input 
                            type="text" 
                            id="title_color_hex" 
                            class="auth-form-input flex-1" 
                            value="{{ old('title_color', '#ffffff') }}"
                            placeholder="#ffffff"
                            pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                            onchange="document.getElementById('title_color').value = this.value"
                        />
                    </div>
                    <p class="mt-1 text-xs text-white/60">Selecciona o ingresa un color hexadecimal para el título</p>
                    <x-input-error class="mt-2" :messages="$errors->get('title_color')" />
                </div>

                {{-- Color de la Descripción --}}
                <div>
                    <x-input-label for="description_color" :value="__('Color de la Descripción')" class="text-white/90 mb-2" />
                    <div class="flex items-center gap-4">
                        <input 
                            type="color" 
                            id="description_color" 
                            name="description_color" 
                            value="{{ old('description_color', '#ffffff') }}"
                            class="w-20 h-12 rounded-lg border-2 border-white/30 cursor-pointer"
                            style="background: transparent;"
                            onchange="document.getElementById('description_color_hex').value = this.value"
                        >
                        <x-text-input 
                            type="text" 
                            id="description_color_hex" 
                            class="auth-form-input flex-1" 
                            value="{{ old('description_color', '#ffffff') }}"
                            placeholder="#ffffff"
                            pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                            onchange="document.getElementById('description_color').value = this.value"
                        />
                    </div>
                    <p class="mt-1 text-xs text-white/60">Selecciona o ingresa un color hexadecimal para la descripción</p>
                    <x-input-error class="mt-2" :messages="$errors->get('description_color')" />
                </div>

                {{-- Icono SVG --}}
                <div>
                    <x-input-label for="icon_svg" :value="__('Icono SVG')" class="text-white/90 mb-2" />
                    <textarea 
                        id="icon_svg" 
                        name="icon_svg" 
                        class="auth-form-input font-mono text-sm" 
                        rows="6"
                        required
                        placeholder='<svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">...</svg>'
                    >{{ old('icon_svg') }}</textarea>
                    <p class="mt-1 text-xs text-white/60">Pega aquí el código SVG completo del icono. Debe incluir las clases: <code class="bg-white/10 px-1 rounded">class="w-12 h-12 mx-auto text-white"</code></p>
                    <x-input-error class="mt-2" :messages="$errors->get('icon_svg')" />
                    
                    {{-- Vista previa del icono --}}
                    <div id="icon_preview" class="mt-4 p-4 rounded-xl bg-white/5 border border-white/10" style="display: none;">
                        <p class="text-sm text-white/70 mb-2">Vista previa del icono:</p>
                        <div class="flex items-center justify-center p-4 bg-white/10 rounded-lg">
                            <div id="preview_icon_content"></div>
                        </div>
                    </div>
                </div>

                {{-- Orden --}}
                <div>
                    <x-input-label for="order" :value="__('Orden')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="order" 
                        name="order" 
                        type="number" 
                        class="auth-form-input" 
                        :value="old('order', 0)" 
                        min="0"
                        placeholder="0"
                    />
                    <p class="mt-1 text-xs text-white/60">Los beneficios se mostrarán ordenados por este número (menor = primero)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('order')" />
                </div>

                {{-- Estado Activo --}}
                <div class="auth-form-checkbox">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1"
                        {{ old('is_active', true) ? 'checked' : '' }}
                    >
                    <label for="is_active" class="text-white/90">
                        Beneficio activo (se mostrará en la sección "¿Por qué elegir Flat Rate Imports?")
                    </label>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('is_active')" />

                {{-- Botones de Acción --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 pt-4 border-t border-white/10">
                    <button type="submit" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs sm:text-sm md:text-base">Crear Beneficio</span>
                    </button>
                    <a href="{{ route('admin.benefits.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>

    <script>
        // Vista previa del icono SVG
        document.getElementById('icon_svg').addEventListener('input', function(e) {
            const preview = document.getElementById('icon_preview');
            const previewContent = document.getElementById('preview_icon_content');
            const svgCode = e.target.value.trim();
            
            if (svgCode) {
                previewContent.innerHTML = svgCode;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        });
    </script>
</x-app-layout>

