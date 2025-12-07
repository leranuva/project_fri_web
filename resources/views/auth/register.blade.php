<x-guest-layout>
    <div class="auth-form-container">
        <x-ui.card glassmorphism="true" padding="lg" rounded="true" class="auth-card">
            {{-- Header --}}
            <div class="auth-form-header">
                <h1 class="auth-form-title">Crear Cuenta</h1>
                <p class="auth-form-subtitle">Únete a Flat Rate Imports hoy</p>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="auth-form-group">
                    <label for="name" class="auth-form-label">
                        {{ __('Nombre Completo') }}
                    </label>
                    <input 
                        id="name" 
                        class="auth-form-input" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="Juan Pérez"
                        required 
                        autofocus 
                        autocomplete="name"
                    />
                    @error('name')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email Address --}}
                <div class="auth-form-group">
                    <label for="email" class="auth-form-label">
                        {{ __('Correo Electrónico') }}
                    </label>
                    <input 
                        id="email" 
                        class="auth-form-input" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="tu@email.com"
                        required 
                        autocomplete="username"
                    />
                    @error('email')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="auth-form-group">
                    <label for="password" class="auth-form-label">
                        {{ __('Contraseña') }}
                    </label>
                    <input 
                        id="password" 
                        class="auth-form-input"
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        required 
                        autocomplete="new-password"
                    />
                    @error('password')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="auth-form-group">
                    <label for="password_confirmation" class="auth-form-label">
                        {{ __('Confirmar Contraseña') }}
                    </label>
                    <input 
                        id="password_confirmation" 
                        class="auth-form-input"
                        type="password"
                        name="password_confirmation" 
                        placeholder="••••••••"
                        required 
                        autocomplete="new-password"
                    />
                </div>

                {{-- Actions --}}
                <div class="flex flex-col gap-4">
                    <button type="submit" class="auth-form-button">
                        {{ __('Registrarse') }}
                    </button>
                </div>
            </form>

            {{-- Login Link --}}
            <div class="mt-6 text-center">
                <p class="text-sm text-white/80">
                    {{ __('¿Ya tienes una cuenta?') }}
                    <a href="{{ route('login') }}" class="auth-form-link font-semibold">
                        {{ __('Inicia sesión aquí') }}
                    </a>
                </p>
            </div>
        </x-ui.card>
    </div>
</x-guest-layout>
