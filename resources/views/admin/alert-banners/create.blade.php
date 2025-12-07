<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Crear Nuevo Banner de Alerta') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('admin.alert-banners.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Banners de Alerta
                </a>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                    Crear Nuevo Banner de Alerta
                </h1>
                <p class="text-xs sm:text-sm md:text-base text-white/80">
                    Completa el formulario para crear un nuevo banner de alerta
                </p>
            </div>

            <form method="POST" action="{{ route('admin.alert-banners.store') }}" class="space-y-6">
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
                        placeholder="Ej: ¡NO OLVIDES ALERTAR TU COMPRA!"
                        autofocus
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
                        placeholder="Ej: Alertar la compra evitará retrasos en la importación y permitirá identificar el paquete con facilidad."
                    >{{ old('description') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
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
                        placeholder='<svg class="w-16 h-16 mx-auto text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">...</svg>'
                    >{{ old('icon_svg') }}</textarea>
                    <p class="mt-1 text-xs text-white/60">Pega aquí el código SVG completo del icono. Debe incluir las clases apropiadas.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('icon_svg')" />
                    
                    {{-- Vista previa del icono --}}
                    <div id="icon_preview" class="mt-4 p-4 rounded-xl bg-white/5 border border-white/10" style="display: none;">
                        <p class="text-sm text-white/70 mb-2">Vista previa del icono:</p>
                        <div class="flex items-center justify-center p-4 bg-white/10 rounded-lg">
                            <div id="preview_icon_content"></div>
                        </div>
                    </div>
                </div>

                {{-- Botón para Usuarios Autenticados --}}
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-base font-semibold text-white mb-4">Botón para Usuarios Autenticados</h3>
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="button_text_auth" :value="__('Texto del Botón')" class="text-white/90 mb-2" />
                            <x-text-input 
                                id="button_text_auth" 
                                name="button_text_auth" 
                                type="text" 
                                class="auth-form-input" 
                                :value="old('button_text_auth')" 
                                placeholder="Ej: Alertar Compra"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('button_text_auth')" />
                        </div>
                        <div>
                            <x-input-label for="button_link_auth" :value="__('Enlace del Botón')" class="text-white/90 mb-2" />
                            <x-text-input 
                                id="button_link_auth" 
                                name="button_link_auth" 
                                type="text" 
                                class="auth-form-input" 
                                :value="old('button_link_auth')" 
                                placeholder="Ej: /dashboard o route('dashboard')"
                            />
                            <p class="mt-1 text-xs text-white/60">Puedes usar rutas de Laravel (ej: route('dashboard')) o URLs directas (ej: /dashboard)</p>
                            <x-input-error class="mt-2" :messages="$errors->get('button_link_auth')" />
                        </div>
                    </div>
                </div>

                {{-- Botón para Usuarios No Autenticados --}}
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-base font-semibold text-white mb-4">Botón para Usuarios No Autenticados</h3>
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="button_text_guest" :value="__('Texto del Botón')" class="text-white/90 mb-2" />
                            <x-text-input 
                                id="button_text_guest" 
                                name="button_text_guest" 
                                type="text" 
                                class="auth-form-input" 
                                :value="old('button_text_guest')" 
                                placeholder="Ej: Registrarse para Alertar"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('button_text_guest')" />
                        </div>
                        <div>
                            <x-input-label for="button_link_guest" :value="__('Enlace del Botón')" class="text-white/90 mb-2" />
                            <x-text-input 
                                id="button_link_guest" 
                                name="button_link_guest" 
                                type="text" 
                                class="auth-form-input" 
                                :value="old('button_link_guest')" 
                                placeholder="Ej: /register o route('register')"
                            />
                            <p class="mt-1 text-xs text-white/60">Puedes usar rutas de Laravel (ej: route('register')) o URLs directas (ej: /register)</p>
                            <x-input-error class="mt-2" :messages="$errors->get('button_link_guest')" />
                        </div>
                    </div>
                </div>

                {{-- Colores del Banner --}}
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-base font-semibold text-white mb-4">Colores del Banner</h3>
                    <div class="space-y-4">
                        {{-- Color de Fondo --}}
                        <div>
                            <x-input-label for="background_color" :value="__('Color de Fondo')" class="text-white/90 mb-2" />
                            <div class="flex items-center gap-4">
                                <input 
                                    type="color" 
                                    id="background_color" 
                                    name="background_color" 
                                    value="{{ old('background_color', '#000000') === 'transparent' ? '#000000' : (old('background_color', '#000000')) }}"
                                    class="w-20 h-12 rounded-lg border-2 border-white/30 cursor-pointer"
                                    style="background: transparent;"
                                >
                                <x-text-input 
                                    type="text" 
                                    id="background_color_hex" 
                                    class="auth-form-input flex-1" 
                                    value="{{ old('background_color', 'transparent') }}"
                                    placeholder="transparent o #ffffff"
                                    onchange="document.getElementById('background_color').value = this.value === 'transparent' ? '#000000' : this.value"
                                />
                                <label class="flex items-center gap-2 text-white/80 text-sm">
                                    <input 
                                        type="checkbox" 
                                        id="background_transparent"
                                        onchange="if(this.checked) { document.getElementById('background_color_hex').value = 'transparent'; }"
                                        {{ (old('background_color', 'transparent') === 'transparent') ? 'checked' : '' }}
                                    >
                                    <span>Transparente</span>
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-white/60">Selecciona o ingresa un color hexadecimal para el fondo, o marca "Transparente"</p>
                            <x-input-error class="mt-2" :messages="$errors->get('background_color')" />
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

                        {{-- Color del Contenedor --}}
                        <div>
                            <x-input-label for="container_color" :value="__('Color del Contenedor')" class="text-white/90 mb-2" />
                            <div class="flex items-center gap-4">
                                <input 
                                    type="color" 
                                    id="container_color" 
                                    name="container_color" 
                                    value="{{ old('container_color', 'rgba(255, 255, 255, 0.15)') === 'rgba(255, 255, 255, 0.15)' ? '#ffffff' : (preg_match('/^#[0-9A-Fa-f]{6}$/', old('container_color', 'rgba(255, 255, 255, 0.15)')) ? old('container_color', '#ffffff') : '#ffffff') }}"
                                    class="w-20 h-12 rounded-lg border-2 border-white/30 cursor-pointer"
                                    style="background: transparent;"
                                >
                                <x-text-input 
                                    type="text" 
                                    id="container_color_hex" 
                                    class="auth-form-input flex-1" 
                                    value="{{ old('container_color', 'rgba(255, 255, 255, 0.15)') }}"
                                    placeholder="rgba(255, 255, 255, 0.15) o #ffffff"
                                />
                            </div>
                            <p class="mt-1 text-xs text-white/60">Color del contenedor/card del banner. Puedes usar rgba (ej: rgba(255, 255, 255, 0.15)) o hexadecimal (ej: #ffffff)</p>
                            <x-input-error class="mt-2" :messages="$errors->get('container_color')" />
                        </div>
                    </div>
                </div>

                <script>
                    // Sincronizar color picker con input de texto
                    document.getElementById('title_color').addEventListener('input', function(e) {
                        document.getElementById('title_color_hex').value = e.target.value;
                    });
                    document.getElementById('description_color').addEventListener('input', function(e) {
                        document.getElementById('description_color_hex').value = e.target.value;
                    });
                    document.getElementById('background_color').addEventListener('input', function(e) {
                        if (document.getElementById('background_transparent').checked) {
                            document.getElementById('background_transparent').checked = false;
                        }
                        document.getElementById('background_color_hex').value = e.target.value;
                    });
                    document.getElementById('container_color').addEventListener('input', function(e) {
                        document.getElementById('container_color_hex').value = e.target.value;
                    });
                </script>

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
                        Banner activo (se mostrará en la página de inicio)
                    </label>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('is_active')" />

                {{-- Botones de Acción --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 pt-4 border-t border-white/10">
                    <button type="submit" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs sm:text-sm md:text-base">Crear Banner</span>
                    </button>
                    <a href="{{ route('admin.alert-banners.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center" style="background: rgba(255, 255, 255, 0.1);">
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

