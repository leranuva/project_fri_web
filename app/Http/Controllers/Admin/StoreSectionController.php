<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSection;
use Illuminate\Http\Request;

class StoreSectionController extends Controller
{
    /**
     * Display the store section configuration.
     */
    public function index()
    {
        $storeSection = StoreSection::first();
        
        // Si no existe, crear uno por defecto
        if (!$storeSection) {
            $storeSection = StoreSection::create([
                'title' => 'Compra en todas estas tiendas',
                'subtitle' => '¡Y muchas más!',
                'title_color' => '#ffffff',
                'subtitle_color' => 'rgba(255, 255, 255, 0.8)',
                'footer_link' => 'https://flatrateimports.store/',
                'footer_link_text' => 'Revisar todas las tiendas',
                'is_active' => true,
            ]);
        }
        
        return view('admin.store-sections.edit', compact('storeSection'));
    }

    /**
     * Update the store section configuration.
     */
    public function update(Request $request, string $id)
    {
        $storeSection = StoreSection::findOrFail($id);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'title_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'subtitle_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'footer_link' => ['nullable', 'url', 'max:255'],
            'footer_link_text' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'El título es obligatorio.',
            'footer_link.url' => 'El enlace debe ser una URL válida.',
        ]);

        $storeSection->title = $validated['title'];
        $storeSection->subtitle = $validated['subtitle'] ?? null;
        $storeSection->title_color = $validated['title_color'] ?? '#ffffff';
        $storeSection->subtitle_color = $validated['subtitle_color'] ?? 'rgba(255, 255, 255, 0.8)';
        $storeSection->footer_link = $validated['footer_link'] ?? null;
        $storeSection->footer_link_text = $validated['footer_link_text'] ?? null;
        $storeSection->is_active = $validated['is_active'] ?? true;
        
        $storeSection->save();

        return redirect()->route('admin.store-sections.index')
            ->with('success', 'Configuración de la sección actualizada exitosamente.');
    }
}
