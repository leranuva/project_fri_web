<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Crear Nuevo Usuario') }}
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
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                    Crear Nuevo Usuario
                </h1>
                <p class="text-xs sm:text-sm md:text-base text-white/80">
                    Completa el formulario para crear un nuevo usuario en el sistema.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                @csrf

                {{-- Nombre --}}
                <div>
                    <x-input-label for="name" :value="__('Nombre Completo')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="name" 
                        name="name" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('name')" 
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
                        :value="old('email')" 
                        required 
                        autocomplete="username" 
                        placeholder="usuario@ejemplo.com"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                {{-- Contraseña --}}
                <div>
                    <x-input-label for="password" :value="__('Contraseña')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="password" 
                        name="password" 
                        type="password" 
                        class="auth-form-input" 
                        required 
                        autocomplete="new-password" 
                        placeholder="Mínimo 8 caracteres"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                </div>

                {{-- Confirmar Contraseña --}}
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        class="auth-form-input" 
                        required 
                        autocomplete="new-password" 
                        placeholder="Confirme la contraseña"
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
                        <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Cliente</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('role')" />
                </div>

                {{-- Botones de Acción --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 pt-4 border-t border-white/10">
                    <button type="submit" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs sm:text-sm md:text-base">Crear Usuario</span>
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="glass-button glass-button-sm sm:glass-button w-full sm:w-auto flex items-center justify-center" style="background: rgba(255, 255, 255, 0.1);">
                        <span class="text-xs sm:text-sm md:text-base">Cancelar</span>
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>

