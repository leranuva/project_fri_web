<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogSection;
use Illuminate\Http\Request;

class BlogSectionController extends Controller
{
    /**
     * Display the blog section configuration.
     */
    public function index()
    {
        $blogSection = BlogSection::first();
        
        // Si no existe, crear uno por defecto
        if (!$blogSection) {
            $blogSection = BlogSection::create([
                'title' => 'TEMAS DE INTERÉS',
                'title_color' => '#ffffff',
                'button_text' => 'Ver Blog',
                'button_link' => '#',
                'is_active' => true,
            ]);
        }
        
        return view('admin.blog-sections.edit', compact('blogSection'));
    }

    /**
     * Update the blog section configuration.
     */
    public function update(Request $request, string $id)
    {
        $blogSection = BlogSection::findOrFail($id);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'El título es obligatorio.',
        ]);

        $blogSection->title = $validated['title'];
        $blogSection->title_color = $validated['title_color'] ?? '#ffffff';
        $blogSection->button_text = $validated['button_text'] ?? null;
        $blogSection->button_link = $validated['button_link'] ?? null;
        $blogSection->is_active = $validated['is_active'] ?? true;
        
        $blogSection->save();

        return redirect()->route('admin.blog-sections.index')
            ->with('success', 'Configuración de la sección actualizada exitosamente.');
    }
}
