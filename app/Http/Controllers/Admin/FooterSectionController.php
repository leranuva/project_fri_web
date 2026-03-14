<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSection;
use Illuminate\Http\Request;

class FooterSectionController extends Controller
{
    /**
     * Display the footer section configuration.
     */
    public function index()
    {
        $footerSection = FooterSection::first();
        
        // Si no existe, crear uno por defecto
        if (!$footerSection) {
            $footerSection = FooterSection::create([
                'brand_name' => 'Flat Rate Imports',
                'copyright_text' => '© ' . date('Y') . ' Flat Rate Imports. All rights reserved. Built with modern CSS and love.',
                'is_active' => true,
            ]);
        }
        
        return view('admin.footer-sections.edit', compact('footerSection'));
    }

    /**
     * Update the footer section configuration.
     */
    public function update(Request $request, string $id)
    {
        $footerSection = FooterSection::findOrFail($id);
        
        $validated = $request->validate([
            'brand_name' => ['required', 'string', 'max:255'],
            'copyright_text' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'brand_name.required' => 'El nombre de la marca es obligatorio.',
        ]);

        $footerSection->brand_name = $validated['brand_name'];
        $footerSection->copyright_text = $validated['copyright_text'] ?? null;
        $footerSection->is_active = $validated['is_active'] ?? true;
        
        $footerSection->save();

        return redirect()->route('admin.footer-sections.index')
            ->with('success', 'Configuración del footer actualizada exitosamente.');
    }
}
