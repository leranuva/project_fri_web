<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Administración de Productos') }}
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
                        Gestión de Productos
                    </h1>
                    <p class="text-xs sm:text-sm md:text-base text-white/80">
                        Administra los productos del sistema
                    </p>
                </div>
                <a href="{{ route('admin.products.create') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="text-xs sm:text-sm md:text-base">Nuevo Producto</span>
                </a>
            </div>

            {{-- Barra de búsqueda y filtros --}}
            <form method="GET" action="{{ route('admin.products.index') }}" class="mb-6">
                <div class="bg-white/5 backdrop-blur-md border border-white/20 rounded-xl p-4 sm:p-5">
                    <div class="flex flex-col lg:flex-row gap-4">
                        {{-- Campo de búsqueda --}}
                        <div class="flex-1">
                            <label for="search" class="block text-white/90 text-sm font-medium mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Buscar Producto
                            </label>
                            <input 
                                type="text" 
                                id="search" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Buscar por SKU, código arancelario o nombre..."
                                class="auth-form-input w-full"
                            />
                        </div>

                        {{-- Filtro por tipo --}}
                        <div class="lg:w-48">
                            <label for="filter_type" class="block text-white/90 text-sm font-medium mb-2">
                                Tipo de Búsqueda
                            </label>
                            <select 
                                id="filter_type" 
                                name="filter_type" 
                                class="auth-form-input w-full"
                            >
                                <option value="">Todos los campos</option>
                                <option value="sku" {{ request('filter_type') === 'sku' ? 'selected' : '' }}>Código SKU</option>
                                <option value="arancel" {{ request('filter_type') === 'arancel' ? 'selected' : '' }}>Código Arancel</option>
                                <option value="name" {{ request('filter_type') === 'name' ? 'selected' : '' }}>Nombre</option>
                            </select>
                        </div>

                        {{-- Filtro por estado --}}
                        <div class="lg:w-40">
                            <label for="status" class="block text-white/90 text-sm font-medium mb-2">
                                Estado
                            </label>
                            <select 
                                id="status" 
                                name="status" 
                                class="auth-form-input w-full"
                            >
                                <option value="">Todos</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivos</option>
                            </select>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="flex items-end gap-2 lg:flex-col">
                            <button 
                                type="submit" 
                                class="glass-button glass-button-sm w-full lg:w-auto flex items-center justify-center px-4"
                            >
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <span class="text-xs sm:text-sm">Buscar</span>
                            </button>
                            @if(request()->hasAny(['search', 'filter_type', 'status']))
                            <a 
                                href="{{ route('admin.products.index') }}" 
                                class="glass-button glass-button-sm w-full lg:w-auto flex items-center justify-center px-4"
                                style="background: rgba(255, 255, 255, 0.1);"
                            >
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span class="text-xs sm:text-sm">Limpiar</span>
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- Resultados de búsqueda --}}
                    @if(request()->hasAny(['search', 'filter_type', 'status']))
                    <div class="mt-4 pt-4 border-t border-white/10">
                        <p class="text-white/70 text-sm">
                            @if($products->total() > 0)
                                Mostrando <span class="text-white font-semibold">{{ $products->firstItem() }}</span> - 
                                <span class="text-white font-semibold">{{ $products->lastItem() }}</span> de 
                                <span class="text-white font-semibold">{{ $products->total() }}</span> producto(s)
                            @else
                                <span class="text-yellow-300">No se encontraron productos con los filtros aplicados</span>
                            @endif
                        </p>
                    </div>
                    @endif
                </div>
            </form>

            {{-- Grid de tarjetas de productos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @forelse($products as $product)
                    <div class="product-card bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-5 hover:bg-white/15 hover:border-white/30 transition-all duration-300 shadow-lg hover:shadow-xl flex flex-col">
                        {{-- Header de la tarjeta --}}
                        <div class="flex items-start justify-between mb-4 pb-4 border-b border-white/10">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-white font-bold text-lg mb-1 truncate">{{ $product->name }}</h3>
                                <div class="flex items-center gap-2 flex-wrap mt-1">
                                    <span class="text-white/60 text-xs">ID: <span class="text-white font-medium">{{ $product->id }}</span></span>
                                    <span class="text-white/60 text-xs">•</span>
                                    <span class="text-white/60 text-xs">SKU: <span class="text-white font-mono font-medium">{{ $product->key }}</span></span>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $product->is_active ? 'bg-green-500/30 text-green-200 border border-green-500/30' : 'bg-red-500/30 text-red-200 border border-red-500/30' }} flex-shrink-0 ml-2">
                                {{ $product->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        
                        {{-- Información del producto en grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4 flex-1">
                            {{-- Código Arancel --}}
                            <div class="bg-white/5 rounded-lg p-3 border border-white/10">
                                <p class="text-white/60 text-xs mb-1">Código Arancel</p>
                                <p class="text-white font-mono font-semibold text-sm">{{ $product->arancel_code ?? 'N/A' }}</p>
                            </div>
                            
                            {{-- Subpartida --}}
                            <div class="bg-white/5 rounded-lg p-3 border border-white/10">
                                <p class="text-white/60 text-xs mb-1">Subpartida</p>
                                <p class="text-white font-mono font-semibold text-sm">{{ $product->arancel_subpartida ?? 'N/A' }}</p>
                            </div>
                            
                            {{-- Ad-Valorem --}}
                            <div class="bg-white/5 rounded-lg p-3 border border-white/10">
                                <p class="text-white/60 text-xs mb-1">Ad-Valorem</p>
                                <p class="text-white font-bold text-base">{{ number_format($product->ad_valorem * 100, 2) }}%</p>
                            </div>
                            
                            {{-- Arancel Específico --}}
                            <div class="bg-white/5 rounded-lg p-3 border border-white/10">
                                <p class="text-white/60 text-xs mb-1">Arancel Específico</p>
                                <p class="text-white font-bold text-base">${{ number_format($product->arancel_especifico, 2) }}</p>
                            </div>
                            
                            {{-- Porcentaje Adicional --}}
                            @if($product->new_percent)
                            <div class="bg-white/5 rounded-lg p-3 border border-white/10">
                                <p class="text-white/60 text-xs mb-1">% Adicional</p>
                                <p class="text-white font-semibold text-sm">{{ number_format($product->new_percent * 100, 2) }}%</p>
                            </div>
                            @endif
                            
                            {{-- Categoría --}}
                            @if($product->category)
                            <div class="bg-white/5 rounded-lg p-3 border border-white/10 sm:col-span-2">
                                <p class="text-white/60 text-xs mb-1">Categoría</p>
                                <p class="text-white font-medium text-sm">{{ $product->category }}</p>
                            </div>
                            @endif
                        </div>
                        
                        {{-- Botones de acción --}}
                        <div class="flex items-center gap-2 pt-4 border-t border-white/10">
                            <a href="{{ route('admin.products.show', $product) }}" class="flex-1 flex items-center justify-center gap-1.5 p-2.5 rounded-lg bg-blue-500/20 hover:bg-blue-500/30 border border-blue-500/30 text-blue-300 hover:text-blue-200 transition-all duration-200 text-xs sm:text-sm font-medium" title="Ver">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span class="hidden sm:inline">Ver</span>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="flex-1 flex items-center justify-center gap-1.5 p-2.5 rounded-lg bg-yellow-500/20 hover:bg-yellow-500/30 border border-yellow-500/30 text-yellow-300 hover:text-yellow-200 transition-all duration-200 text-xs sm:text-sm font-medium" title="Editar">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span class="hidden sm:inline">Editar</span>
                            </a>
                            <button 
                                type="button"
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-product-deletion-{{ $product->id }}')"
                                class="flex-1 flex items-center justify-center gap-1.5 p-2.5 rounded-lg bg-red-500/20 hover:bg-red-500/30 border border-red-500/30 text-red-300 hover:text-red-200 transition-all duration-200 text-xs sm:text-sm font-medium"
                                title="Eliminar"
                            >
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span class="hidden sm:inline">Eliminar</span>
                            </button>
                            
                            {{-- Modal de Confirmación de Eliminación (mismo modal que desktop) --}}
                            <x-modal name="confirm-product-deletion-{{ $product->id }}" focusable>
                                <div class="delete-modal-content">
                                    <div class="delete-modal-icon">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <h2 class="delete-modal-title">
                                        {{ __('¿Eliminar Producto?') }}
                                    </h2>
                                    <p class="delete-modal-message">
                                        {{ __('¿Estás seguro de que deseas eliminar el producto') }} <strong>{{ $product->name }}</strong>? 
                                        {{ __('Esta acción no se puede deshacer y todos los datos del producto se eliminarán permanentemente.') }}
                                    </p>
                                    <div class="delete-modal-info">
                                        <div class="delete-modal-info-item">
                                            <span class="delete-modal-info-label">ID:</span>
                                            <span class="delete-modal-info-value">{{ $product->id }}</span>
                                        </div>
                                        <div class="delete-modal-info-item">
                                            <span class="delete-modal-info-label">Código Arancel:</span>
                                            <span class="delete-modal-info-value">{{ $product->arancel_code ?? 'N/A' }}</span>
                                        </div>
                                        <div class="delete-modal-info-item">
                                            <span class="delete-modal-info-label">Estado:</span>
                                            <span class="delete-modal-info-value">
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $product->is_active ? 'bg-green-500/30 text-green-200' : 'bg-red-500/30 text-red-200' }}">
                                                    {{ $product->is_active ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="delete-modal-form">
                                        @csrf
                                        @method('DELETE')
                                        <div class="delete-modal-actions">
                                            <button 
                                                type="button"
                                                x-on:click="$dispatch('close-modal', 'confirm-product-deletion-{{ $product->id }}')"
                                                class="delete-modal-button delete-modal-button-cancel"
                                            >
                                                {{ __('Cancelar') }}
                                            </button>
                                            <button 
                                                type="submit"
                                                class="delete-modal-button delete-modal-button-delete"
                                            >
                                                {{ __('Eliminar Producto') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </x-modal>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="bg-white/5 rounded-xl p-8 border border-white/10">
                            <svg class="w-16 h-16 mx-auto text-white/30 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            @if(request()->hasAny(['search', 'filter_type', 'status']))
                                <p class="text-white/70 text-lg font-medium">No se encontraron productos</p>
                                <p class="text-white/50 text-sm mt-2">Intenta con otros términos de búsqueda o filtros</p>
                                <a href="{{ route('admin.products.index') }}" class="inline-block mt-4 glass-button glass-button-sm">
                                    Limpiar búsqueda
                                </a>
                            @else
                                <p class="text-white/70 text-lg font-medium">No hay productos registrados</p>
                                <p class="text-white/50 text-sm mt-2">Crea tu primer producto para comenzar</p>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            @if($products->hasPages())
                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            @endif
        </x-ui.card>
    </x-ui.container>
</x-app-layout>

