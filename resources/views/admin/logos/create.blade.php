<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Crear Nuevo Logo') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('admin.logos.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Logos
                </a>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                    Crear Nuevo Logo
                </h1>
                <p class="text-xs sm:text-sm md:text-base text-white/80">
                    Sube una imagen para crear un nuevo logotipo en el sistema.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.logos.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Nombre --}}
                <div>
                    <x-input-label for="name" :value="__('Nombre del Logo (Opcional)')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="name" 
                        name="name" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('name')" 
                        autocomplete="name" 
                        placeholder="Ej: Logo Principal, Logo Alternativo, etc."
                    />
                    <p class="mt-1 text-xs text-white/60">Si no se especifica, se generará un nombre automático</p>
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                {{-- Imagen del Logo --}}
                <div>
                    <x-input-label for="logo_image" :value="__('Imagen del Logo')" class="text-white/90 mb-2" />
                    <input 
                        id="logo_image" 
                        name="logo_image" 
                        type="file" 
                        accept="image/png,image/jpeg,image/jpg,image/svg+xml"
                        class="auth-form-input" 
                        required
                        onchange="previewImage(this)"
                    />
                    <p class="mt-1 text-xs text-white/60">Formatos permitidos: PNG, JPG, JPEG, SVG. Tamaño máximo: 5MB</p>
                    <x-input-error class="mt-2" :messages="$errors->get('logo_image')" />
                    
                    {{-- Vista previa --}}
                    <div id="image-preview" class="mt-4 hidden">
                        <p class="text-sm text-white/80 mb-2">Vista previa:</p>
                        <img id="preview" src="" alt="Vista previa" class="max-w-xs h-auto rounded-lg border border-white/20">
                    </div>
                </div>

                {{-- Activar automáticamente --}}
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1"
                            class="w-5 h-5 rounded border-white/30 bg-white/10 text-indigo-600 focus:ring-indigo-500 focus:ring-2"
                            {{ old('is_active') ? 'checked' : '' }}
                        >
                        <span class="text-white/90 text-sm sm:text-base">
                            Activar este logo automáticamente (desactivará otros logos)
                        </span>
                    </label>
                    <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
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
                    <p class="mt-1 text-xs text-white/60">Orden de visualización (menor número = primero)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('order')" />
                </div>

                {{-- Botones de Acción --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 pt-4 border-t border-white/10">
                    <button type="submit" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs sm:text-sm md:text-base">Crear Logo</span>
                    </button>
                    <a href="{{ route('admin.logos.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const previewDiv = document.getElementById('image-preview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewDiv.classList.remove('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                previewDiv.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>

