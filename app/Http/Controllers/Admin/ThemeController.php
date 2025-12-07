<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $themes = Theme::latest()->paginate(15);
        return view('admin.themes.index', compact('themes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.themes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'primary_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'secondary_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'accent_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'background_gradient_start' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'background_gradient_mid' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'background_gradient_end' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'text_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'text_secondary_color' => ['nullable', 'string'],
            'button_color' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'El nombre del tema es obligatorio.',
            'primary_color.required' => 'El color principal es obligatorio.',
            'primary_color.regex' => 'El color principal debe ser un código hexadecimal válido.',
            'secondary_color.required' => 'El color secundario es obligatorio.',
            'secondary_color.regex' => 'El color secundario debe ser un código hexadecimal válido.',
            'accent_color.required' => 'El color de acento es obligatorio.',
            'accent_color.regex' => 'El color de acento debe ser un código hexadecimal válido.',
            'background_gradient_start.required' => 'El color de inicio del gradiente es obligatorio.',
            'background_gradient_start.regex' => 'El color de inicio del gradiente debe ser un código hexadecimal válido.',
            'background_gradient_mid.required' => 'El color medio del gradiente es obligatorio.',
            'background_gradient_mid.regex' => 'El color medio del gradiente debe ser un código hexadecimal válido.',
            'background_gradient_end.required' => 'El color final del gradiente es obligatorio.',
            'background_gradient_end.regex' => 'El color final del gradiente debe ser un código hexadecimal válido.',
            'text_color.required' => 'El color de texto es obligatorio.',
            'text_color.regex' => 'El color de texto debe ser un código hexadecimal válido.',
        ]);

        // Si se marca como activo, desactivar todos los demás
        if ($validated['is_active'] ?? false) {
            Theme::where('is_active', true)->update(['is_active' => false]);
        }

        $theme = Theme::create([
            'name' => $validated['name'],
            'primary_color' => $validated['primary_color'],
            'secondary_color' => $validated['secondary_color'],
            'accent_color' => $validated['accent_color'],
            'background_gradient_start' => $validated['background_gradient_start'],
            'background_gradient_mid' => $validated['background_gradient_mid'],
            'background_gradient_end' => $validated['background_gradient_end'],
            'text_color' => $validated['text_color'],
            'text_secondary_color' => !empty($validated['text_secondary_color']) ? $validated['text_secondary_color'] : 'rgba(255, 255, 255, 0.8)',
            'button_color' => !empty($validated['button_color']) ? $validated['button_color'] : 'rgba(255, 255, 255, 0.3)',
            'is_active' => $validated['is_active'] ?? false,
        ]);

        return redirect()->route('admin.themes.index')
            ->with('success', 'Tema creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $theme = Theme::findOrFail($id);
        return view('admin.themes.show', compact('theme'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $theme = Theme::findOrFail($id);
        return view('admin.themes.edit', compact('theme'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $theme = Theme::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'primary_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'secondary_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'accent_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'background_gradient_start' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'background_gradient_mid' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'background_gradient_end' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'text_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'text_secondary_color' => ['nullable', 'string'],
            'button_color' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'El nombre del tema es obligatorio.',
            'primary_color.required' => 'El color principal es obligatorio.',
            'primary_color.regex' => 'El color principal debe ser un código hexadecimal válido.',
            'secondary_color.required' => 'El color secundario es obligatorio.',
            'secondary_color.regex' => 'El color secundario debe ser un código hexadecimal válido.',
            'accent_color.required' => 'El color de acento es obligatorio.',
            'accent_color.regex' => 'El color de acento debe ser un código hexadecimal válido.',
            'background_gradient_start.required' => 'El color de inicio del gradiente es obligatorio.',
            'background_gradient_start.regex' => 'El color de inicio del gradiente debe ser un código hexadecimal válido.',
            'background_gradient_mid.required' => 'El color medio del gradiente es obligatorio.',
            'background_gradient_mid.regex' => 'El color medio del gradiente debe ser un código hexadecimal válido.',
            'background_gradient_end.required' => 'El color final del gradiente es obligatorio.',
            'background_gradient_end.regex' => 'El color final del gradiente debe ser un código hexadecimal válido.',
            'text_color.required' => 'El color de texto es obligatorio.',
            'text_color.regex' => 'El color de texto debe ser un código hexadecimal válido.',
        ]);

        // Si se marca como activo, desactivar todos los demás
        if ($validated['is_active'] ?? false) {
            Theme::where('is_active', true)->where('id', '!=', $id)->update(['is_active' => false]);
        }

        $theme->update([
            'name' => $validated['name'],
            'primary_color' => $validated['primary_color'],
            'secondary_color' => $validated['secondary_color'],
            'accent_color' => $validated['accent_color'],
            'background_gradient_start' => $validated['background_gradient_start'],
            'background_gradient_mid' => $validated['background_gradient_mid'],
            'background_gradient_end' => $validated['background_gradient_end'],
            'text_color' => $validated['text_color'],
            'text_secondary_color' => isset($validated['text_secondary_color']) && trim($validated['text_secondary_color']) !== '' ? $validated['text_secondary_color'] : $theme->text_secondary_color,
            'button_color' => isset($validated['button_color']) && trim($validated['button_color']) !== '' ? $validated['button_color'] : $theme->button_color,
            'is_active' => $validated['is_active'] ?? false,
        ]);

        return redirect()->route('admin.themes.index')
            ->with('success', 'Tema actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $theme = Theme::findOrFail($id);
        
        // No permitir eliminar si es el único tema activo
        if ($theme->is_active && Theme::where('is_active', true)->count() === 1) {
            return redirect()->route('admin.themes.index')
                ->with('error', 'No se puede eliminar el tema activo. Activa otro tema primero.');
        }

        $theme->delete();

        return redirect()->route('admin.themes.index')
            ->with('success', 'Tema eliminado exitosamente.');
    }

    /**
     * Activate a theme.
     */
    public function activate(string $id)
    {
        $theme = Theme::findOrFail($id);
        $theme->activate();

        return redirect()->route('admin.themes.index')
            ->with('success', 'Tema activado exitosamente.');
    }
}
