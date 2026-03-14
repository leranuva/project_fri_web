<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Detalles de la Tienda') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-6">
                <a href="{{ route('admin.stores.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Tiendas
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                            Detalles de la Tienda
                        </h1>
                        <p class="text-sm sm:text-base text-white/80">
                            Información completa de la tienda
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.stores.edit', $store) }}" class="glass-button glass-button-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar
                        </a>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Vista Previa de la Tienda --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Vista Previa</h3>
                    <div class="max-w-xs mx-auto">
                        <div class="p-6 rounded-xl bg-white/10 border border-white/20 text-center">
                            @if($store->logo_url)
                                <div class="mb-4 w-24 h-24 mx-auto flex items-center justify-center bg-white/10 rounded-lg p-2">
                                    {!! $store->logo_url !!}
                                </div>
                            @else
                                <div class="mb-4 w-24 h-24 mx-auto bg-white/10 rounded-lg flex items-center justify-center">
                                    <span class="text-white/60 text-xs font-semibold">{{ $store->name }}</span>
                                </div>
                            @endif
                            <h3 class="text-lg font-semibold text-white">{{ $store->name }}</h3>
                        </div>
                    </div>
                </div>

                {{-- Información Detallada --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-white/60 text-sm mb-1">ID</p>
                        <p class="text-white font-semibold">{{ $store->id }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Nombre</p>
                        <p class="text-white font-semibold">{{ $store->name }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Orden</p>
                        <p class="text-white font-semibold">{{ $store->order }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Estado</p>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $store->is_active ? 'bg-green-500/30 text-green-200' : 'bg-gray-500/30 text-gray-200' }}">
                            {{ $store->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                    @if($store->logo_url)
                        <div class="sm:col-span-2">
                            <p class="text-white/60 text-sm mb-1">Código SVG del Logo</p>
                            <div class="text-white break-all bg-white/5 p-3 rounded-lg border border-white/10 overflow-x-auto">
                                <code class="text-xs font-mono">{{ Str::limit($store->logo_url, 200) }}</code>
                            </div>
                        </div>
                    @endif
                    @if($store->website_url)
                        <div class="sm:col-span-2">
                            <p class="text-white/60 text-sm mb-1">URL del Sitio Web</p>
                            <p class="text-white break-all">
                                <a href="{{ $store->website_url }}" target="_blank" class="text-blue-300 hover:text-blue-200 underline">
                                    {{ $store->website_url }}
                                </a>
                            </p>
                        </div>
                    @endif
                    <div>
                        <p class="text-white/60 text-sm mb-1">Creado</p>
                        <p class="text-white">{{ $store->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Actualizado</p>
                        <p class="text-white">{{ $store->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>





