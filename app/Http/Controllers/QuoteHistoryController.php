<?php

namespace App\Http\Controllers;

use App\Models\Quote;

class QuoteHistoryController extends Controller
{
    /**
     * Mostrar historial de cotizaciones del usuario
     */
    public function index()
    {
        $quotes = Quote::where('user_id', auth()->id())
            ->with('product')
            ->latest()
            ->paginate(15);

        return view('quotes.index', compact('quotes'));
    }
}
