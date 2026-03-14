<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcessSection;
use Illuminate\Http\Request;

class ProcessSectionController extends Controller
{
    /**
     * Display the process section configuration.
     */
    public function index()
    {
        $processSection = ProcessSection::first();
        
        // Si no existe, crear uno por defecto
        if (!$processSection) {
            $processSection = ProcessSection::create([
                'title' => '¿CÓMO FUNCIONA FLAT RATE IMPORTS?',
                'subtitle' => 'El proceso es fácil: compras, alertas en tu panel de usuario, recibimos en la casilla, importamos.',
                'footer_text' => 'FLAT RATE IMPORTS tiene más de 10 años en el mercado, ofreciendo seguridad y rapidez en tus entregas.',
                'button_text' => 'Más Información',
                'button_link' => '/cotizador',
                'is_active' => true,
            ]);
        }
        
        return view('admin.process-sections.edit', compact('processSection'));
    }

    /**
     * Update the process section configuration.
     */
    public function update(Request $request, string $id)
    {
        $processSection = ProcessSection::findOrFail($id);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'footer_text' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $processSection->title = $validated['title'];
        $processSection->subtitle = $validated['subtitle'] ?? null;
        $processSection->footer_text = $validated['footer_text'] ?? null;
        $processSection->button_text = $validated['button_text'] ?? null;
        $processSection->button_link = $validated['button_link'] ?? null;
        $processSection->is_active = $validated['is_active'] ?? true;
        
        $processSection->save();

        return redirect()->route('admin.process-sections.index')
            ->with('success', 'Configuración de la sección actualizada exitosamente.');
    }
}
