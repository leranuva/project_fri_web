<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Perfil de Usuario') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <div class="py-6 sm:py-8 space-y-6 sm:space-y-8">
            {{-- Información del Perfil --}}
            <x-ui.card glassmorphism="true" padding="lg" class="profile-card">
                <div class="max-w-2xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </x-ui.card>

            {{-- Actualizar Contraseña --}}
            <x-ui.card glassmorphism="true" padding="lg" class="profile-card">
                <div class="max-w-2xl">
                    @include('profile.partials.update-password-form')
                </div>
            </x-ui.card>

            {{-- Eliminar Cuenta --}}
            <x-ui.card glassmorphism="true" padding="lg" class="profile-card">
                <div class="max-w-2xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </x-ui.card>
        </div>
    </x-ui.container>
</x-app-layout>
