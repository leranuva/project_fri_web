<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Administración de Impuestos') }}
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
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                        Gestión de Impuestos
                    </h1>
                    <p class="text-sm sm:text-base text-white/80">
                        Administra los impuestos del sistema
                    </p>
                </div>
                <a href="{{ route('admin.tax-rates.create') }}" class="glass-button">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nuevo Impuesto
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20">
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">ID</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Nombre</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Etiqueta</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Tasa</th>
                            <th class="text-left py-3 px-4 text-white/80 font-semibold text-sm">Estado</th>
                            <th class="text-right py-3 px-4 text-white/80 font-semibold text-sm">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($taxRates as $tax)
                            <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                                <td class="py-3 px-4 text-white/90">{{ $tax->id }}</td>
                                <td class="py-3 px-4 text-white/90">{{ $tax->name }}</td>
                                <td class="py-3 px-4 text-white/90">{{ $tax->label }}</td>
                                <td class="py-3 px-4 text-white/90">{{ number_format($tax->rate * 100, 2) }}%</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $tax->is_active ? 'bg-green-500/30 text-green-200' : 'bg-red-500/30 text-red-200' }}">
                                        {{ $tax->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.tax-rates.show', $tax) }}" class="p-2 rounded-lg bg-blue-500/20 hover:bg-blue-500/30 border border-blue-500/30 text-blue-300 hover:text-blue-200 transition-all duration-200" title="Ver">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.tax-rates.edit', $tax) }}" class="p-2 rounded-lg bg-yellow-500/20 hover:bg-yellow-500/30 border border-yellow-500/30 text-yellow-300 hover:text-yellow-200 transition-all duration-200" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button 
                                            type="button"
                                            x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-tax-rate-deletion-{{ $tax->id }}')"
                                            class="p-2 rounded-lg bg-red-500/20 hover:bg-red-500/30 border border-red-500/30 text-red-300 hover:text-red-200 transition-all duration-200"
                                            title="Eliminar"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                        
                                        {{-- Modal de Confirmación de Eliminación --}}
                                        <x-modal name="confirm-tax-rate-deletion-{{ $tax->id }}" :show="old('delete_tax_rate_id') == $tax->id" focusable>
                                            <div class="delete-modal-content">
                                                <div class="delete-modal-icon">
                                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                </div>
                                                <h2 class="delete-modal-title">
                                                    {{ __('¿Eliminar Impuesto?') }}
                                                </h2>
                                                <p class="delete-modal-message">
                                                    {{ __('¿Estás seguro de que deseas eliminar el impuesto') }} <strong>{{ $tax->label }}</strong>? 
                                                    {{ __('Esta acción no se puede deshacer y todos los datos del impuesto se eliminarán permanentemente.') }}
                                                </p>
                                                <div class="delete-modal-info">
                                                    <div class="delete-modal-info-item">
                                                        <span class="delete-modal-info-label">ID:</span>
                                                        <span class="delete-modal-info-value">{{ $tax->id }}</span>
                                                    </div>
                                                    <div class="delete-modal-info-item">
                                                        <span class="delete-modal-info-label">Nombre:</span>
                                                        <span class="delete-modal-info-value">{{ $tax->name }}</span>
                                                    </div>
                                                    <div class="delete-modal-info-item">
                                                        <span class="delete-modal-info-label">Etiqueta:</span>
                                                        <span class="delete-modal-info-value">{{ $tax->label }}</span>
                                                    </div>
                                                    <div class="delete-modal-info-item">
                                                        <span class="delete-modal-info-label">Tasa:</span>
                                                        <span class="delete-modal-info-value">{{ number_format($tax->rate * 100, 2) }}%</span>
                                                    </div>
                                                    <div class="delete-modal-info-item">
                                                        <span class="delete-modal-info-label">Estado:</span>
                                                        <span class="delete-modal-info-value">
                                                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $tax->is_active ? 'bg-green-500/30 text-green-200' : 'bg-red-500/30 text-red-200' }}">
                                                                {{ $tax->is_active ? 'Activo' : 'Inactivo' }}
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <form method="POST" action="{{ route('admin.tax-rates.destroy', $tax) }}" class="delete-modal-form" x-data="{ password: '{{ old('password', '') }}', showPasswordError: false }" x-on:submit.prevent="if(!password) { showPasswordError = true; return false; } $el.submit();">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="delete_tax_rate_id" value="{{ $tax->id }}">
                                                    
                                                    {{-- Campo de contraseña --}}
                                                    <div class="mb-4">
                                                        <label for="password-{{ $tax->id }}" class="block text-white/90 text-sm font-medium mb-2">
                                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                            </svg>
                                                            Contraseña de Administrador
                                                        </label>
                                                        <input 
                                                            type="password" 
                                                            id="password-{{ $tax->id }}" 
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
                                                            x-on:click="$dispatch('close-modal', 'confirm-tax-rate-deletion-{{ $tax->id }}'); password = ''; showPasswordError = false;"
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
                                                            {{ __('Eliminar Impuesto') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </x-modal>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-white/70">
                                    No hay impuestos registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($taxRates->hasPages())
                <div class="mt-6">
                    {{ $taxRates->links() }}
                </div>
            @endif
        </x-ui.card>
    </x-ui.container>
</x-app-layout>

