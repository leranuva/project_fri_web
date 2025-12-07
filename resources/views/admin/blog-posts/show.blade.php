<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Detalles del Artículo') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-6">
                <a href="{{ route('admin.blog-posts.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Artículos
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                            Detalles del Artículo
                        </h1>
                        <p class="text-sm sm:text-base text-white/80">
                            Información completa del artículo
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.blog-posts.edit', $blogPost) }}" class="glass-button glass-button-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar
                        </a>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Vista Previa del Artículo --}}
                <div class="p-6 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-4">Vista Previa</h3>
                    <div class="max-w-sm mx-auto">
                        <x-ui.card glassmorphism="true" class="blog-card">
                            @if($blogPost->featured_image_url)
                                <div class="mb-4">
                                    <img src="{{ $blogPost->featured_image_url }}" alt="{{ $blogPost->title }}" class="w-full h-48 object-cover rounded-lg">
                                </div>
                            @else
                                <div class="w-full h-48 bg-white/10 rounded-lg mb-4"></div>
                            @endif
                            <h3 class="text-xl font-semibold mb-2 text-white">
                                {{ $blogPost->title }}
                            </h3>
                            @if($blogPost->excerpt)
                                <p class="text-white/80 text-sm mb-4">
                                    {{ $blogPost->excerpt }}
                                </p>
                            @endif
                            @if($blogPost->link)
                                <a href="{{ $blogPost->link }}" class="auth-form-link text-sm font-semibold">
                                    Leer más →
                                </a>
                            @else
                                <a href="#" class="auth-form-link text-sm font-semibold">
                                    Leer más →
                                </a>
                            @endif
                        </x-ui.card>
                    </div>
                </div>

                {{-- Información Detallada --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-white/60 text-sm mb-1">ID</p>
                        <p class="text-white font-semibold">{{ $blogPost->id }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Título</p>
                        <p class="text-white font-semibold">{{ $blogPost->title }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Orden</p>
                        <p class="text-white font-semibold">{{ $blogPost->order }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Estado</p>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $blogPost->is_active ? 'bg-green-500/30 text-green-200' : 'bg-gray-500/30 text-gray-200' }}">
                            {{ $blogPost->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                    @if($blogPost->excerpt)
                        <div class="sm:col-span-2">
                            <p class="text-white/60 text-sm mb-1">Descripción Breve</p>
                            <p class="text-white">{{ $blogPost->excerpt }}</p>
                        </div>
                    @endif
                    @if($blogPost->content)
                        <div class="sm:col-span-2">
                            <p class="text-white/60 text-sm mb-1">Contenido Completo</p>
                            <p class="text-white whitespace-pre-wrap">{{ $blogPost->content }}</p>
                        </div>
                    @endif
                    @if($blogPost->featured_image_url)
                        <div class="sm:col-span-2">
                            <p class="text-white/60 text-sm mb-1">URL de la Imagen Destacada</p>
                            <p class="text-white break-all">
                                <a href="{{ $blogPost->featured_image_url }}" target="_blank" class="text-blue-300 hover:text-blue-200 underline">
                                    {{ $blogPost->featured_image_url }}
                                </a>
                            </p>
                        </div>
                    @endif
                    @if($blogPost->link)
                        <div class="sm:col-span-2">
                            <p class="text-white/60 text-sm mb-1">Enlace del Artículo</p>
                            <p class="text-white break-all">
                                <a href="{{ $blogPost->link }}" target="_blank" class="text-blue-300 hover:text-blue-200 underline">
                                    {{ $blogPost->link }}
                                </a>
                            </p>
                        </div>
                    @endif
                    @if($blogPost->published_at)
                        <div>
                            <p class="text-white/60 text-sm mb-1">Fecha de Publicación</p>
                            <p class="text-white">{{ $blogPost->published_at->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-white/60 text-sm mb-1">Creado</p>
                        <p class="text-white">{{ $blogPost->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-white/60 text-sm mb-1">Actualizado</p>
                        <p class="text-white">{{ $blogPost->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>





