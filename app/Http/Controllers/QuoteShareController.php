<?php

namespace App\Http\Controllers;

use App\Models\QuoteShare;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuoteShareController extends Controller
{
    /**
     * Crear enlace compartible (Fase 13.2)
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->validate(['shareToken' => 'required|string|max:8192']);

        try {
            $payload = json_decode(Crypt::decryptString($input['shareToken']), true);
        } catch (DecryptException) {
            abort(422, 'La cotización no es válida.');
        }

        abort_unless(
            ($payload['purpose'] ?? null) === 'quote-share'
                && ($payload['expires'] ?? 0) >= now()->timestamp && is_array($payload['quote'] ?? null),
            422,
            'Vuelve a calcular la cotización para compartirla.'
        );

        $token = QuoteShare::generateToken();
        $expiresAt = now()->addDays(30);

        QuoteShare::create([
            'token' => $token,
            'quote_data' => $payload['quote'],
            'expires_at' => $expiresAt,
        ]);

        return response()->json([
            'success' => true,
            'url' => route('quote.show', $token),
            'token' => $token,
        ]);
    }

    /**
     * Mostrar cotización compartida (Fase 13.2)
     */
    public function show(string $token): View|JsonResponse
    {
        $share = QuoteShare::where('token', $token)->first();

        if (!$share || $share->isExpired()) {
            abort(404, 'Cotización no encontrada o expirada.');
        }

        $share->incrementViews();

        return view('quote.share', [
            'share' => $share,
            'quoteData' => array_filter($share->quote_data ?? [], 'is_scalar'),
            'serverCalculated' => str_starts_with($share->token, 'v2_'),
        ]);
    }
}
