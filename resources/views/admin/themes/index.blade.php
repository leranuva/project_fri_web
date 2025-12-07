<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Gestión de Temas') }}
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

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/30 backdrop-blur-sm">
                <div class="flex items-center gap-2 text-red-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                        Gestión de Temas
                    </h1>
                    <p class="text-xs sm:text-sm md:text-base text-white/80">
                        Administra los temas de colores de la aplicación
                    </p>
                </div>
                <a href="{{ route('admin.themes.create') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center min-w-0">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="text-xs sm:text-sm md:text-base truncate">Nuevo Tema</span>
                </a>
            </div>

            {{-- Vista de tabla para desktop --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20">
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">ID</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Nombre</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Vista Previa</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Estado</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Creado</th>
                            <th class="text-right py-3 px-4 text-white/80 font-semibold text-sm">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($themes as $theme)
                            <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                                <td class="py-3 px-4 text-white/90">{{ $theme->id }}</td>
                                <td class="py-3 px-4 text-white/90 font-semibold">{{ $theme->name }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded border-2 border-white/30" style="background: linear-gradient(135deg, {{ $theme->background_gradient_start }}, {{ $theme->background_gradient_mid }}, {{ $theme->background_gradient_end }});"></div>
                                        <span class="text-white/70 text-sm">Gradiente</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $theme->is_active ? 'bg-green-500/30 text-green-200' : 'bg-gray-500/30 text-gray-200' }}">
                                        {{ $theme->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-white/70 text-sm">{{ $theme->created_at->format('d/m/Y') }}</td>
                                <td class="py-3 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1 sm:gap-2 flex-wrap">
                                        <a href="{{ route('admin.themes.show', $theme) }}" class="p-1.5 sm:p-2 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200" title="Ver">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.themes.edit', $theme) }}" class="p-1.5 sm:p-2 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200" title="Editar">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        @if(!$theme->is_active)
                                            <form action="{{ route('admin.themes.activate', $theme) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="p-1.5 sm:p-2 rounded-lg bg-blue-500/30 hover:bg-blue-500/40 border border-blue-500/30 transition-all duration-200" title="Activar">
                                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.themes.destroy', $theme) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este tema?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 sm:p-2 rounded-lg bg-red-500/30 hover:bg-red-500/40 border border-red-500/30 transition-all duration-200" title="Eliminar">
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    No hay temas creados. <a href="{{ route('admin.themes.create') }}" class="text-white underline">Crear el primero</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Vista de cards para móvil --}}
            <div class="md:hidden space-y-4">
                @forelse($themes as $theme)
                    <x-ui.card glassmorphism="true" padding="md" class="user-card-mobile">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-white font-semibold text-lg mb-1">{{ $theme->name }}</h3>
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-6 h-6 rounded border border-white/30" style="background: linear-gradient(135deg, {{ $theme->background_gradient_start }}, {{ $theme->background_gradient_mid }}, {{ $theme->background_gradient_end }});"></div>
                                    <span class="text-white/70 text-sm">Vista Previa</span>
                                </div>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $theme->is_active ? 'bg-green-500/30 text-green-200' : 'bg-gray-500/30 text-gray-200' }}">
                                    {{ $theme->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 pt-3 border-t border-white/10">
                            <a href="{{ route('admin.themes.show', $theme) }}" class="glass-button glass-button-sm text-center text-xs sm:text-sm">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Ver
                            </a>
                            <a href="{{ route('admin.themes.edit', $theme) }}" class="glass-button glass-button-sm text-center text-xs sm:text-sm">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar
                            </a>
                            @if(!$theme->is_active)
                                <form action="{{ route('admin.themes.activate', $theme) }}" method="POST" class="col-span-2 sm:col-span-1">
                                    @csrf
                                    <button type="submit" class="w-full glass-button glass-button-sm text-xs sm:text-sm" style="background: rgba(59, 130, 246, 0.3);">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Activar
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.themes.destroy', $theme) }}" method="POST" class="{{ !$theme->is_active ? 'col-span-2 sm:col-span-1' : 'col-span-2' }}" onsubmit="return confirm('¿Estás seguro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full glass-button glass-button-sm text-xs sm:text-sm" style="background: rgba(239, 68, 68, 0.3);">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </x-ui.card>
                @empty
                    <x-ui.card glassmorphism="true" padding="md" class="text-center">
                        <p class="text-white/70 mb-4">No hay temas creados.</p>
                        <a href="{{ route('admin.themes.create') }}" class="glass-button glass-button-sm inline-block">
                            Crear Tema
                        </a>
                    </x-ui.card>
                @endforelse
            </div>

            {{-- Paginación --}}
            @if($themes->hasPages())
                <div class="mt-6">
                    {{ $themes->links() }}
                </div>
            @endif
        </x-ui.card>
    </x-ui.container>
</x-app-layout>


