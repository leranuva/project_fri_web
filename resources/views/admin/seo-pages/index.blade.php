<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">Páginas SEO</h2>
    </x-slot>

    <x-ui.container>
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-500/20 border border-green-500/30">
                <span class="text-green-300">{{ session('success') }}</span>
            </div>
        @endif

        <x-ui.card glassmorphism="true" padding="lg">
            <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
                <h1 class="text-xl font-bold text-white">Páginas SEO dinámicas</h1>
                <a href="{{ route('admin.seo-pages.create') }}" class="glass-button glass-button-sm">Nueva página</a>
            </div>

            <form method="GET" class="mb-6">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por keyword, slug, título..." class="auth-form-input w-full max-w-md">
                <button type="submit" class="glass-button glass-button-sm mt-2">Buscar</button>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/20">
                            <th class="py-3 px-4 text-white/90 font-semibold">Slug</th>
                            <th class="py-3 px-4 text-white/90 font-semibold">Título</th>
                            <th class="py-3 px-4 text-white/90 font-semibold">Estado</th>
                            <th class="py-3 px-4 text-white/90 font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($seoPages as $page)
                            <tr class="border-b border-white/10">
                                <td class="py-3 px-4 text-white/80 font-mono text-sm">{{ $page->slug }}</td>
                                <td class="py-3 px-4 text-white">{{ $page->title }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded text-xs {{ $page->is_active ? 'bg-green-500/30 text-green-200' : 'bg-gray-500/30 text-gray-200' }}">
                                        {{ $page->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ url('/' . $page->slug) }}" target="_blank" class="text-blue-300 hover:text-blue-200 text-sm mr-2">Ver</a>
                                    <a href="{{ route('admin.seo-pages.edit', $page) }}" class="text-yellow-300 hover:text-yellow-200 text-sm mr-2">Editar</a>
                                    <form action="{{ route('admin.seo-pages.destroy', $page) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-300 hover:text-red-200 text-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-white/60">No hay páginas SEO. <a href="{{ route('admin.seo-pages.create') }}" class="auth-form-link">Crear una</a></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($seoPages->hasPages())
                <div class="mt-6">{{ $seoPages->links() }}</div>
            @endif
        </x-ui.card>
    </x-ui.container>
</x-app-layout>
