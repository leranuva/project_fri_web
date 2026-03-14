<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CotizadorSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
                'store_button_text' => 'Comprar este producto en la tienda',
                'store_button_visible' => true,
                'store_button_animated' => true,
                'store_button_bg_color' => 'rgba(34, 197, 94, 0.2)',
                'store_button_border_color' => 'rgba(34, 197, 94, 0.4)',
                'store_button_text_color' => '#86efac',
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
            'store_button_text' => ['nullable', 'string', 'max:120'],
            'store_button_visible' => ['nullable', 'boolean'],
            'store_button_animated' => ['nullable', 'boolean'],
            'store_button_bg_color' => ['nullable', 'string'],
            'store_button_border_color' => ['nullable', 'string'],
            'store_button_text_color' => ['nullable', 'string'],
            'store_button_url_base' => ['nullable', 'string', 'max:500', 'url'],
            'store_button_url_path' => ['nullable', 'string', 'max:255'],
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
        $cotizadorSection->store_button_text = $validated['store_button_text'] ?? 'Comprar este producto en la tienda';
        $cotizadorSection->store_button_visible = $request->boolean('store_button_visible');
        $cotizadorSection->store_button_animated = $request->boolean('store_button_animated');
        $cotizadorSection->store_button_bg_color = $validated['store_button_bg_color'] ?? 'rgba(34, 197, 94, 0.2)';
        $cotizadorSection->store_button_border_color = $validated['store_button_border_color'] ?? 'rgba(34, 197, 94, 0.4)';
        $cotizadorSection->store_button_text_color = $validated['store_button_text_color'] ?? '#86efac';
        $cotizadorSection->store_button_url_base = $validated['store_button_url_base'] ?? null;
        $cotizadorSection->store_button_url_path = $validated['store_button_url_path'] ?? null;
        $cotizadorSection->is_active = $validated['is_active'] ?? true;
        
        $cotizadorSection->save();

        Cache::forget('cotizador.section');

        return redirect()->route('admin.cotizador-sections.index')
            ->with('success', 'Configuración del cotizador actualizada exitosamente.');
    }
}
