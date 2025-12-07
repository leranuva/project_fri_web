<section class="space-y-6">
    <header class="mb-6">
        <h2 class="text-xl sm:text-2xl font-semibold text-white mb-2">
            {{ __('Eliminar Cuenta') }}
        </h2>

        <p class="text-sm sm:text-base text-white/80">
            {{ __('Una vez que elimines tu cuenta, todos sus recursos y datos se eliminarán permanentemente. Antes de eliminar tu cuenta, descarga cualquier dato o información que desees conservar.') }}
        </p>
    </header>

    <button
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="glass-button logout-button"
    >
        {{ __('Eliminar Cuenta') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg sm:text-xl font-semibold text-white mb-3">
                {{ __('¿Estás seguro de que deseas eliminar tu cuenta?') }}
            </h2>

            <p class="mt-2 text-sm text-white/80 mb-6">
                {{ __('Una vez que elimines tu cuenta, todos sus recursos y datos se eliminarán permanentemente. Por favor, ingresa tu contraseña para confirmar que deseas eliminar permanentemente tu cuenta.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Contraseña') }}" class="text-white/90 mb-2" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="auth-form-input w-full"
                    placeholder="{{ __('Ingresa tu contraseña') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button 
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="glass-button"
                >
                    {{ __('Cancelar') }}
                </button>

                <button 
                    type="submit"
                    class="glass-button logout-button"
                >
                    {{ __('Eliminar Cuenta') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
