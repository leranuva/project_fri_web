<x-guest-layout>
    <div class="auth-form-container">
        <x-ui.card glassmorphism="true" padding="lg" rounded="true" class="auth-card">
            {{-- Header --}}
            <div class="auth-form-header">
                <h1 class="auth-form-title">Crear Cuenta</h1>
                <p class="auth-form-subtitle">Únete a Flat Rate Imports hoy</p>
            </div>

            @if (session('error'))
                <div class="auth-error mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if (config('services.google.client_id'))
                <a href="{{ route('auth.google.redirect') }}" class="auth-form-google-button">
                    <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    {{ __('Continuar con Google') }}
                </a>
                <div class="auth-form-divider">
                    <span>{{ __('o regístrate con tu correo') }}</span>
                </div>
            @endif

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
