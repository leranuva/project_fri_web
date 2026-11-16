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

            @if (\App\Http\Controllers\Auth\SocialAuthController::enabled('google'))
                <x-ui.card glassmorphism="true" padding="lg" class="profile-card">
                    <h2 class="text-lg font-semibold text-white">Cuenta de Google</h2>
                    @if (session('error'))
                        <p role="alert" class="mt-2 text-red-200">{{ session('error') }}</p>
                    @endif
                    @if ($user->google_id)
                        <p class="mt-2 text-white">Tu cuenta de Google está vinculada.</p>
                    @else
                        <a href="{{ route('profile.google.link') }}" class="auth-form-google-button mt-3">
                            Vincular Google
                        </a>
                    @endif
                </x-ui.card>
            @endif

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
