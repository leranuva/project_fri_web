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
                'subtitle' => 'Descubre artículos y noticias relevantes sobre importaciones y comercio internacional.',
                'title_color' => '#ffffff',
                'footer_text' => 'Mantente informado con nuestros artículos sobre importaciones, regulaciones y consejos útiles.',
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
            'subtitle' => ['nullable', 'string'],
            'title_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'footer_text' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:500'],
            'cta_button_text' => ['nullable', 'string', 'max:255'],
            'cta_button_visible' => ['nullable', 'boolean'],
            'cta_button_animated' => ['nullable', 'boolean'],
            'cta_button_bg_color' => ['nullable', 'string', 'max:50'],
            'cta_button_border_color' => ['nullable', 'string', 'max:50'],
            'cta_button_text_color' => ['nullable', 'string', 'max:50'],
            'cta_button_url_base' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'El título es obligatorio.',
        ]);

        $blogSection->title = $validated['title'];
        $blogSection->subtitle = $validated['subtitle'] ?? null;
        $blogSection->title_color = $validated['title_color'] ?? '#ffffff';
        $blogSection->footer_text = $validated['footer_text'] ?? null;
        $blogSection->button_text = $validated['button_text'] ?? null;
        $blogSection->button_link = $validated['button_link'] ?? null;
        $blogSection->cta_button_text = $validated['cta_button_text'] ?? 'Ir a la tienda';
        $blogSection->cta_button_visible = $request->boolean('cta_button_visible');
        $blogSection->cta_button_animated = $request->boolean('cta_button_animated');
        $blogSection->cta_button_bg_color = $validated['cta_button_bg_color'] ?? 'rgba(34, 197, 94, 0.2)';
        $blogSection->cta_button_border_color = $validated['cta_button_border_color'] ?? 'rgba(34, 197, 94, 0.4)';
        $blogSection->cta_button_text_color = $validated['cta_button_text_color'] ?? '#86efac';
        $blogSection->cta_button_url_base = $validated['cta_button_url_base'] ?? null;
        $blogSection->is_active = $validated['is_active'] ?? true;
        
        $blogSection->save();

        return redirect()->route('admin.blog-sections.index')
            ->with('success', 'Configuración de la sección actualizada exitosamente.');
    }
}
