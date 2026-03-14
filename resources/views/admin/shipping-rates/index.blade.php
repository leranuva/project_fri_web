<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Administración de Tarifas de Envío') }}
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
                        Gestión de Tarifas de Envío
                    </h1>
                    <p class="text-xs sm:text-sm md:text-base text-white/80">
                        Administra las tarifas de envío del sistema
                    </p>
                </div>
                <a href="{{ route('admin.shipping-rates.create') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="text-xs sm:text-sm md:text-base">Nueva Tarifa</span>
                </a>
            </div>

            {{-- Barra de búsqueda y filtros --}}
            <form method="GET" action="{{ route('admin.shipping-rates.index') }}" class="mb-6">
                <div class="bg-white/5 backdrop-blur-md border border-white/20 rounded-xl p-4 sm:p-5">
                    <div class="flex flex-col lg:flex-row gap-4">
                        {{-- Campo de búsqueda --}}
                        <div class="flex-1">
                            <label for="search" class="block text-white/90 text-sm font-medium mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Buscar Tarifa
                            </label>
                            <input 
                                type="text" 
                                id="search" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Buscar por método o notas..."
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
                                <option value="method" {{ request('filter_type') === 'method' ? 'selected' : '' }}>Método</option>
                                <option value="notes" {{ request('filter_type') === 'notes' ? 'selected' : '' }}>Notas</option>
                            </select>
                        </div>

                        {{-- Filtro por método --}}
                        <div class="lg:w-48">
                            <label for="method" class="block text-white/90 text-sm font-medium mb-2">
                                Método de Envío
                            </label>
                            <select 
                                id="method" 
                                name="method" 
                                class="auth-form-input w-full"
                            >
                                <option value="">Todos</option>
                                <option value="maritimo" {{ request('method') === 'maritimo' ? 'selected' : '' }}>Marítimo</option>
                                <option value="aereo" {{ request('method') === 'aereo' ? 'selected' : '' }}>Aéreo</option>
                                <option value="aereoExpres" {{ request('method') === 'aereoExpres' ? 'selected' : '' }}>Aéreo Express</option>
                                <option value="courier4x4" {{ request('method') === 'courier4x4' ? 'selected' : '' }}>Courier 4x4</option>
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
                            @if(request()->hasAny(['search', 'filter_type', 'method', 'status']))
                            <a 
                                href="{{ route('admin.shipping-rates.index') }}" 
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
                    @if(request()->hasAny(['search', 'filter_type', 'method', 'status']))
                    <div class="mt-4 pt-4 border-t border-white/10">
                        <p class="text-white/70 text-sm">
                            @if($shippingRates->total() > 0)
                                Mostrando <span class="text-white font-semibold">{{ $shippingRates->firstItem() }}</span> - 
                                <span class="text-white font-semibold">{{ $shippingRates->lastItem() }}</span> de 
                                <span class="text-white font-semibold">{{ $shippingRates->total() }}</span> tarifa(s)
                            @else
                                <span class="text-yellow-300">No se encontraron tarifas con los filtros aplicados</span>
                            @endif
                        </p>
                    </div>
                    @endif
                </div>
            </form>

            {{-- Grid de tarjetas de tarifas --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @forelse($shippingRates as $rate)
                    <div class="product-card bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-5 hover:bg-white/15 hover:border-white/30 transition-all duration-300 shadow-lg hover:shadow-xl flex flex-col">
                        {{-- Header de la tarjeta --}}
                        <div class="flex items-start justify-between mb-4 pb-4 border-b border-white/10">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-white font-bold text-lg mb-1 truncate capitalize">{{ $rate->method }}</h3>
                                <p class="text-white/70 text-xs">ID: <span class="text-white font-medium">{{ $rate->id }}</span></p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $rate->is_active ? 'bg-green-500/30 text-green-200 border border-green-500/30' : 'bg-red-500/30 text-red-200 border border-red-500/30' }} flex-shrink-0 ml-2">
                                {{ $rate->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        
                        {{-- Información de la tarifa en grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4 flex-1">
                            {{-- Peso Mínimo --}}
                            <div class="bg-white/5 rounded-lg p-3 border border-white/10">
                                <p class="text-white/60 text-xs mb-1">Peso Mínimo</p>
                                <p class="text-white font-semibold text-sm">{{ number_format($rate->min_weight, 2) }} lb</p>
                            </div>
                            
                            {{-- Peso Máximo --}}
                            <div class="bg-white/5 rounded-lg p-3 border border-white/10">
                                <p class="text-white/60 text-xs mb-1">Peso Máximo</p>
                                <p class="text-white font-semibold text-sm">{{ $rate->max_weight ? number_format($rate->max_weight, 2) . ' lb' : '∞' }}</p>
                            </div>
                            
                            {{-- Rango de Peso (especial para Courier 4x4) --}}
                            @if($rate->method === 'courier4x4')
                            <div class="bg-white/5 rounded-lg p-3 border border-white/10 sm:col-span-2">
                                <p class="text-white/60 text-xs mb-1">Rango de Peso</p>
                                <p class="text-white font-semibold text-sm">
                                    @if($rate->min_weight == $rate->max_weight)
                                        {{ number_format($rate->min_weight, 0) }} lb
                                    @else
                                        {{ number_format($rate->min_weight, 0) }} - {{ number_format($rate->max_weight, 2) }} lb
                                    @endif
                                </p>
                            </div>
                            @endif
                            
                            {{-- Costo por Libra --}}
                            <div class="bg-white/5 rounded-lg p-3 border border-white/10">
                                <p class="text-white/60 text-xs mb-1">Costo por Libra</p>
                                <p class="text-white font-bold text-base">
                                    @if($rate->method === 'courier4x4' && $rate->cost_per_pound > 0)
                                        ${{ number_format($rate->cost_per_pound, 2) }}
                                    @elseif($rate->method === 'courier4x4')
                                        N/A
                                    @else
                                        ${{ number_format($rate->cost_per_pound, 2) }}
                                    @endif
                                </p>
                            </div>
                            
                            {{-- Costo Fijo (Arancel Fijo para Courier 4x4) --}}
                            @if($rate->fixed_cost)
                            <div class="bg-white/5 rounded-lg p-3 border border-white/10">
                                <p class="text-white/60 text-xs mb-1">
                                    @if($rate->method === 'courier4x4')
                                        Arancel Fijo
                                    @else
                                        Costo Fijo
                                    @endif
                                </p>
                                <p class="text-white font-bold text-base">${{ number_format($rate->fixed_cost, 2) }}</p>
                            </div>
                            @endif
                            
                            {{-- Valor FOB Máximo --}}
                            @if($rate->max_value_fob)
                            <div class="bg-white/5 rounded-lg p-3 border border-white/10 sm:col-span-2">
                                <p class="text-white/60 text-xs mb-1">Valor FOB Máximo</p>
                                <p class="text-white font-semibold text-sm">${{ number_format($rate->max_value_fob, 2) }}</p>
                            </div>
                            @endif
                            
                            {{-- Caso Especial --}}
                            @if($rate->is_special_case)
                            <div class="bg-white/5 rounded-lg p-3 border border-white/10 sm:col-span-2">
                                <p class="text-white/60 text-xs mb-1">Tipo</p>
                                <p class="text-yellow-300 font-semibold text-sm">Caso Especial</p>
                            </div>
                            @endif
                        </div>
                        
                        {{-- Botones de acción --}}
                        <div class="flex items-center gap-2 pt-4 border-t border-white/10">
                            <a href="{{ route('admin.shipping-rates.show', $rate) }}" class="flex-1 flex items-center justify-center gap-1.5 p-2.5 rounded-lg bg-blue-500/20 hover:bg-blue-500/30 border border-blue-500/30 text-blue-300 hover:text-blue-200 transition-all duration-200 text-xs sm:text-sm font-medium" title="Ver">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span class="hidden sm:inline">Ver</span>
                            </a>
                            <a href="{{ route('admin.shipping-rates.edit', $rate) }}" class="flex-1 flex items-center justify-center gap-1.5 p-2.5 rounded-lg bg-yellow-500/20 hover:bg-yellow-500/30 border border-yellow-500/30 text-yellow-300 hover:text-yellow-200 transition-all duration-200 text-xs sm:text-sm font-medium" title="Editar">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span class="hidden sm:inline">Editar</span>
                            </a>
                            <button 
                                type="button"
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-shipping-rate-deletion-{{ $rate->id }}')"
                                class="flex-1 flex items-center justify-center gap-1.5 p-2.5 rounded-lg bg-red-500/20 hover:bg-red-500/30 border border-red-500/30 text-red-300 hover:text-red-200 transition-all duration-200 text-xs sm:text-sm font-medium"
                                title="Eliminar"
                            >
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span class="hidden sm:inline">Eliminar</span>
                            </button>
                            
                            {{-- Modal de Confirmación de Eliminación --}}
                            <x-modal name="confirm-shipping-rate-deletion-{{ $rate->id }}" :show="old('delete_rate_id') == $rate->id" focusable>
                                <div class="delete-modal-content">
                                    <div class="delete-modal-icon">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <h2 class="delete-modal-title">
                                        {{ __('¿Eliminar Tarifa de Envío?') }}
                                    </h2>
                                    <p class="delete-modal-message">
                                        {{ __('¿Estás seguro de que deseas eliminar esta tarifa de envío') }} <strong class="capitalize">{{ $rate->method }}</strong>? 
                                        {{ __('Esta acción no se puede deshacer y todos los datos de la tarifa se eliminarán permanentemente.') }}
                                    </p>
                                    <div class="delete-modal-info">
                                        <div class="delete-modal-info-item">
                                            <span class="delete-modal-info-label">ID:</span>
                                            <span class="delete-modal-info-value">{{ $rate->id }}</span>
                                        </div>
                                        <div class="delete-modal-info-item">
                                            <span class="delete-modal-info-label">Método:</span>
                                            <span class="delete-modal-info-value capitalize">{{ $rate->method }}</span>
                                        </div>
                                        <div class="delete-modal-info-item">
                                            <span class="delete-modal-info-label">Estado:</span>
                                            <span class="delete-modal-info-value">
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $rate->is_active ? 'bg-green-500/30 text-green-200' : 'bg-red-500/30 text-red-200' }}">
                                                    {{ $rate->is_active ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('admin.shipping-rates.destroy', $rate) }}" class="delete-modal-form" x-data="{ password: '{{ old('password', '') }}', showPasswordError: false }" x-on:submit.prevent="if(!password) { showPasswordError = true; return false; } $el.submit();">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="delete_rate_id" value="{{ $rate->id }}">
                                        
                                        {{-- Campo de contraseña --}}
                                        <div class="mb-4">
                                            <label for="password-{{ $rate->id }}" class="block text-white/90 text-sm font-medium mb-2">
                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                                Contraseña de Administrador
                                            </label>
                                            <input 
                                                type="password" 
                                                id="password-{{ $rate->id }}" 
                                                name="password" 
                                                x-model="password"
                                                x-on:input="showPasswordError = false"
                                                value="{{ old('password', '') }}"
                                                class="auth-form-input w-full @error('password') border-red-500/50 @enderror" 
                                                placeholder="Ingrese su contraseña para confirmar"
                                                required
                                                autocomplete="current-password"
                                            />
                                            @error('password')
                                                <p class="mt-1 text-xs text-red-400 flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                            <p class="mt-1 text-xs text-white/60">Se requiere su contraseña para confirmar la eliminación</p>
                                        </div>
                                        
                                        <div class="delete-modal-actions">
                                            <button 
                                                type="button"
                                                x-on:click="$dispatch('close-modal', 'confirm-shipping-rate-deletion-{{ $rate->id }}'); password = ''; showPasswordError = false;"
                                                class="delete-modal-button delete-modal-button-cancel"
                                            >
                                                {{ __('Cancelar') }}
                                            </button>
                                            <button 
                                                type="submit"
                                                class="delete-modal-button delete-modal-button-delete"
                                                :disabled="!password"
                                                :class="!password ? 'opacity-50 cursor-not-allowed' : ''"
                                            >
                                                {{ __('Eliminar Tarifa') }}
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
                            @if(request()->hasAny(['search', 'filter_type', 'method', 'status']))
                                <p class="text-white/70 text-lg font-medium">No se encontraron tarifas</p>
                                <p class="text-white/50 text-sm mt-2">Intenta con otros términos de búsqueda o filtros</p>
                                <a href="{{ route('admin.shipping-rates.index') }}" class="inline-block mt-4 glass-button glass-button-sm">
                                    Limpiar búsqueda
                                </a>
                            @else
                                <p class="text-white/70 text-lg font-medium">No hay tarifas de envío registradas</p>
                                <p class="text-white/50 text-sm mt-2">Crea tu primera tarifa para comenzar</p>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            @if($shippingRates->hasPages())
                <div class="mt-6">
                    {{ $shippingRates->links() }}
                </div>
            @endif
        </x-ui.card>
    </x-ui.container>
</x-app-layout>
