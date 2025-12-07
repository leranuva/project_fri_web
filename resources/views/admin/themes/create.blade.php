<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Crear Nuevo Tema') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('admin.themes.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Temas
                </a>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                    Crear Nuevo Tema
                </h1>
                <p class="text-xs sm:text-sm md:text-base text-white/80">
                    Completa el formulario para crear un nuevo tema de colores para la aplicación.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.themes.store') }}" class="space-y-6">
                @csrf

                {{-- Nombre del Tema --}}
                <div>
                    <x-input-label for="name" :value="__('Nombre del Tema')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="name" 
                        name="name" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('name')" 
                        required 
                        autofocus 
                        placeholder="Ej: Tema Azul, Tema Verde, etc."
                    />
                    <p class="mt-1 text-xs text-white/60">Nombre descriptivo para identificar este tema</p>
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                {{-- Colores Principales --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Color Primario --}}
                    <div>
                        <x-input-label for="primary_color" :value="__('Color Primario')" class="text-white/90 mb-2" />
                        <div class="flex items-center gap-2 sm:gap-4">
                            <input 
                                type="color" 
                                id="primary_color" 
                                name="primary_color" 
                                value="{{ old('primary_color', '#667eea') }}"
                                class="w-16 h-10 sm:w-20 sm:h-12 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                style="background: transparent;"
                                onchange="document.getElementById('primary_color_hex').value = this.value"
                            >
                            <x-text-input 
                                type="text" 
                                id="primary_color_hex" 
                                class="auth-form-input flex-1 min-w-0" 
                                value="{{ old('primary_color', '#667eea') }}"
                                placeholder="#667eea"
                                pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                onchange="document.getElementById('primary_color').value = this.value"
                            />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('primary_color')" />
                    </div>

                    {{-- Color Secundario --}}
                    <div>
                        <x-input-label for="secondary_color" :value="__('Color Secundario')" class="text-white/90 mb-2" />
                        <div class="flex items-center gap-2 sm:gap-4">
                            <input 
                                type="color" 
                                id="secondary_color" 
                                name="secondary_color" 
                                value="{{ old('secondary_color', '#764ba2') }}"
                                class="w-16 h-10 sm:w-20 sm:h-12 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                style="background: transparent;"
                                onchange="document.getElementById('secondary_color_hex').value = this.value"
                            >
                            <x-text-input 
                                type="text" 
                                id="secondary_color_hex" 
                                class="auth-form-input flex-1 min-w-0" 
                                value="{{ old('secondary_color', '#764ba2') }}"
                                placeholder="#764ba2"
                                pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                onchange="document.getElementById('secondary_color').value = this.value"
                            />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('secondary_color')" />
                    </div>

                    {{-- Color de Acento --}}
                    <div>
                        <x-input-label for="accent_color" :value="__('Color de Acento')" class="text-white/90 mb-2" />
                        <div class="flex items-center gap-2 sm:gap-4">
                            <input 
                                type="color" 
                                id="accent_color" 
                                name="accent_color" 
                                value="{{ old('accent_color', '#f093fb') }}"
                                class="w-16 h-10 sm:w-20 sm:h-12 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                style="background: transparent;"
                                onchange="document.getElementById('accent_color_hex').value = this.value"
                            >
                            <x-text-input 
                                type="text" 
                                id="accent_color_hex" 
                                class="auth-form-input flex-1 min-w-0" 
                                value="{{ old('accent_color', '#f093fb') }}"
                                placeholder="#f093fb"
                                pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                onchange="document.getElementById('accent_color').value = this.value"
                            />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('accent_color')" />
                    </div>
                </div>

                {{-- Gradiente de Fondo --}}
                <div>
                    <x-input-label :value="__('Gradiente de Fondo')" class="text-white/90 mb-3" />
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Inicio del Gradiente --}}
                        <div>
                            <x-input-label for="background_gradient_start" :value="__('Inicio')" class="text-white/80 mb-2 text-sm" />
                            <div class="flex items-center gap-2 sm:gap-4">
                                <input 
                                    type="color" 
                                    id="background_gradient_start" 
                                    name="background_gradient_start" 
                                    value="{{ old('background_gradient_start', '#667eea') }}"
                                    class="w-12 h-8 sm:w-16 sm:h-10 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                    style="background: transparent;"
                                    onchange="updateGradientPreview()"
                                >
                                <x-text-input 
                                    type="text" 
                                    id="background_gradient_start_hex" 
                                    class="auth-form-input flex-1 min-w-0 text-sm" 
                                    value="{{ old('background_gradient_start', '#667eea') }}"
                                    placeholder="#667eea"
                                    pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                    onchange="document.getElementById('background_gradient_start').value = this.value; updateGradientPreview();"
                                />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('background_gradient_start')" />
                        </div>

                        {{-- Medio del Gradiente --}}
                        <div>
                            <x-input-label for="background_gradient_mid" :value="__('Medio')" class="text-white/80 mb-2 text-sm" />
                            <div class="flex items-center gap-2 sm:gap-4">
                                <input 
                                    type="color" 
                                    id="background_gradient_mid" 
                                    name="background_gradient_mid" 
                                    value="{{ old('background_gradient_mid', '#764ba2') }}"
                                    class="w-12 h-8 sm:w-16 sm:h-10 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                    style="background: transparent;"
                                    onchange="updateGradientPreview()"
                                >
                                <x-text-input 
                                    type="text" 
                                    id="background_gradient_mid_hex" 
                                    class="auth-form-input flex-1 min-w-0 text-sm" 
                                    value="{{ old('background_gradient_mid', '#764ba2') }}"
                                    placeholder="#764ba2"
                                    pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                    onchange="document.getElementById('background_gradient_mid').value = this.value; updateGradientPreview();"
                                />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('background_gradient_mid')" />
                        </div>

                        {{-- Fin del Gradiente --}}
                        <div>
                            <x-input-label for="background_gradient_end" :value="__('Fin')" class="text-white/80 mb-2 text-sm" />
                            <div class="flex items-center gap-2 sm:gap-4">
                                <input 
                                    type="color" 
                                    id="background_gradient_end" 
                                    name="background_gradient_end" 
                                    value="{{ old('background_gradient_end', '#f093fb') }}"
                                    class="w-12 h-8 sm:w-16 sm:h-10 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                    style="background: transparent;"
                                    onchange="updateGradientPreview()"
                                >
                                <x-text-input 
                                    type="text" 
                                    id="background_gradient_end_hex" 
                                    class="auth-form-input flex-1 min-w-0 text-sm" 
                                    value="{{ old('background_gradient_end', '#f093fb') }}"
                                    placeholder="#f093fb"
                                    pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                    onchange="document.getElementById('background_gradient_end').value = this.value; updateGradientPreview();"
                                />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('background_gradient_end')" />
                        </div>
                    </div>
                    {{-- Vista Previa del Gradiente --}}
                    <div class="mt-4 p-4 rounded-xl bg-white/5 border border-white/10">
                        <p class="text-sm text-white/70 mb-2">Vista Previa del Gradiente:</p>
                        <div id="gradient_preview" class="w-full h-20 rounded-lg border-2 border-white/20" style="background: linear-gradient(135deg, {{ old('background_gradient_start', '#667eea') }}, {{ old('background_gradient_mid', '#764ba2') }}, {{ old('background_gradient_end', '#f093fb') }});"></div>
                    </div>
                </div>

                {{-- Colores de Texto --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Color de Texto Principal --}}
                    <div>
                        <x-input-label for="text_color" :value="__('Color de Texto Principal')" class="text-white/90 mb-2" />
                        <div class="flex items-center gap-2 sm:gap-4">
                            <input 
                                type="color" 
                                id="text_color_picker" 
                                value="{{ old('text_color', '#ffffff') }}"
                                class="w-16 h-10 sm:w-20 sm:h-12 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                style="background: transparent;"
                                onchange="document.getElementById('text_color').value = this.value"
                            >
                            <x-text-input 
                                type="text" 
                                id="text_color" 
                                name="text_color"
                                class="auth-form-input flex-1 min-w-0" 
                                value="{{ old('text_color', '#ffffff') }}"
                                placeholder="#ffffff"
                                pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                required
                                onchange="document.getElementById('text_color_picker').value = this.value"
                            />
                        </div>
                        <p class="mt-1 text-xs text-white/60">Debe ser un código hexadecimal (ej: #ffffff)</p>
                        <x-input-error class="mt-2" :messages="$errors->get('text_color')" />
                    </div>

                    {{-- Color de Texto Secundario --}}
                    <div>
                        <x-input-label for="text_secondary_color" :value="__('Color de Texto Secundario')" class="text-white/90 mb-2" />
                        <div class="flex items-center gap-2 sm:gap-4">
                            <input 
                                type="color" 
                                id="text_secondary_color_picker" 
                                value="#ffffff"
                                class="w-16 h-10 sm:w-20 sm:h-12 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                style="background: transparent;"
                                onchange="convertHexToRgba('text_secondary_color_picker', 'text_secondary_color', 0.8)"
                            >
                            <x-text-input 
                                type="text" 
                                id="text_secondary_color" 
                                name="text_secondary_color"
                                class="auth-form-input flex-1 min-w-0" 
                                value="{{ old('text_secondary_color', 'rgba(255, 255, 255, 0.8)') }}"
                                placeholder="rgba(255, 255, 255, 0.8)"
                                onchange="updateColorPickerFromText('text_secondary_color', 'text_secondary_color_picker')"
                            />
                        </div>
                        <p class="mt-1 text-xs text-white/60">Puede ser rgba, hex o nombre de color</p>
                        <x-input-error class="mt-2" :messages="$errors->get('text_secondary_color')" />
                    </div>

                    {{-- Color de Botones --}}
                    <div>
                        <x-input-label for="button_color" :value="__('Color de Botones')" class="text-white/90 mb-2" />
                        <div class="flex items-center gap-2 sm:gap-4">
                            <input 
                                type="color" 
                                id="button_color_picker" 
                                value="#ffffff"
                                class="w-16 h-10 sm:w-20 sm:h-12 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                style="background: transparent;"
                                onchange="convertHexToRgba('button_color_picker', 'button_color', 0.3)"
                            >
                            <x-text-input 
                                type="text" 
                                id="button_color" 
                                name="button_color"
                                class="auth-form-input flex-1 min-w-0" 
                                value="{{ old('button_color', 'rgba(255, 255, 255, 0.3)') }}"
                                placeholder="rgba(255, 255, 255, 0.3)"
                                onchange="updateColorPickerFromText('button_color', 'button_color_picker')"
                            />
                        </div>
                        <p class="mt-1 text-xs text-white/60">Puede ser rgba, hex o nombre de color</p>
                        <x-input-error class="mt-2" :messages="$errors->get('button_color')" />
                    </div>
                </div>

                {{-- Estado Activo --}}
                <div class="auth-form-checkbox">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1"
                        {{ old('is_active') ? 'checked' : '' }}
                    >
                    <label for="is_active" class="text-white/90">
                        Activar este tema (desactivará el tema actual si hay uno activo)
                    </label>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('is_active')" />

                {{-- Botones de Acción --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3 pt-4 border-t border-white/10">
                    <button type="submit" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center min-w-0">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs sm:text-sm md:text-base truncate">Crear Tema</span>
                    </button>
                    <a href="{{ route('admin.themes.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center min-w-0" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base truncate">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>

    <script>
        function updateGradientPreview() {
            const start = document.getElementById('background_gradient_start').value;
            const mid = document.getElementById('background_gradient_mid').value;
            const end = document.getElementById('background_gradient_end').value;
            const preview = document.getElementById('gradient_preview');
            preview.style.background = `linear-gradient(135deg, ${start}, ${mid}, ${end})`;
        }

        // Sincronizar todos los color pickers con sus inputs de texto
        document.querySelectorAll('input[type="color"]').forEach(picker => {
            // Para text_color, el input de texto tiene el mismo id sin _picker
            if (picker.id === 'text_color_picker') {
                const textInput = document.getElementById('text_color');
                if (textInput) {
                    picker.addEventListener('input', function(e) {
                        textInput.value = e.target.value;
                    });
                }
            } else {
                // Para otros campos, buscar el input con _hex
                const hexInput = document.getElementById(picker.id + '_hex');
                if (hexInput) {
                    picker.addEventListener('input', function(e) {
                        hexInput.value = e.target.value;
                        if (picker.id.includes('background_gradient')) {
                            updateGradientPreview();
                        }
                    });
                }
            }
        });

        // Función para convertir hex a rgba
        function convertHexToRgba(pickerId, textInputId, alpha) {
            const picker = document.getElementById(pickerId);
            const textInput = document.getElementById(textInputId);
            const hex = picker.value;
            
            // Convertir hex a rgb
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            
            // Actualizar el input de texto con rgba
            textInput.value = `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }

        // Función para actualizar el color picker desde el texto (si es hex)
        function updateColorPickerFromText(textInputId, pickerId) {
            const textInput = document.getElementById(textInputId);
            const picker = document.getElementById(pickerId);
            const value = textInput.value.trim();
            
            // Si es un valor hex, actualizar el picker
            if (value.match(/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/)) {
                picker.value = value.length === 4 ? 
                    '#' + value[1] + value[1] + value[2] + value[2] + value[3] + value[3] : 
                    value;
            } else if (value.match(/^rgba?\(/)) {
                // Si es rgba, extraer los valores RGB y actualizar el picker
                const matches = value.match(/\d+/g);
                if (matches && matches.length >= 3) {
                    const r = parseInt(matches[0]);
                    const g = parseInt(matches[1]);
                    const b = parseInt(matches[2]);
                    picker.value = '#' + 
                        r.toString(16).padStart(2, '0') + 
                        g.toString(16).padStart(2, '0') + 
                        b.toString(16).padStart(2, '0');
                }
            }
        }

        // Inicializar los color pickers con los valores actuales
        document.addEventListener('DOMContentLoaded', function() {
            // Sincronizar text_color picker con el input
            const textColorInput = document.getElementById('text_color');
            const textColorPicker = document.getElementById('text_color_picker');
            if (textColorInput && textColorPicker) {
                textColorPicker.value = textColorInput.value;
            }
            
            // Inicializar text_secondary_color y button_color
            updateColorPickerFromText('text_secondary_color', 'text_secondary_color_picker');
            updateColorPickerFromText('button_color', 'button_color_picker');
        });
    </script>
</x-app-layout>


