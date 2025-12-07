<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Editar Paso del Proceso') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('admin.process-steps.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Pasos del Proceso
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                            Editar Paso del Proceso
                        </h1>
                        <p class="text-xs sm:text-sm md:text-base text-white/80 truncate">
                            Modifica la información del paso: {{ $processStep->title }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <a href="{{ route('admin.process-steps.show', $processStep) }}" class="glass-button glass-button-sm w-full sm:w-auto flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span class="text-xs sm:text-sm md:text-base">Ver Detalles</span>
                        </a>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.process-steps.update', $processStep) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Número del Paso --}}
                <div>
                    <x-input-label for="step_number" :value="__('Número del Paso')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="step_number" 
                        name="step_number" 
                        type="number" 
                        class="auth-form-input" 
                        :value="old('step_number', $processStep->step_number)" 
                        required 
                        min="1"
                        autofocus 
                        placeholder="Ej: 1, 2, 3, 4..."
                    />
                    <p class="mt-1 text-xs text-white/60">Número que se mostrará en el círculo del paso</p>
                    <x-input-error class="mt-2" :messages="$errors->get('step_number')" />
                </div>

                {{-- Título --}}
                <div>
                    <x-input-label for="title" :value="__('Título')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="title" 
                        name="title" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('title', $processStep->title)" 
                        required 
                        placeholder="Ej: Compras"
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
                        placeholder="Ej: Compra en tu tienda online favorita y envía al casillero"
                    >{{ old('description', $processStep->description) }}</textarea>
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
                        placeholder='<svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">...</svg>'
                    >{{ old('icon_svg', $processStep->icon_svg) }}</textarea>
                    <p class="mt-1 text-xs text-white/60">Pega aquí el código SVG completo del icono. Debe incluir las clases: <code class="bg-white/10 px-1 rounded">class="w-12 h-12 mx-auto text-white"</code></p>
                    <x-input-error class="mt-2" :messages="$errors->get('icon_svg')" />
                    
                    {{-- Vista previa del icono --}}
                    <div id="icon_preview" class="mt-4 p-4 rounded-xl bg-white/5 border border-white/10">
                        <p class="text-sm text-white/70 mb-2">Vista previa del icono:</p>
                        <div class="flex items-center justify-center p-4 bg-white/10 rounded-lg">
                            <div id="preview_icon_content">
                                {!! $processStep->icon_svg !!}
                            </div>
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
                        :value="old('order', $processStep->order)" 
                        min="0"
                        placeholder="0"
                    />
                    <p class="mt-1 text-xs text-white/60">Los pasos se mostrarán ordenados por este número (menor = primero)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('order')" />
                </div>

                {{-- Estado Activo --}}
                <div class="auth-form-checkbox">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1"
                        {{ old('is_active', $processStep->is_active) ? 'checked' : '' }}
                    >
                    <label for="is_active" class="text-white/90">
                        Paso activo (se mostrará en la sección "¿Cómo Funciona?")
                    </label>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('is_active')" />

                {{-- Información adicional --}}
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-sm font-semibold text-white/90 mb-3">Información del Paso</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-white/70">ID:</p>
                            <p class="text-white font-medium">{{ $processStep->id }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Creado:</p>
                            <p class="text-white font-medium">{{ $processStep->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Última actualización:</p>
                            <p class="text-white font-medium">{{ $processStep->updated_at->format('d/m/Y H:i') }}</p>
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
                        <span class="text-xs sm:text-sm md:text-base">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>

    <script>
        // Vista previa del icono SVG
        document.getElementById('icon_svg').addEventListener('input', function(e) {
            const previewContent = document.getElementById('preview_icon_content');
            const svgCode = e.target.value.trim();
            
            if (svgCode) {
                previewContent.innerHTML = svgCode;
            }
        });
    </script>
</x-app-layout>







