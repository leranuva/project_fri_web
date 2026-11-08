<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">Gestión de temas</h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6 text-white">
            @foreach(['success', 'error'] as $status)
                @if(session($status))
                    <p role="status" @class([
                        'mb-4 rounded-xl border p-3',
                        'border-green-500/30 bg-green-500/20 text-green-200' => $status === 'success',
                        'border-red-500/30 bg-red-500/20 text-red-200' => $status === 'error',
                    ])>{{ session($status) }}</p>
                @endif
            @endforeach

            <div class="mb-6 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <h1 class="mb-2 text-xl font-bold text-white sm:text-2xl md:text-3xl">Gestión de temas</h1>
                    <p class="text-sm text-white/80">Edita un borrador y publica la paleta cuando esté lista.</p>
                </div>
                <a href="{{ route('admin.themes.create') }}" class="glass-button glass-button-sm w-full gap-2 sm:w-auto">
                    <svg aria-hidden="true" class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Crear borrador
                </a>
            </div>

            @if($previousTheme)
                <form method="POST" action="{{ route('admin.themes.activate', $previousTheme) }}"
                      class="mt-4 flex flex-wrap items-center gap-3 rounded-xl border border-white/10 bg-white/5 p-3"
                      onsubmit="return confirm('¿Restaurar el tema anterior en todo el sitio?')">
                    @csrf
                    <span>Tema anterior: <strong>{{ $previousTheme->name }}</strong></span>
                    <button type="submit" class="glass-button glass-button-sm !bg-white/10">Restaurar tema anterior</button>
                </form>
            @endif

            <ul class="mt-4 divide-y divide-white/10">
                @forelse($themes as $theme)
                    <li class="flex flex-wrap items-center justify-between gap-4 rounded-lg px-3 py-4 transition-colors hover:bg-white/5">
                        <div class="flex min-w-0 items-center gap-3">
                            <span aria-hidden="true" class="theme-preview h-10 w-10 shrink-0 rounded-md border border-white/20"
                                  style="{{ \App\Support\ThemePalette::cssVariables(\App\Support\ThemePalette::values($theme)) }}"></span>
                            <div class="min-w-0">
                                <a class="break-words font-semibold underline" href="{{ route('admin.themes.show', $theme) }}">{{ $theme->name }}</a>
                                <p class="text-sm text-white/80">{{ $theme->is_active ? 'Publicado' : ($theme->published_at ? 'Historial' : 'Borrador') }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 text-sm">
                            @include('admin.themes.actions')
                            @unless($theme->is_active || $theme->published_at)
                                <form method="POST" action="{{ route('admin.themes.destroy', $theme) }}" onsubmit="return confirm('¿Eliminar este borrador?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-red-500/30 bg-red-500/20 px-3 py-1.5 text-red-200 transition-colors hover:bg-red-500/30">Eliminar</button>
                                </form>
                            @endunless
                        </div>
                    </li>
                @empty
                    <li class="py-4 text-white/80">Todavía no hay temas guardados. El sitio usa la paleta de respaldo.</li>
                @endforelse
            </ul>

            {{ $themes->links() }}
        </x-ui.card>
    </x-ui.container>
</x-app-layout>
