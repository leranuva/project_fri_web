<section>
    <header class="mb-6">
        <h2 class="text-xl sm:text-2xl font-semibold text-white mb-2">
            {{ __('Actualizar Contraseña') }}
        </h2>

        <p class="text-sm sm:text-base text-white/80">
            {{ __('Asegúrate de que tu cuenta use una contraseña larga y aleatoria para mantenerla segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Contraseña Actual')" class="text-white/90 mb-2" />
            <x-text-input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="auth-form-input" 
                autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nueva Contraseña')" class="text-white/90 mb-2" />
            <x-text-input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="auth-form-input" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Contraseña')" class="text-white/90 mb-2" />
            <x-text-input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="auth-form-input" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="glass-button">
                {{ __('Guardar') }}
            </button>

            @if (session('status') === 'password-updated')
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
