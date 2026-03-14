<?php

namespace App\Http\Controllers;

use App\Models\QuoteShare;
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
        $request->validate([
            'quoteData' => 'required|array',
            'quoteData.productName' => 'required|string',
            'quoteData.totalCotizacion' => 'required|numeric',
        ]);

        $token = QuoteShare::generateToken();
        $expiresAt = now()->addDays(30);

        QuoteShare::create([
            'token' => $token,
            'quote_data' => $request->input('quoteData'),
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
            'quoteData' => $share->quote_data,
        ]);
    }
}
