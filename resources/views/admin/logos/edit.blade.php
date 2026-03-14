<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Editar Logo') }}
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
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                            Editar Logo
                        </h1>
                        <p class="text-xs sm:text-sm md:text-base text-white/80 truncate">
                            Modifica la información del logo: {{ $logo->name ?? 'Sin nombre' }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <a href="{{ route('admin.logos.show', $logo) }}" class="glass-button glass-button-sm w-full sm:w-auto flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span class="text-xs sm:text-sm md:text-base">Ver Detalles</span>
                        </a>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.logos.update', $logo) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Vista previa del logo actual --}}
                @if($logo->image_path)
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                        <p class="text-sm text-white/80 mb-3">Logo actual:</p>
                        <img src="{{ asset($logo->image_path) }}" alt="{{ $logo->name ?? 'Logo' }}" class="max-w-xs h-auto rounded-lg border border-white/20">
                    </div>
                @endif

                {{-- Nombre --}}
                <div>
                    <x-input-label for="name" :value="__('Nombre del Logo')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="name" 
                        name="name" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('name', $logo->name)" 
                        autocomplete="name" 
                        placeholder="Ej: Logo Principal, Logo Alternativo, etc."
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                {{-- Nueva Imagen del Logo --}}
                <div>
                    <x-input-label for="logo_image" :value="__('Nueva Imagen del Logo (Opcional)')" class="text-white/90 mb-2" />
                    <input 
                        id="logo_image" 
                        name="logo_image" 
                        type="file" 
                        accept="image/png,image/jpeg,image/jpg,image/svg+xml"
                        class="auth-form-input" 
                        onchange="previewImage(this)"
                    />
                    <p class="mt-1 text-xs text-white/60">Deja en blanco para mantener la imagen actual. Formatos: PNG, JPG, JPEG, SVG. Máx: 5MB</p>
                    <x-input-error class="mt-2" :messages="$errors->get('logo_image')" />
                    
                    {{-- Vista previa --}}
                    <div id="image-preview" class="mt-4 hidden">
                        <p class="text-sm text-white/80 mb-2">Vista previa de la nueva imagen:</p>
                        <img id="preview" src="" alt="Vista previa" class="max-w-xs h-auto rounded-lg border border-white/20">
                    </div>
                </div>

                {{-- Activar --}}
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1"
                            class="w-5 h-5 rounded border-white/30 bg-white/10 text-indigo-600 focus:ring-indigo-500 focus:ring-2"
                            {{ old('is_active', $logo->is_active) ? 'checked' : '' }}
                        >
                        <span class="text-white/90 text-sm sm:text-base">
                            Activar este logo (desactivará otros logos)
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
                        :value="old('order', $logo->order)" 
                        min="0"
                        placeholder="0"
                    />
                    <p class="mt-1 text-xs text-white/60">Orden de visualización (menor número = primero)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('order')" />
                </div>

                {{-- Información adicional --}}
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-sm font-semibold text-white/90 mb-3">Información del Logo</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-white/70">ID:</p>
                            <p class="text-white font-medium">{{ $logo->id }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Creado:</p>
                            <p class="text-white font-medium">{{ $logo->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Última actualización:</p>
                            <p class="text-white font-medium">{{ $logo->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Estado:</p>
                            <p class="text-white font-medium">
                                @if($logo->is_active)
                                    <span class="text-green-300">Activo</span>
                                @else
                                    <span class="text-gray-300">Inactivo</span>
                                @endif
                            </p>
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

