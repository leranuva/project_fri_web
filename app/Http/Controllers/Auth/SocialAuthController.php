<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        if (! config("services.{$provider}.client_id") || ! config("services.{$provider}.client_secret")) {
            return redirect()->route('login')
                ->with('error', __('Este método de inicio de sesión no está configurado.'));
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        if (! config("services.{$provider}.client_id") || ! config("services.{$provider}.client_secret")) {
            return redirect()->route('login')
                ->with('error', __('Este método de inicio de sesión no está configurado.'));
        }

        try {
            $identity = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', __('No se pudo iniciar sesión. Intenta de nuevo.'));
        }

        $email = strtolower(trim((string) $identity->getEmail()));
        $subject = (string) $identity->getId();
        $confirmed = $provider !== 'google' || ($identity->user['verified_email'] ?? false) === true;

        if (! $confirmed || ! filter_var($email, FILTER_VALIDATE_EMAIL) || $subject === '') {
            return redirect()->route('login')
                ->with('error', __('El proveedor no compartió un correo confirmado. Puedes registrarte con tu correo.'));
        }

        $identityColumn = $provider === 'google' ? 'google_id' : 'x_id';
        $user = User::where($identityColumn, $subject)->first();

        if (! $user) {
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $identity->getName() ?: $identity->getNickname() ?: 'Cliente',
                    $identityColumn => $subject,
                    'password' => null,
                ]
            );

            if ((string) $user->{$identityColumn} !== $subject) {
                return redirect()->route('login')
                    ->with('error', __('Usa tu contraseña para iniciar sesión con tu cuenta existente.'));
            }
        }

        $user->avatar = $identity->getAvatar();
        $user->save();

        Auth::login($user, true);

        if (! $user->hasVerifiedEmail()) {
            $status = app(\App\Services\EmailVerificationDelivery::class)->send($user);

            return redirect()->route('verification.notice')->with('status', $status);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
