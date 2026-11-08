<div class="flex flex-wrap items-center gap-x-4 gap-y-2">
    @unless($theme->is_active || $theme->published_at)
        <a class="rounded-lg border border-white/20 bg-white/10 px-3 py-1.5 text-white transition-colors hover:bg-white/20" href="{{ route('admin.themes.edit', $theme) }}">Editar</a>
    @endunless
    <form method="POST" action="{{ route('admin.themes.duplicate', $theme) }}">
        @csrf
        <button type="submit" class="rounded-lg border border-white/20 bg-white/10 px-3 py-1.5 text-white transition-colors hover:bg-white/20">Duplicar como borrador</button>
    </form>
    @unless($theme->is_active)
        <form method="POST" action="{{ route('admin.themes.activate', $theme) }}"
              onsubmit="return confirm('¿Aplicar este tema a todo el sitio?')">
            @csrf
            <button type="submit" class="glass-button glass-button-sm">
                {{ $theme->published_at ? 'Restaurar' : 'Publicar' }}
            </button>
        </form>
    @endunless
</div>
