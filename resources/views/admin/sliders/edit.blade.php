<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Editar Slide') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('admin.sliders.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Sliders
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                            Editar Slide
                        </h1>
                        <p class="text-xs sm:text-sm md:text-base text-white/80 truncate">
                            Modifica la información del slide: {{ $slider->title }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <a href="{{ route('admin.sliders.show', $slider) }}" class="glass-button glass-button-sm w-full sm:w-auto flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span class="text-xs sm:text-sm md:text-base">Ver Detalles</span>
                        </a>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.sliders.update', $slider) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Título --}}
                <div>
                    <x-input-label for="title" :value="__('Título')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="title" 
                        name="title" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('title', $slider->title)" 
                        required 
                        autofocus 
                        placeholder="Ej: Dirección de Casillero Postal GRATIS"
                    />
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
                        :value="old('subtitle', $slider->subtitle)" 
                        placeholder="Ej: Te ofrecemos una dirección de casillero postal en USA totalmente GRATIS"
                    />
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
                            value="{{ old('title_color', $slider->title_color ?? '#ffffff') }}"
                            class="w-20 h-12 rounded-lg border-2 border-white/30 cursor-pointer"
                            style="background: transparent;"
                        >
                        <x-text-input 
                            type="text" 
                            id="title_color_hex" 
                            class="auth-form-input flex-1" 
                            value="{{ old('title_color', $slider->title_color ?? '#ffffff') }}"
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
                            value="{{ old('subtitle_color', $slider->subtitle_color ?? '#ffffff') }}"
                            class="w-20 h-12 rounded-lg border-2 border-white/30 cursor-pointer"
                            style="background: transparent;"
                        >
                        <x-text-input 
                            type="text" 
                            id="subtitle_color_hex" 
                            class="auth-form-input flex-1" 
                            value="{{ old('subtitle_color', $slider->subtitle_color ?? '#ffffff') }}"
                            placeholder="#ffffff"
                            pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                            onchange="document.getElementById('subtitle_color').value = this.value"
                        />
                    </div>
                    <p class="mt-1 text-xs text-white/60">Selecciona o ingresa un color hexadecimal para el subtítulo</p>
                    <x-input-error class="mt-2" :messages="$errors->get('subtitle_color')" />
                </div>

                <script>
                    // Sincronizar color picker con input de texto
                    document.getElementById('title_color').addEventListener('input', function(e) {
                        document.getElementById('title_color_hex').value = e.target.value;
                    });
                    document.getElementById('subtitle_color').addEventListener('input', function(e) {
                        document.getElementById('subtitle_color_hex').value = e.target.value;
                    });
                </script>

                {{-- Descripción --}}
                <div>
                    <x-input-label for="description" :value="__('Descripción')" class="text-white/90 mb-2" />
                    <textarea 
                        id="description" 
                        name="description" 
                        class="auth-form-input" 
                        rows="4"
                        placeholder="Descripción detallada del slide"
                    >{{ old('description', $slider->description) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                {{-- Imagen --}}
                <div>
                    <x-input-label :value="__('Imagen del Slide')" class="text-white/90 mb-2" />
                    
                    {{-- Selector de método: Subir archivo o URL --}}
                    <div class="mb-4 flex gap-4">
                        <label class="auth-form-checkbox cursor-pointer">
                            <input 
                                type="radio" 
                                name="image_source" 
                                value="url" 
                                id="image_source_url"
                                {{ old('image_source', str_starts_with($slider->image ?? '', 'http') ? 'url' : 'file') === 'url' ? 'checked' : '' }}
                                onchange="toggleImageSource()"
                            >
                            <span class="text-white/90">Usar URL</span>
                        </label>
                        <label class="auth-form-checkbox cursor-pointer">
                            <input 
                                type="radio" 
                                name="image_source" 
                                value="file" 
                                id="image_source_file"
                                {{ old('image_source', str_starts_with($slider->image ?? '', 'http') ? 'url' : 'file') === 'file' ? 'checked' : '' }}
                                onchange="toggleImageSource()"
                            >
                            <span class="text-white/90">Subir desde PC</span>
                        </label>
                    </div>

                    {{-- Campo URL --}}
                    <div id="image_url_field" style="display: {{ old('image_source', str_starts_with($slider->image ?? '', 'http') ? 'url' : 'file') === 'url' ? 'block' : 'none' }};">
                        <x-text-input 
                            id="image_url" 
                            name="image_url" 
                            type="url" 
                            class="auth-form-input" 
                            :value="old('image_url', str_starts_with($slider->image ?? '', 'http') ? $slider->image : '')" 
                            placeholder="https://images.unsplash.com/photo-..."
                        />
                        <p class="mt-1 text-xs text-white/60">Ingresa la URL completa de la imagen</p>
                    </div>

                    {{-- Campo File Upload --}}
                    <div id="image_file_field" style="display: {{ old('image_source', str_starts_with($slider->image ?? '', 'http') ? 'url' : 'file') === 'file' ? 'block' : 'none' }};">
                        <input 
                            type="file" 
                            id="image_file" 
                            name="image_file" 
                            accept="image/*"
                            class="auth-form-input"
                            onchange="previewImage(this)"
                        >
                        <p class="mt-1 text-xs text-white/60">Formatos permitidos: JPG, PNG, GIF, WEBP (máx. 5MB)</p>
                    </div>

                    {{-- Vista previa de la imagen actual --}}
                    @if($slider->image)
                        <div class="mt-4">
                            <p class="text-sm text-white/70 mb-2">Imagen actual:</p>
                            <img 
                                src="{{ str_starts_with($slider->image, 'http') ? $slider->image : asset('storage/' . $slider->image) }}" 
                                alt="{{ $slider->title }}" 
                                id="current_image_preview"
                                class="w-full max-w-md h-48 object-cover rounded-lg border border-white/20"
                                onerror="this.src='{{ $slider->image }}'"
                            >
                        </div>
                    @endif

                    {{-- Vista previa de nueva imagen (cuando se selecciona un archivo) --}}
                    <div id="new_image_preview" class="mt-4" style="display: none;">
                        <p class="text-sm text-white/70 mb-2">Vista previa de la nueva imagen:</p>
                        <img id="preview_img" src="" alt="Preview" class="w-full max-w-md h-48 object-cover rounded-lg border border-white/20">
                    </div>

                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    <x-input-error class="mt-2" :messages="$errors->get('image_url')" />
                    <x-input-error class="mt-2" :messages="$errors->get('image_file')" />
                </div>

                <script>
                    function toggleImageSource() {
                        const urlRadio = document.getElementById('image_source_url');
                        const fileRadio = document.getElementById('image_source_file');
                        const urlField = document.getElementById('image_url_field');
                        const fileField = document.getElementById('image_file_field');
                        const urlInput = document.getElementById('image_url');
                        const fileInput = document.getElementById('image_file');

                        if (urlRadio.checked) {
                            urlField.style.display = 'block';
                            fileField.style.display = 'none';
                            fileInput.value = ''; // Limpiar el input de archivo
                            document.getElementById('new_image_preview').style.display = 'none';
                            urlInput.removeAttribute('disabled');
                        } else {
                            urlField.style.display = 'none';
                            fileField.style.display = 'block';
                            urlInput.value = ''; // Limpiar el input de URL
                            urlInput.setAttribute('disabled', 'disabled');
                        }
                    }

                    function previewImage(input) {
                        const preview = document.getElementById('new_image_preview');
                        const previewImg = document.getElementById('preview_img');
                        
                        if (input.files && input.files[0]) {
                            const reader = new FileReader();
                            
                            reader.onload = function(e) {
                                previewImg.src = e.target.result;
                                preview.style.display = 'block';
                            }
                            
                            reader.readAsDataURL(input.files[0]);
                        } else {
                            preview.style.display = 'none';
                        }
                    }

                    // Inicializar al cargar la página
                    document.addEventListener('DOMContentLoaded', function() {
                        toggleImageSource();
                    });
                </script>

                {{-- CTA Texto --}}
                <div>
                    <x-input-label for="cta" :value="__('Texto del Botón CTA')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="cta" 
                        name="cta" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('cta', $slider->cta)" 
                        placeholder="Ej: Registrarse Gratis"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('cta')" />
                </div>

                {{-- CTA Link --}}
                <div>
                    <x-input-label for="cta_link" :value="__('URL del Botón CTA')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="cta_link" 
                        name="cta_link" 
                        type="url" 
                        class="auth-form-input" 
                        :value="old('cta_link', $slider->cta_link)" 
                        placeholder="https://ejemplo.com o {{ route('register') }}"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('cta_link')" />
                </div>

                {{-- Orden --}}
                <div>
                    <x-input-label for="order" :value="__('Orden')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="order" 
                        name="order" 
                        type="number" 
                        class="auth-form-input" 
                        :value="old('order', $slider->order)" 
                        min="0"
                        placeholder="0"
                    />
                    <p class="mt-1 text-xs text-white/60">Los slides se mostrarán ordenados por este número (menor = primero)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('order')" />
                </div>

                {{-- Estado Activo --}}
                <div class="auth-form-checkbox">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1"
                        {{ old('is_active', $slider->is_active) ? 'checked' : '' }}
                    >
                    <label for="is_active" class="text-white/90">
                        Slide activo (se mostrará en el hero slider)
                    </label>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('is_active')" />

                {{-- Información adicional --}}
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-sm font-semibold text-white/90 mb-3">Información del Slide</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-white/70">ID:</p>
                            <p class="text-white font-medium">{{ $slider->id }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Creado:</p>
                            <p class="text-white font-medium">{{ $slider->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Última actualización:</p>
                            <p class="text-white font-medium">{{ $slider->updated_at->format('d/m/Y H:i') }}</p>
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
                    <a href="{{ route('admin.sliders.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>

