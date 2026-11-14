<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function redirect(Request $request, string $provider)
    {
        if (! self::enabled($provider)) {
            return redirect()->route('login')
                ->with('error', __('Este método de inicio de sesión no está configurado.'));
        }

        if ($provider === 'google') {
            $request->session()->forget('google_link_user');
        }

        return $this->driver($provider)->redirect();
    }

    public function linkGoogle(Request $request)
    {
        abort_unless(self::enabled('google'), 404);

        $request->session()->put('google_link_user', $request->user()->getAuthIdentifier());

        return $this->driver('google')->redirect();
    }

    public function callback(Request $request, string $provider)
    {
        $account = $request->user();
        $linkUserId = $provider === 'google' ? $request->session()->pull('google_link_user') : null;

        if ($linkUserId !== null && ! $account) {
            return redirect()->route('login');
        }

        if ($account && ($linkUserId !== $account->getAuthIdentifier() || ! $account->hasVerifiedEmail())) {
            return redirect()->route('profile.edit');
        }

        $returnRoute = $account ? 'profile.edit' : 'login';

        if (! self::enabled($provider)) {
            return redirect()->route($returnRoute)
                ->with('error', __('Este método de inicio de sesión no está configurado.'));
        }

        try {
            $identity = $this->driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route($returnRoute)
                ->with('error', __('No se pudo iniciar sesión. Intenta de nuevo.'));
        }

        $email = strtolower(trim((string) $identity->getEmail()));
        $subject = (string) $identity->getId();
        $confirmed = $provider !== 'google' || ($identity->user['verified_email'] ?? false) === true;

        if (! $confirmed || ! filter_var($email, FILTER_VALIDATE_EMAIL) || $subject === '') {
            return redirect()->route($returnRoute)
                ->with('error', __('El proveedor no compartió un correo confirmado. Puedes registrarte con tu correo.'));
        }

        if ($account) {
            if (strcasecmp($account->email, $email) !== 0) {
                return redirect()->route('profile.edit')->with('error', 'Elige en Google el mismo correo que tienes verificado en tu perfil.');
            }

            try {
                User::whereKey($account->getKey())
                    ->where('email', $account->email)
                    ->whereNotNull('email_verified_at')
                    ->whereNull('google_id')
                    ->update(['google_id' => $subject]);
            } catch (\Illuminate\Database\UniqueConstraintViolationException) {
                return redirect()->route('profile.edit')->with('error', 'Esta cuenta de Google ya está vinculada.');
            }

            if ($account->fresh()?->google_id !== $subject) {
                return redirect()->route('profile.edit')->with('error', 'Tu perfil ya tiene vinculada otra cuenta de Google.');
            }

            return redirect()->route('profile.edit')->with('status', 'google-linked');
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

            if ($provider === 'google' && $user->google_id === null && str_ends_with($email, '@gmail.com')) {
                User::whereKey($user->getKey())
                    ->where('email', $email)
                    ->where('role', 'customer')
                    ->whereNotNull('email_verified_at')
                    ->whereNull('google_id')
                    ->update(['google_id' => $subject]);

                $user->refresh();
            }

            if ((string) $user->{$identityColumn} !== $subject) {
                return redirect()->route('login')
                    ->with('error', $provider === 'google'
                        ? __('Entra una vez con tu contraseña y elige Vincular Google en tu perfil.')
                        : __('Usa tu contraseña para iniciar sesión con tu cuenta existente.'));
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
