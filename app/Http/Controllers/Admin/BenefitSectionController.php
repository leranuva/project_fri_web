<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BenefitSection;
use Illuminate\Http\Request;

class BenefitSectionController extends Controller
{
    /**
     * Display the benefit section configuration.
     */
    public function index()
    {
        $benefitSection = BenefitSection::first();
        
        // Si no existe, crear uno por defecto
        if (!$benefitSection) {
            $benefitSection = BenefitSection::create([
                'title' => '¿Por qué elegir Flat Rate Imports?',
                'title_color' => '#ffffff',
                'is_active' => true,
            ]);
        }
        
        return view('admin.benefit-sections.edit', compact('benefitSection'));
    }

    /**
     * Update the benefit section configuration.
     */
    public function update(Request $request, string $id)
    {
        $benefitSection = BenefitSection::findOrFail($id);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'El título es obligatorio.',
        ]);

        $benefitSection->title = $validated['title'];
        $benefitSection->title_color = $validated['title_color'] ?? '#ffffff';
        $benefitSection->is_active = $validated['is_active'] ?? true;
        
        $benefitSection->save();

        return redirect()->route('admin.benefit-sections.index')
            ->with('success', 'Configuración de la sección actualizada exitosamente.');
    }
}
