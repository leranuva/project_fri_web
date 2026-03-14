<?php

namespace App\Listeners;

use App\Mail\WelcomeEmail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        // Enviar correo de bienvenida cuando el usuario verifica su email
        try {
            Mail::to($event->user->email)->send(new WelcomeEmail($event->user));
        } catch (\Exception $e) {
            // Log el error pero no interrumpir el flujo de verificación
            \Log::error('Error enviando correo de bienvenida: ' . $e->getMessage());
        }
    }
}
