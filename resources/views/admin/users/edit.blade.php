<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Usuarios
                </a>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                            Editar Usuario
                        </h1>
                        <p class="text-xs sm:text-sm md:text-base text-white/80 truncate">
                            Modifica la información del usuario: {{ $user->name }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <a href="{{ route('admin.users.show', $user) }}" class="glass-button glass-button-sm w-full sm:w-auto flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span class="text-xs sm:text-sm md:text-base">Ver Detalles</span>
                        </a>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Nombre --}}
                <div>
                    <x-input-label for="name" :value="__('Nombre Completo')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="name" 
                        name="name" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('name', $user->name)" 
                        required 
                        autofocus 
                        autocomplete="name" 
                        placeholder="Ingrese el nombre completo"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Correo Electrónico')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="email" 
                        name="email" 
                        type="email" 
                        class="auth-form-input" 
                        :value="old('email', $user->email)" 
                        required 
                        autocomplete="username" 
                        placeholder="usuario@ejemplo.com"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    @if($user->email_verified_at)
                        <p class="mt-2 text-sm text-green-300 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Email verificado
                        </p>
                    @else
                        <p class="mt-2 text-sm text-yellow-300 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Email no verificado
                        </p>
                    @endif
                </div>

                {{-- Contraseña --}}
                <div>
                    <x-input-label for="password" :value="__('Nueva Contraseña')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="password" 
                        name="password" 
                        type="password" 
                        class="auth-form-input" 
                        autocomplete="new-password" 
                        placeholder="Dejar en blanco para mantener la actual"
                    />
                    <p class="mt-1 text-xs text-white/60">Deja este campo en blanco si no deseas cambiar la contraseña</p>
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                </div>

                {{-- Confirmar Contraseña --}}
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmar Nueva Contraseña')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        class="auth-form-input" 
                        autocomplete="new-password" 
                        placeholder="Confirme la nueva contraseña"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                </div>

                {{-- Rol --}}
                <div>
                    <x-input-label for="role" :value="__('Rol')" class="text-white/90 mb-2" />
                    <select 
                        id="role" 
                        name="role" 
                        class="auth-form-input" 
                        required
                    >
                        <option value="">Seleccione un rol</option>
                        <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Cliente</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('role')" />
                </div>

                {{-- Información adicional --}}
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <h3 class="text-sm font-semibold text-white/90 mb-3">Información del Usuario</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-white/70">ID:</p>
                            <p class="text-white font-medium">{{ $user->id }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Creado:</p>
                            <p class="text-white font-medium">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Última actualización:</p>
                            <p class="text-white font-medium">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-white/70">Email verificado:</p>
                            <p class="text-white font-medium">
                                @if($user->email_verified_at)
                                    <span class="text-green-300">Sí ({{ $user->email_verified_at->format('d/m/Y') }})</span>
                                @else
                                    <span class="text-yellow-300">No</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 pt-4 border-t border-white/10">
                    <button type="submit" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs sm:text-sm md:text-base">Guardar Cambios</span>
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>

