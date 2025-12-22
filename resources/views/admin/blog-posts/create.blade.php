<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Crear Nuevo Artículo') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('admin.blog-posts.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Artículos
                </a>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                    Crear Nuevo Artículo
                </h1>
                <p class="text-xs sm:text-sm md:text-base text-white/80">
                    Completa el formulario para crear un nuevo artículo en la sección "Temas de Interés"
                </p>
            </div>

            <form method="POST" action="{{ route('admin.blog-posts.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Título --}}
                <div>
                    <x-input-label for="title" :value="__('Título del Artículo')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="title" 
                        name="title" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('title')" 
                        required 
                        autofocus 
                        placeholder="Ej: Cómo importar productos desde USA"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                {{-- Descripción Breve (Excerpt) --}}
                <div>
                    <x-input-label for="excerpt" :value="__('Descripción Breve')" class="text-white/90 mb-2" />
                    <textarea 
                        id="excerpt" 
                        name="excerpt" 
                        class="auth-form-input" 
                        rows="3"
                        placeholder="Descripción breve del artículo que será de interés para los usuarios..."
                        maxlength="500"
                    >{{ old('excerpt') }}</textarea>
                    <p class="mt-1 text-xs text-white/60">Máximo 500 caracteres. Esta descripción aparecerá en la tarjeta del artículo.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('excerpt')" />
                </div>

                {{-- Contenido Completo --}}
                <div>
                    <x-input-label for="content" :value="__('Contenido Completo')" class="text-white/90 mb-2" />
                    <textarea 
                        id="content" 
                        name="content" 
                        class="auth-form-input" 
                        rows="6"
                        placeholder="Contenido completo del artículo (opcional)"
                    >{{ old('content') }}</textarea>
                    <p class="mt-1 text-xs text-white/60">Contenido completo del artículo (opcional, se puede usar para almacenar el texto completo)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('content')" />
                </div>

                {{-- Imagen Destacada --}}
                <div>
                    <x-input-label :value="__('Imagen Destacada')" class="text-white/90 mb-2" />
                    
                    {{-- Selector de método: Subir archivo o URL --}}
                    <div class="mb-4 flex gap-4">
                        <label class="auth-form-checkbox cursor-pointer">
                            <input 
                                type="radio" 
                                name="image_source" 
                                value="url" 
                                id="image_source_url"
                                {{ old('image_source', 'url') === 'url' ? 'checked' : '' }}
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
                                {{ old('image_source', 'url') === 'file' ? 'checked' : '' }}
                                onchange="toggleImageSource()"
                            >
                            <span class="text-white/90">Subir desde PC</span>
                        </label>
                    </div>

                    {{-- Campo URL --}}
                    <div id="image_url_field" style="display: {{ old('image_source', 'url') === 'url' ? 'block' : 'none' }};">
                        <x-text-input 
                            id="featured_image_url" 
                            name="featured_image_url" 
                            type="url" 
                            class="auth-form-input" 
                            :value="old('featured_image_url')" 
                            placeholder="https://ejemplo.com/imagen.jpg"
                        />
                        <p class="mt-1 text-xs text-white/60">Ingresa la URL completa de la imagen</p>
                    </div>

                    {{-- Campo File Upload --}}
                    <div id="image_file_field" style="display: {{ old('image_source', 'url') === 'file' ? 'block' : 'none' }};">
                        <input 
                            type="file" 
                            id="featured_image_file" 
                            name="featured_image_file" 
                            accept="image/*"
                            class="auth-form-input"
                            onchange="previewImage(this)"
                        >
                        <p class="mt-1 text-xs text-white/60">Formatos permitidos: JPG, PNG, GIF, WEBP (máx. 5MB)</p>
                    </div>

                    {{-- Vista previa de nueva imagen (cuando se selecciona un archivo) --}}
                    <div id="new_image_preview" class="mt-4" style="display: none;">
                        <p class="text-sm text-white/70 mb-2">Vista previa de la nueva imagen:</p>
                        <img id="preview_img" src="" alt="Preview" class="w-full max-w-md h-48 object-cover rounded-lg border border-white/20">
                    </div>

                    {{-- Vista previa de URL --}}
                    <div id="url_image_preview" class="mt-4 p-4 rounded-xl bg-white/5 border border-white/10" style="display: none;">
                        <p class="text-sm text-white/70 mb-2">Vista previa de la imagen:</p>
                        <div class="flex items-center justify-center p-4 bg-white/10 rounded-lg">
                            <img id="preview_url_image_content" src="" alt="Preview" class="max-w-full max-h-48 object-contain rounded">
                        </div>
                    </div>

                    <x-input-error class="mt-2" :messages="$errors->get('featured_image_url')" />
                    <x-input-error class="mt-2" :messages="$errors->get('featured_image_file')" />
                </div>

                {{-- Enlace del Artículo --}}
                <div>
                    <x-input-label for="link" :value="__('Enlace del Artículo')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="link" 
                        name="link" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('link')" 
                        placeholder="# o https://ejemplo.com/articulo"
                    />
                    <p class="mt-1 text-xs text-white/60">URL del artículo completo (opcional, se usará como enlace al hacer clic en "Leer más")</p>
                    <x-input-error class="mt-2" :messages="$errors->get('link')" />
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
                    <p class="mt-1 text-xs text-white/60">Los artículos se mostrarán ordenados por este número (menor = primero)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('order')" />
                </div>

                {{-- Fecha de Publicación --}}
                <div>
                    <x-input-label for="published_at" :value="__('Fecha de Publicación')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="published_at" 
                        name="published_at" 
                        type="datetime-local" 
                        class="auth-form-input" 
                        :value="old('published_at')" 
                    />
                    <p class="mt-1 text-xs text-white/60">Fecha y hora de publicación (opcional, dejar vacío para publicar inmediatamente)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('published_at')" />
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
                        Artículo activo (se mostrará en la sección "Temas de Interés")
                    </label>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('is_active')" />

                {{-- Botones de Acción --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3 pt-4 border-t border-white/10">
                    <button type="submit" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center min-w-0">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs sm:text-sm md:text-base truncate">Crear Artículo</span>
                    </button>
                    <a href="{{ route('admin.blog-posts.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center min-w-0" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base truncate">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>

    <script>
        function toggleImageSource() {
            const urlRadio = document.getElementById('image_source_url');
            const fileRadio = document.getElementById('image_source_file');
            const urlField = document.getElementById('image_url_field');
            const fileField = document.getElementById('image_file_field');
            const urlInput = document.getElementById('featured_image_url');
            const fileInput = document.getElementById('featured_image_file');

            if (urlRadio.checked) {
                urlField.style.display = 'block';
                fileField.style.display = 'none';
                fileInput.value = ''; // Limpiar el input de archivo
                document.getElementById('new_image_preview').style.display = 'none';
                if (urlInput) urlInput.removeAttribute('disabled');
            } else {
                urlField.style.display = 'none';
                fileField.style.display = 'block';
                if (urlInput) urlInput.value = ''; // Limpiar el input de URL
                if (urlInput) urlInput.setAttribute('disabled', 'disabled');
                document.getElementById('url_image_preview').style.display = 'none';
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

        // Vista previa de la imagen desde URL
        const urlInput = document.getElementById('featured_image_url');
        if (urlInput) {
            urlInput.addEventListener('input', function(e) {
                const preview = document.getElementById('url_image_preview');
                const previewContent = document.getElementById('preview_url_image_content');
                const imageUrl = e.target.value.trim();
                
                if (imageUrl) {
                    previewContent.src = imageUrl;
                    preview.style.display = 'block';
                } else {
                    preview.style.display = 'none';
                }
            });
        }
    </script>
</x-app-layout>





