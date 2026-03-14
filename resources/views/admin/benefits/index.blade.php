<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Administración de Beneficios') }}
        </h2>
    </x-slot>

    <x-ui.container>
        {{-- Mensajes de éxito/error --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-500/20 border border-green-500/30 backdrop-blur-sm">
                <div class="flex items-center gap-2 text-green-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                        Gestión de Beneficios
                    </h1>
                    <p class="text-xs sm:text-sm md:text-base text-white/80">
                        Administra los beneficios de la sección "¿Por qué elegir Flat Rate Imports?"
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="{{ route('admin.benefits.create') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="text-xs sm:text-sm md:text-base">Nuevo Beneficio</span>
                    </a>
                    <a href="{{ route('admin.benefit-sections.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center" style="background: rgba(255, 255, 255, 0.1);">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="text-xs sm:text-sm md:text-base">Configurar Título</span>
                    </a>
                </div>
            </div>

            {{-- Vista de tabla para desktop --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20">
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">ID</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Título</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Orden</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Estado</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Creado</th>
                            <th class="text-right py-3 px-4 text-white/80 font-semibold text-sm">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($benefits as $benefit)
                            <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                                <td class="py-3 px-4 text-white/90">{{ $benefit->id }}</td>
                                <td class="py-3 px-4 text-white/90">{{ $benefit->title }}</td>
                                <td class="py-3 px-4 text-white/90">{{ $benefit->order }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $benefit->is_active ? 'bg-green-500/30 text-green-200' : 'bg-gray-500/30 text-gray-200' }}">
                                        {{ $benefit->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-white/70 text-sm">{{ $benefit->created_at->format('d/m/Y') }}</td>
                                <td class="py-3 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.benefits.show', $benefit) }}" class="p-2 rounded-lg bg-blue-500/20 hover:bg-blue-500/30 border border-blue-500/30 text-blue-300 hover:text-blue-200 transition-all duration-200" title="Ver">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.benefits.edit', $benefit) }}" class="p-2 rounded-lg bg-yellow-500/20 hover:bg-yellow-500/30 border border-yellow-500/30 text-yellow-300 hover:text-yellow-200 transition-all duration-200" title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.benefits.destroy', $benefit) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este beneficio?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg bg-red-500/20 hover:bg-red-500/30 border border-red-500/30 text-red-300 hover:text-red-200 transition-all duration-200" title="Eliminar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-white/70">
                                    No hay beneficios registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Vista de cards para móvil --}}
            <div class="md:hidden space-y-4">
                @forelse($benefits as $benefit)
                    <div class="user-card-mobile p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-white mb-2">{{ $benefit->title }}</h3>
                                <p class="text-sm text-white/70">{{ Str::limit($benefit->description, 80) }}</p>
                            </div>
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $benefit->is_active ? 'bg-green-500/30 text-green-200' : 'bg-gray-500/30 text-gray-200' }} ml-2 flex-shrink-0">
                                {{ $benefit->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between text-xs text-white/60 mb-4 pb-3 border-b border-white/10">
                            <div class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <span>ID: {{ $benefit->id }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                                <span>Orden: {{ $benefit->order }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.benefits.show', $benefit) }}" class="flex-1 flex items-center justify-center gap-2 p-2.5 rounded-lg bg-blue-500/20 hover:bg-blue-500/30 border border-blue-500/30 text-blue-300 hover:text-blue-200 transition-all duration-200 text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>Ver</span>
                            </a>
                            <a href="{{ route('admin.benefits.edit', $benefit) }}" class="flex-1 flex items-center justify-center gap-2 p-2.5 rounded-lg bg-yellow-500/20 hover:bg-yellow-500/30 border border-yellow-500/30 text-yellow-300 hover:text-yellow-200 transition-all duration-200 text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span>Editar</span>
                            </a>
                            <form action="{{ route('admin.benefits.destroy', $benefit) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Estás seguro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full flex items-center justify-center gap-2 p-2.5 rounded-lg bg-red-500/20 hover:bg-red-500/30 border border-red-500/30 text-red-300 hover:text-red-200 transition-all duration-200 text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Eliminar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <p class="text-white/70">No hay beneficios registrados</p>
                    </div>
                @endforelse
            </div>

            @if($benefits->hasPages())
                <div class="mt-6">
                    {{ $benefits->links() }}
                </div>
            @endif
        </x-ui.card>
    </x-ui.container>
</x-app-layout>

