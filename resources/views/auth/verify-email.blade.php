<x-guest-layout>
    <x-ui.card glassmorphism="true" padding="lg" class="w-full max-w-md mx-auto">
        <div class="text-center mb-6">
            <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-br from-blue-500/30 to-blue-600/20 backdrop-blur-sm border border-white/20 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-white mb-2">Verifica tu Email</h2>
            <p class="text-sm sm:text-base text-white/80">
                ¡Gracias por registrarte! Antes de comenzar, por favor verifica tu dirección de correo electrónico haciendo clic en el enlace que acabamos de enviarte.
            </p>
    </div>

    @if (session('status') == 'verification-link-sent')
            <div class="mb-4 sm:mb-6 p-4 rounded-lg bg-green-500/20 border border-green-500/30">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="font-medium text-sm sm:text-base text-green-200">
                        Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.
                    </p>
                </div>
        </div>
    @endif

        <div class="mb-4 p-4 rounded-lg bg-white/10 border border-white/20">
            <p class="text-sm text-white/70 mb-2">
                <strong>Email registrado:</strong>
            </p>
            <p class="text-base font-medium text-white">
                {{ Auth::user()->email }}
            </p>
        </div>

        <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
                <x-ui.button type="submit" variant="primary" full-width class="w-full">
                    <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Reenviar Email de Verificación
                </x-ui.button>
        </form>

            <div class="text-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button 
                type="submit" 
                        class="text-sm text-white/70 hover:text-white underline transition-colors"
            >
                        Cerrar Sesión
            </button>
        </form>
    </div>

            <div class="pt-4 border-t border-white/10">
                <p class="text-xs text-white/60 text-center">
                    ¿No recibiste el email? Revisa tu carpeta de spam o solicita un nuevo enlace de verificación.
                </p>
            </div>
        </div>
    </x-ui.card>
</x-guest-layout>
