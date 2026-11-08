@php
    use App\Support\ThemePalette;

    $palette = ThemePalette::values($theme);
    $groups = [
        'Marca' => ['primary_color' => 'Principal (navegación activa)', 'secondary_color' => 'Secundario (superficies)', 'accent_color' => 'Acento (foco)'],
        'Fondo' => ['background_gradient_start' => 'Inicio', 'background_gradient_mid' => 'Centro', 'background_gradient_end' => 'Final'],
        'Contenido' => ['text_color' => 'Texto principal', 'text_secondary_color' => 'Texto secundario', 'button_color' => 'Fondo del botón'],
    ];
@endphp

<x-ui.container>
    <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
        <div class="mb-4 sm:mb-6">
            <a href="{{ route('admin.themes.index') }}" class="mb-3 inline-flex items-center gap-2 text-sm text-white/80 transition-colors hover:text-white sm:mb-4 sm:text-base">
                <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver a temas
            </a>
            <h1 class="mb-2 text-xl font-bold text-white sm:text-2xl md:text-3xl">
                {{ $theme ? 'Editar borrador de tema' : 'Crear borrador de tema' }}
            </h1>
            <p class="text-sm text-white/80">Ajusta la paleta y revisa la vista previa antes de guardar.</p>
        </div>

        <form method="POST" action="{{ $action }}" data-theme-editor class="space-y-6">
            @csrf
            @if($theme)
                @method('PUT')
            @endif

            @if(session('success'))
                <p role="status" class="rounded-xl border border-green-500/30 bg-green-500/20 p-3 text-green-200">{{ session('success') }}</p>
            @endif

            <div>
                <x-input-label for="theme-name" value="Nombre del tema" class="auth-form-label" />
                <x-text-input id="theme-name" name="name" type="text" required maxlength="255"
                              class="auth-form-input" :value="old('name', $theme?->name)" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            @foreach($groups as $group => $fields)
                <fieldset class="grid min-w-0 gap-4 border-b border-white/10 pb-4 sm:grid-cols-2 lg:grid-cols-3">
                    <legend class="mb-3 text-lg font-semibold text-white">{{ $group }}</legend>
                    @foreach($fields as $field => $label)
                        @php
                            $translucent = in_array($field, ThemePalette::TRANSLUCENT_FIELDS, true);
                            $value = old($field, $palette[$field]);
                            $palette[$field] = ThemePalette::normalize($value, $field) ?? $palette[$field];
                        @endphp
                        <div data-theme-field="{{ $field }}" data-translucent="{{ $translucent ? 'true' : 'false' }}" data-default-color="{{ ThemePalette::DEFAULTS[$field] }}">
                            <x-input-label :for="$field" :value="$label" class="auth-form-label" />
                            <div class="flex items-center gap-2">
                                <input type="color" data-theme-picker class="h-11 w-11 shrink-0 cursor-pointer rounded-lg border border-white/30 bg-white/10 p-1"
                                       value="{{ str_starts_with($palette[$field], '#') ? $palette[$field] : '#ffffff' }}"
                                       aria-label="Selector de color de {{ $label }}">
                                <input type="text" id="{{ $field }}" name="{{ $field }}" data-theme-value maxlength="64"
                                       @required(!$translucent) spellcheck="false"
                                       class="auth-form-input min-w-0"
                                       value="{{ is_string($value) ? $value : '' }}">
                            </div>
                            @if($translucent)
                                <label class="mt-2 flex items-center gap-2 text-sm text-white/80">
                                    Opacidad
                                    <input type="range" data-theme-opacity min="0" max="100" step="1" class="min-w-0 flex-1">
                                    <output data-theme-opacity-value></output>
                                </label>
                            @endif
                            <x-input-error class="mt-2" :messages="$errors->get($field)" />
                        </div>
                    @endforeach
                </fieldset>
            @endforeach

            @include('admin.themes.preview', ['palette' => $palette])

            <div class="flex flex-col items-stretch gap-3 border-t border-white/10 pt-4 sm:flex-row sm:items-center sm:gap-4">
                <button type="submit" class="glass-button glass-button-sm w-full sm:w-auto">Guardar borrador</button>
                <a href="{{ route('admin.themes.index') }}" class="glass-button glass-button-sm w-full !bg-white/10 sm:w-auto">Cancelar</a>
            </div>
        </form>
    </x-ui.card>
</x-ui.container>
