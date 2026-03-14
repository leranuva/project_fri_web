<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">{{ $seoPage->title }}</h2>
    </x-slot>

    <x-ui.container>
        <a href="{{ route('admin.seo-pages.index') }}" class="inline-flex text-white/80 hover:text-white mb-6">← Volver</a>

        <x-ui.card glassmorphism="true" padding="lg">
            <div class="space-y-4">
                <p><span class="text-white/60">Slug:</span> <span class="text-white font-mono">{{ $seoPage->slug }}</span></p>
                <p><span class="text-white/60">Keyword:</span> <span class="text-white">{{ $seoPage->keyword }}</span></p>
                <p><span class="text-white/60">Estado:</span> <span class="{{ $seoPage->is_active ? 'text-green-300' : 'text-gray-400' }}">{{ $seoPage->is_active ? 'Activo' : 'Inactivo' }}</span></p>
                @if($seoPage->store_link)
                    <p><span class="text-white/60">Tienda:</span> <a href="{{ $seoPage->store_link }}" target="_blank" class="auth-form-link">{{ $seoPage->store_link }}</a></p>
                @endif
            </div>
            <div class="mt-6 flex gap-4">
                <a href="{{ url('/' . $seoPage->slug) }}" target="_blank" class="glass-button">Ver página</a>
                <a href="{{ route('admin.seo-pages.edit', $seoPage) }}" class="glass-button" style="background: rgba(255,255,255,0.1);">Editar</a>
            </div>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>
