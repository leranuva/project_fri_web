<?php

namespace App\Http\Controllers;

use App\Models\Quote;

class PaymentController extends Controller
{
    /**
     * Mostrar página de pago para una cotización
     * Estructura preparada para integración con Stripe/PayPal
     */
    public function show(Quote $quote)
    {
        $this->authorize('view', $quote);

        return view('payments.show', [
            'quote' => $quote,
        ]);
    }

    /**
     * Procesar pago (placeholder - requiere integración)
     */
    public function process(Quote $quote)
    {
        $this->authorize('view', $quote);

        return redirect()
            ->route('payments.show', $quote)
            ->with('info', 'Integración de pago en desarrollo. Configure Stripe o PayPal en config/services.php.');
    }
}
