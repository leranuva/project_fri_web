<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', "regex:/\A[\p{L}\p{M}][\p{L}\p{M} .’'\-]*\z/u"],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.regex' => 'Escribe un nombre sin enlaces ni etiquetas HTML.',
        ]);

        $this->verifyTurnstile($request);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Laravel envía automáticamente el correo de verificación cuando se dispara el evento Registered
        // No es necesario llamar sendEmailVerificationNotification() manualmente
        
        // Redirigir a verificación de email si no está verificado
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect(route('dashboard', absolute: false));
    }
    private function verifyTurnstile(Request $request): void
    {
        $siteKey = config('services.turnstile.site_key');
        $secret = config('services.turnstile.secret_key');

        if (blank($siteKey) && blank($secret)) {
            return;
        }

        $token = $request->validate([
            'cf-turnstile-response' => ['required', 'string', 'max:2048'],
        ], [
            'cf-turnstile-response.required' => 'Completa la verificación de seguridad.',
        ])['cf-turnstile-response'];

        if (filled($siteKey) && filled($secret)) {
            try {
                $response = Http::asForm()->connectTimeout(3)->timeout(6)
                    ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                        'secret' => $secret,
                        'response' => $token,
                    ]);

                if ($response->successful()
                    && $response->json('success') === true
                    && $response->json('action') === 'register'
                    && $response->json('hostname') === parse_url(config('app.url'), PHP_URL_HOST)) {
                    return;
                }
            } catch (ConnectionException) {
                // Return a validation error so the visitor can retry.
            }
        }

        throw ValidationException::withMessages([
            'cf-turnstile-response' => 'No se pudo validar la verificación de seguridad. Inténtalo de nuevo.',
        ]);
    }
}
