<x-guest-layout seo-title="Seguimiento de paquetes | Flat Rate Imports">
    <x-ui.container>
        <div class="max-w-4xl mx-auto py-8 sm:py-12">
            <x-ui.card glassmorphism="true" padding="lg">
                <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">Seguimiento de paquetes</h1>
                <p class="text-white/80 mb-6">Consulta el último estado disponible con tu número de seguimiento.</p>

                @if (session('tracking_error'))
                    <p role="alert" class="text-white mb-4">{{ session('tracking_error') }}</p>
                @endif

                <form method="POST" action="{{ route('tracking.search') }}" class="space-y-4">
                    @csrf
                    <label for="tracking_number" class="block text-white font-medium">Número de seguimiento</label>
                    <input id="tracking_number" name="tracking_number" type="text" class="auth-form-input w-full"
                        value="{{ old('tracking_number') }}" required minlength="3" maxlength="100"
                        autocomplete="off" autocapitalize="characters" spellcheck="false">
                    <x-input-error :messages="$errors->get('tracking_number')" />
                    <button type="submit" class="auth-form-button">Rastrear paquete</button>
                </form>
            </x-ui.card>
        </div>
    </x-ui.container>
</x-guest-layout>
