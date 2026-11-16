<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class EmailVerificationDelivery
{
    public function send(User $user): string
    {
        $key = 'verification-mail:'.$user->getKey().':'.sha1($user->getEmailForVerification());

        return RateLimiter::attempt($key, 1, function () use ($user) {
            try {
                $user->sendEmailVerificationNotification();

                return 'verification-link-sent';
            } catch (TransportExceptionInterface) {
                logger()->error('Falló el transporte del correo de verificación.');

                return 'verification-delivery-failed';
            }
        }, 60) ?: 'verification-link-recent';
    }
}
