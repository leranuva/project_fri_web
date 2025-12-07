<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Configuración del Cotizador') }}
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

        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al Dashboard
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                            Configuración del Cotizador
                        </h1>
                        <p class="text-xs sm:text-sm md:text-base text-white/80">
                            Edita la configuración general del cotizador de importaciones
                        </p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.cotizador-sections.update', $cotizadorSection) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Título --}}
                <div>
                    <x-input-label for="title" :value="__('Título del Cotizador')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="title" 
                        name="title" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('title', $cotizadorSection->title)" 
                        required 
                        placeholder="Ej: Cotizador de Importaciones"
                        autofocus
                    />
                    <p class="mt-1 text-xs text-white/60">Título principal que aparece en el encabezado del cotizador</p>
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                {{-- Descripción --}}
                <div>
                    <x-input-label for="description" :value="__('Descripción')" class="text-white/90 mb-2" />
                    <textarea 
                        id="description" 
                        name="description" 
                        class="auth-form-input" 
                        rows="3"
                        placeholder="Completa el formulario para obtener una cotización personalizada de tus importaciones."
                    >{{ old('description', $cotizadorSection->description) }}</textarea>
                    <p class="mt-1 text-xs text-white/60">Descripción que aparece debajo del título (opcional)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                {{-- Colores --}}
                <div class="border-t border-white/10 pt-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Colores del Cotizador</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Color del Título Principal --}}
                        <div>
                            <x-input-label for="title_color" :value="__('Color del Título Principal')" class="text-white/90 mb-2" />
                            <div class="flex items-center gap-2 sm:gap-4">
                                <input 
                                    type="color" 
                                    id="title_color_picker" 
                                    value="{{ old('title_color', $cotizadorSection->title_color ?? '#ffffff') }}"
                                    class="w-16 h-10 sm:w-20 sm:h-12 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                    style="background: transparent;"
                                    onchange="document.getElementById('title_color').value = this.value"
                                >
                                <x-text-input 
                                    type="text" 
                                    id="title_color" 
                                    name="title_color"
                                    class="auth-form-input flex-1 min-w-0" 
                                    value="{{ old('title_color', $cotizadorSection->title_color ?? '#ffffff') }}"
                                    placeholder="#ffffff"
                                    pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                    onchange="document.getElementById('title_color_picker').value = this.value"
                                />
                            </div>
                            <p class="mt-1 text-xs text-white/60">Color del título principal del cotizador</p>
                            <x-input-error class="mt-2" :messages="$errors->get('title_color')" />
                        </div>

                        {{-- Color de Títulos de Sección --}}
                        <div>
                            <x-input-label for="section_title_color" :value="__('Color de Títulos de Sección')" class="text-white/90 mb-2" />
                            <div class="flex items-center gap-2 sm:gap-4">
                                <input 
                                    type="color" 
                                    id="section_title_color_picker" 
                                    value="{{ old('section_title_color', $cotizadorSection->section_title_color ?? '#ffffff') }}"
                                    class="w-16 h-10 sm:w-20 sm:h-12 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                    style="background: transparent;"
                                    onchange="document.getElementById('section_title_color').value = this.value"
                                >
                                <x-text-input 
                                    type="text" 
                                    id="section_title_color" 
                                    name="section_title_color"
                                    class="auth-form-input flex-1 min-w-0" 
                                    value="{{ old('section_title_color', $cotizadorSection->section_title_color ?? '#ffffff') }}"
                                    placeholder="#ffffff"
                                    pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                    onchange="document.getElementById('section_title_color_picker').value = this.value"
                                />
                            </div>
                            <p class="mt-1 text-xs text-white/60">Color de "Información del Producto" y "Método de Envío"</p>
                            <x-input-error class="mt-2" :messages="$errors->get('section_title_color')" />
                        </div>

                        {{-- Color del Label "Seleccionar Producto" --}}
                        <div>
                            <x-input-label for="product_label_color" :value="__('Color Label: Seleccionar Producto')" class="text-white/90 mb-2" />
                            <div class="flex items-center gap-2 sm:gap-4">
                                <input 
                                    type="color" 
                                    id="product_label_color_picker" 
                                    value="{{ old('product_label_color', $cotizadorSection->product_label_color ?? '#ffffff') }}"
                                    class="w-16 h-10 sm:w-20 sm:h-12 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                    style="background: transparent;"
                                    onchange="document.getElementById('product_label_color').value = this.value"
                                >
                                <x-text-input 
                                    type="text" 
                                    id="product_label_color" 
                                    name="product_label_color"
                                    class="auth-form-input flex-1 min-w-0" 
                                    value="{{ old('product_label_color', $cotizadorSection->product_label_color ?? '#ffffff') }}"
                                    placeholder="#ffffff"
                                    pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                    onchange="document.getElementById('product_label_color_picker').value = this.value"
                                />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('product_label_color')" />
                        </div>

                        {{-- Color del Label "Cantidad" --}}
                        <div>
                            <x-input-label for="quantity_label_color" :value="__('Color Label: Cantidad')" class="text-white/90 mb-2" />
                            <div class="flex items-center gap-2 sm:gap-4">
                                <input 
                                    type="color" 
                                    id="quantity_label_color_picker" 
                                    value="{{ old('quantity_label_color', $cotizadorSection->quantity_label_color ?? '#ffffff') }}"
                                    class="w-16 h-10 sm:w-20 sm:h-12 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                    style="background: transparent;"
                                    onchange="document.getElementById('quantity_label_color').value = this.value"
                                >
                                <x-text-input 
                                    type="text" 
                                    id="quantity_label_color" 
                                    name="quantity_label_color"
                                    class="auth-form-input flex-1 min-w-0" 
                                    value="{{ old('quantity_label_color', $cotizadorSection->quantity_label_color ?? '#ffffff') }}"
                                    placeholder="#ffffff"
                                    pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                    onchange="document.getElementById('quantity_label_color_picker').value = this.value"
                                />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('quantity_label_color')" />
                        </div>

                        {{-- Color del Label "Peso Unitario" --}}
                        <div>
                            <x-input-label for="weight_label_color" :value="__('Color Label: Peso Unitario')" class="text-white/90 mb-2" />
                            <div class="flex items-center gap-2 sm:gap-4">
                                <input 
                                    type="color" 
                                    id="weight_label_color_picker" 
                                    value="{{ old('weight_label_color', $cotizadorSection->weight_label_color ?? '#ffffff') }}"
                                    class="w-16 h-10 sm:w-20 sm:h-12 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                    style="background: transparent;"
                                    onchange="document.getElementById('weight_label_color').value = this.value"
                                >
                                <x-text-input 
                                    type="text" 
                                    id="weight_label_color" 
                                    name="weight_label_color"
                                    class="auth-form-input flex-1 min-w-0" 
                                    value="{{ old('weight_label_color', $cotizadorSection->weight_label_color ?? '#ffffff') }}"
                                    placeholder="#ffffff"
                                    pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                    onchange="document.getElementById('weight_label_color_picker').value = this.value"
                                />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('weight_label_color')" />
                        </div>

                        {{-- Color del Label "Valor Unitario" --}}
                        <div>
                            <x-input-label for="unit_value_label_color" :value="__('Color Label: Valor Unitario')" class="text-white/90 mb-2" />
                            <div class="flex items-center gap-2 sm:gap-4">
                                <input 
                                    type="color" 
                                    id="unit_value_label_color_picker" 
                                    value="{{ old('unit_value_label_color', $cotizadorSection->unit_value_label_color ?? '#ffffff') }}"
                                    class="w-16 h-10 sm:w-20 sm:h-12 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                    style="background: transparent;"
                                    onchange="document.getElementById('unit_value_label_color').value = this.value"
                                >
                                <x-text-input 
                                    type="text" 
                                    id="unit_value_label_color" 
                                    name="unit_value_label_color"
                                    class="auth-form-input flex-1 min-w-0" 
                                    value="{{ old('unit_value_label_color', $cotizadorSection->unit_value_label_color ?? '#ffffff') }}"
                                    placeholder="#ffffff"
                                    pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                    onchange="document.getElementById('unit_value_label_color_picker').value = this.value"
                                />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('unit_value_label_color')" />
                        </div>

                        {{-- Color del Label "Seleccionar Método de Envío" --}}
                        <div>
                            <x-input-label for="shipping_method_label_color" :value="__('Color Label: Método de Envío')" class="text-white/90 mb-2" />
                            <div class="flex items-center gap-2 sm:gap-4">
                                <input 
                                    type="color" 
                                    id="shipping_method_label_color_picker" 
                                    value="{{ old('shipping_method_label_color', $cotizadorSection->shipping_method_label_color ?? '#ffffff') }}"
                                    class="w-16 h-10 sm:w-20 sm:h-12 rounded-lg border-2 border-white/30 cursor-pointer flex-shrink-0"
                                    style="background: transparent;"
                                    onchange="document.getElementById('shipping_method_label_color').value = this.value"
                                >
                                <x-text-input 
                                    type="text" 
                                    id="shipping_method_label_color" 
                                    name="shipping_method_label_color"
                                    class="auth-form-input flex-1 min-w-0" 
                                    value="{{ old('shipping_method_label_color', $cotizadorSection->shipping_method_label_color ?? '#ffffff') }}"
                                    placeholder="#ffffff"
                                    pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                    onchange="document.getElementById('shipping_method_label_color_picker').value = this.value"
                                />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('shipping_method_label_color')" />
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
                        {{ old('is_active', $cotizadorSection->is_active) ? 'checked' : '' }}
                    >
                    <label for="is_active" class="text-white/90">
                        Cotizador activo (se mostrará en la página del cotizador)
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
                    <a href="{{ route('dashboard') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center min-w-0" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base truncate">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>

    <script>
        // Sincronizar todos los color pickers con sus inputs de texto
        document.querySelectorAll('input[type="color"]').forEach(picker => {
            const textInput = document.getElementById(picker.id.replace('_picker', ''));
            if (textInput) {
                picker.addEventListener('input', function(e) {
                    textInput.value = e.target.value;
                });
            }
        });

        // Inicializar los color pickers con los valores actuales
        document.addEventListener('DOMContentLoaded', function() {
            const colorFields = [
                'title_color',
                'section_title_color',
                'product_label_color',
                'quantity_label_color',
                'weight_label_color',
                'unit_value_label_color',
                'shipping_method_label_color'
            ];
            
            colorFields.forEach(field => {
                const textInput = document.getElementById(field);
                const picker = document.getElementById(field + '_picker');
                if (textInput && picker) {
                    picker.value = textInput.value;
                }
            });
        });
    </script>
</x-app-layout>

