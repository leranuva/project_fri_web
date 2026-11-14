<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirige al usuario a la pantalla de autenticación de Google.
     */
    public function redirect()
    {
        if (! config('services.google.client_id')) {
            return redirect()->route('login')
                ->with('error', __('El inicio de sesión con Google no está configurado.'));
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Maneja el callback de Google tras la autenticación.
     */
    public function callback()
    {
        if (! config('services.google.client_id')) {
            return redirect()->route('login')
                ->with('error', __('El inicio de sesión con Google no está configurado.'));
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', __('No se pudo iniciar sesión con Google. Intenta de nuevo.'));
        }

        if (($googleUser->user['verified_email'] ?? false) !== true || ! $googleUser->getEmail() || ! $googleUser->getId()) {
            return redirect()->route('login')
                ->with('error', __('Google no confirmó el correo de esta cuenta.'));
        }

        $user = User::where('google_id', $googleUser->getId())->first();

        if (! $user) {
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => null,
                ]
            );

            if ((string) $user->google_id !== (string) $googleUser->getId()) {
                return redirect()->route('login')
                    ->with('error', __('Usa tu contraseña para iniciar sesión con tu cuenta existente.'));
            }
        }

        $user->avatar = $googleUser->getAvatar();
        $user->save();

        Auth::login($user, true);

        if (! $user->hasVerifiedEmail()) {
            $status = app(\App\Services\EmailVerificationDelivery::class)->send($user);

            return redirect()->route('verification.notice')->with('status', $status);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
