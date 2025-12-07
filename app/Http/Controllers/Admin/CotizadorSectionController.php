<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CotizadorSection;
use Illuminate\Http\Request;

class CotizadorSectionController extends Controller
{
    /**
     * Display the cotizador section configuration.
     */
    public function index()
    {
        $cotizadorSection = CotizadorSection::first();
        
        // Si no existe, crear uno por defecto
        if (!$cotizadorSection) {
            $cotizadorSection = CotizadorSection::create([
                'title' => 'Cotizador de Importaciones',
                'description' => 'Completa el formulario para obtener una cotización personalizada de tus importaciones.',
                'title_color' => '#ffffff',
                'section_title_color' => '#ffffff',
                'product_label_color' => '#ffffff',
                'quantity_label_color' => '#ffffff',
                'weight_label_color' => '#ffffff',
                'unit_value_label_color' => '#ffffff',
                'shipping_method_label_color' => '#ffffff',
                'is_active' => true,
            ]);
        }
        
        return view('admin.cotizador-sections.edit', compact('cotizadorSection'));
    }

    /**
     * Update the cotizador section configuration.
     */
    public function update(Request $request, string $id)
    {
        $cotizadorSection = CotizadorSection::findOrFail($id);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'title_color' => ['nullable', 'string'],
            'section_title_color' => ['nullable', 'string'],
            'product_label_color' => ['nullable', 'string'],
            'quantity_label_color' => ['nullable', 'string'],
            'weight_label_color' => ['nullable', 'string'],
            'unit_value_label_color' => ['nullable', 'string'],
            'shipping_method_label_color' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'El título es obligatorio.',
        ]);

        $cotizadorSection->title = $validated['title'];
        $cotizadorSection->description = $validated['description'] ?? null;
        $cotizadorSection->title_color = $validated['title_color'] ?? '#ffffff';
        $cotizadorSection->section_title_color = $validated['section_title_color'] ?? '#ffffff';
        $cotizadorSection->product_label_color = $validated['product_label_color'] ?? '#ffffff';
        $cotizadorSection->quantity_label_color = $validated['quantity_label_color'] ?? '#ffffff';
        $cotizadorSection->weight_label_color = $validated['weight_label_color'] ?? '#ffffff';
        $cotizadorSection->unit_value_label_color = $validated['unit_value_label_color'] ?? '#ffffff';
        $cotizadorSection->shipping_method_label_color = $validated['shipping_method_label_color'] ?? '#ffffff';
        $cotizadorSection->is_active = $validated['is_active'] ?? true;
        
        $cotizadorSection->save();

        return redirect()->route('admin.cotizador-sections.index')
            ->with('success', 'Configuración del cotizador actualizada exitosamente.');
    }
}
