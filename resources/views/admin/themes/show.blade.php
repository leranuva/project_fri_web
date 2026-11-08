<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">{{ $theme->name }}</h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div data-theme-editor class="space-y-5 text-white">
                @if(session('success'))
                    <p role="status" class="rounded-xl border border-green-500/30 bg-green-500/20 p-3 text-green-200">{{ session('success') }}</p>
                @endif

                <div class="flex flex-wrap items-center justify-between gap-3">
                    <a href="{{ route('admin.themes.index') }}" class="inline-flex items-center gap-2 text-sm text-white/80 transition-colors hover:text-white">
                        <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver a temas
                    </a>
                    @include('admin.themes.actions')
                </div>

                <h1 class="break-words text-xl font-bold text-white sm:text-2xl md:text-3xl">{{ $theme->name }}</h1>
                <p class="text-sm text-white/80">{{ $theme->is_active ? 'Publicado en el sitio' : ($theme->published_at ? 'Versión publicada anteriormente' : 'Borrador') }}</p>

                @php($palette = \App\Support\ThemePalette::values($theme))
                @include('admin.themes.preview', ['palette' => $palette])

                <details class="rounded-xl border border-white/10 bg-white/5 p-4">
                    <summary class="cursor-pointer font-semibold">Ver valores de la paleta</summary>
                    <dl class="mt-3 grid gap-3 text-sm sm:grid-cols-2 lg:grid-cols-3">
                        @foreach([
                            'primary_color' => 'Principal',
                            'secondary_color' => 'Secundario',
                            'accent_color' => 'Acento',
                            'background_gradient_start' => 'Inicio del fondo',
                            'background_gradient_mid' => 'Centro del fondo',
                            'background_gradient_end' => 'Final del fondo',
                            'text_color' => 'Texto principal',
                            'text_secondary_color' => 'Texto secundario',
                            'button_color' => 'Fondo del botón',
                        ] as $field => $label)
                            <div>
                                <dt>{{ $label }}</dt>
                                <dd><code class="text-white/80">{{ $palette[$field] }}</code></dd>
                            </div>
                        @endforeach
                    </dl>
                </details>
            </div>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>
