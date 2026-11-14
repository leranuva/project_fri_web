<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public static function enabled(string $provider): bool
    {
        if (blank(config("services.{$provider}.client_id"))) {
            return false;
        }

        if ($provider === 'apple') {
            $key = config('services.apple.private_key');

            return filled(config('services.apple.team_id')) && filled(config('services.apple.key_id'))
                && is_string($key) && is_file($key) && is_readable($key);
        }

        return filled(config("services.{$provider}.client_secret"));
    }

    private function driver(string $provider)
    {
        $driver = Socialite::driver($provider);

        return $provider === 'apple' ? $driver->stateless()->cookieNonce() : $driver;
    }

    public function redirect(string $provider)
    {
        if (! self::enabled($provider)) {
            return redirect()->route('login')
                ->with('error', __('Este método de inicio de sesión no está configurado.'));
        }

        return $this->driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        if (! self::enabled($provider)) {
            return redirect()->route('login')
                ->with('error', __('Este método de inicio de sesión no está configurado.'));
        }

        try {
            $identity = $this->driver($provider)->user();
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

        $identityColumn = match ($provider) {
            'google' => 'google_id',
            'twitter' => 'x_id',
            'apple' => 'apple_id',
            'facebook' => 'facebook_id',
        };
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

        if ($identity->getAvatar()) {
            $user->avatar = $identity->getAvatar();
            $user->save();
        }

        Auth::login($user, true);

        if (! $user->hasVerifiedEmail()) {
            $status = app(\App\Services\EmailVerificationDelivery::class)->send($user);

            return redirect()->route('verification.notice')->with('status', $status);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
