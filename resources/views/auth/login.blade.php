<x-guest-layout>
    <div class="auth-form-container">
        <x-ui.card glassmorphism="true" padding="lg" rounded="true" class="auth-card">
            {{-- Header --}}
            <div class="auth-form-header">
                <h1 class="auth-form-title">Iniciar Sesión</h1>
                <p class="auth-form-subtitle">Bienvenido de nuevo a Flat Rate Imports</p>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="auth-success">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

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
                        autofocus 
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
                        autocomplete="current-password"
                    />
                    @error('password')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="auth-form-checkbox">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        name="remember"
                    >
                    <label for="remember_me">
                        {{ __('Recordarme') }}
                    </label>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col gap-4">
                    @if (Route::has('password.request'))
                        <a 
                            class="auth-form-link text-center" 
                            href="{{ route('password.request') }}"
                        >
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif

                    <button type="submit" class="auth-form-button">
                        {{ __('Iniciar Sesión') }}
                    </button>
                </div>
            </form>

            {{-- Register Link --}}
            <div class="mt-6 text-center">
                <p class="text-sm text-white/80">
                    {{ __('¿No tienes una cuenta?') }}
                    <a href="{{ route('register') }}" class="auth-form-link font-semibold">
                        {{ __('Regístrate aquí') }}
                    </a>
                </p>
            </div>
        </x-ui.card>
    </div>
</x-guest-layout>
