<section>
    <header class="mb-6">
        <h2 class="text-xl sm:text-2xl font-semibold text-white mb-2">
            {{ __('Información del Perfil') }}
        </h2>

        <p class="text-sm sm:text-base text-white/80">
            {{ __('Actualiza la información de tu perfil y dirección de correo electrónico.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nombre')" class="text-white/90 mb-2" />
            <x-text-input 
                id="name" 
                name="name" 
                type="text" 
                class="auth-form-input" 
                :value="old('name', $user->name)" 
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

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
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-yellow-500/20 border border-yellow-500/30 rounded-lg">
                    <p class="text-sm text-white/90">
                        {{ __('Tu dirección de correo electrónico no está verificada.') }}

                        <button form="send-verification" class="underline text-sm text-yellow-200 hover:text-yellow-100 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400/50">
                            {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-300">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="glass-button">
                {{ __('Guardar') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-300 font-medium"
                >{{ __('✓ Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>
