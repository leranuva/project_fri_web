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

        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            $user->update([
                'avatar' => $googleUser->getAvatar(),
            ]);
        } else {
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                    'password' => null,
                ]);
            }
        }

        Auth::login($user, true);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
