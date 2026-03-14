<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CalculatorController extends Controller
{
    /**
     * Calculadoras virales (Fase 13.1) - páginas SEO con cotizador embebido
     */
    public function aranceles(): View
    {
        return view('calculators.show', [
            'slug' => 'calculadora-aranceles',
            'title' => 'Calculadora de Aranceles Ecuador 2026',
            'description' => 'Calcula los aranceles e impuestos para importar a Ecuador. Incluye ad-valorem, Fodinfa, IVA y arancel específico. Herramienta gratuita.',
            'embedUrl' => route('cotizador'),
        ]);
    }

    public function courier4x4(): View
    {
        return view('calculators.show', [
            'slug' => 'calculadora-courier-4x4',
            'title' => 'Calculadora Courier 4x4 Ecuador',
            'description' => 'Calcula el costo de envío con Courier 4x4. Ideal para paquetes hasta 4kg y $400 FOB. Arancel fijo de $20. Envío rápido a Ecuador.',
            'embedUrl' => route('cotizador', ['shipping' => 'courier4x4']),
        ]);
    }

    public function amazonEcuador(): View
    {
        return view('calculators.show', [
            'slug' => 'calculadora-amazon-ecuador',
            'title' => 'Calculadora Amazon a Ecuador - Costo de Importación',
            'description' => 'Calcula cuánto cuesta importar desde Amazon USA a Ecuador. Incluye envío, impuestos, aranceles y costo total. Cotización instantánea.',
            'embedUrl' => route('cotizador'),
        ]);
    }
}
