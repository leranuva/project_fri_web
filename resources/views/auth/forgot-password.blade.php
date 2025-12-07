<x-guest-layout>
    <div class="auth-form-container">
        <x-ui.card glassmorphism="true" padding="lg" rounded="true" class="auth-card">
            {{-- Header --}}
            <div class="auth-form-header">
                <h1 class="auth-form-title">¿Olvidaste tu contraseña?</h1>
                <p class="auth-form-subtitle">No te preocupes, te enviaremos un enlace para restablecerla</p>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="auth-success mb-4">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('password.email') }}">
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

                {{-- Actions --}}
                <div class="flex flex-col gap-4">
                    <button type="submit" class="auth-form-button">
                        {{ __('Enviar Enlace de Reseteo') }}
                    </button>
                </div>
            </form>

            {{-- Back to Login Link --}}
            <div class="mt-6 text-center">
                <p class="text-sm text-white/80">
                    {{ __('¿Recordaste tu contraseña?') }}
                    <a href="{{ route('login') }}" class="auth-form-link font-semibold">
                        {{ __('Volver al inicio de sesión') }}
                    </a>
                </p>
            </div>
        </x-ui.card>
    </div>
</x-guest-layout>
