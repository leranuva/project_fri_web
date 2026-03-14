<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logos = Logo::latest()->paginate(15);
        return view('admin.logos.index', compact('logos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.logos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'logo_image' => ['required', 'image', 'mimes:png,jpg,jpeg,svg', 'max:5120'], // Máximo 5MB
            'is_active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'logo_image.required' => 'La imagen del logo es obligatoria.',
            'logo_image.image' => 'El archivo debe ser una imagen válida.',
            'logo_image.mimes' => 'La imagen debe ser de tipo PNG, JPG, JPEG o SVG.',
            'logo_image.max' => 'La imagen no debe ser mayor a 5MB.',
        ]);

        // Manejar subida de imagen
        $logoImagePath = null;
        if ($request->hasFile('logo_image')) {
            $logoImagePath = $request->file('logo_image')->store('logos', 'public');
        }

        // Si se marca como activo, desactivar los demás
        if ($request->has('is_active') && $request->is_active) {
            Logo::where('is_active', true)->update(['is_active' => false]);
        }

        $logo = Logo::create([
            'name' => $validated['name'] ?? 'Logo ' . now()->format('Y-m-d'),
            'image_path' => $logoImagePath ? 'storage/' . $logoImagePath : null,
            'is_active' => $request->has('is_active') && $request->is_active ? true : false,
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()->route('admin.logos.index')
            ->with('success', 'Logo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $logo = Logo::findOrFail($id);
        return view('admin.logos.show', compact('logo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $logo = Logo::findOrFail($id);
        return view('admin.logos.edit', compact('logo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $logo = Logo::findOrFail($id);
        
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'logo_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'logo_image.image' => 'El archivo debe ser una imagen válida.',
            'logo_image.mimes' => 'La imagen debe ser de tipo PNG, JPG, JPEG o SVG.',
            'logo_image.max' => 'La imagen no debe ser mayor a 5MB.',
        ]);

        // Manejar subida de nueva imagen
        if ($request->hasFile('logo_image')) {
            // Eliminar imagen anterior si existe
            if ($logo->image_path && Storage::disk('public')->exists(str_replace('storage/', '', $logo->image_path))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $logo->image_path));
            }
            
            $logoImagePath = $request->file('logo_image')->store('logos', 'public');
            $logo->image_path = 'storage/' . $logoImagePath;
        }

        $logo->name = $validated['name'] ?? $logo->name;
        $logo->order = $validated['order'] ?? $logo->order;

        // Si se marca como activo, desactivar los demás
        if ($request->has('is_active')) {
            if ($request->is_active) {
                Logo::where('id', '!=', $logo->id)->update(['is_active' => false]);
                $logo->is_active = true;
            } else {
                $logo->is_active = false;
            }
        }

        $logo->save();

        return redirect()->route('admin.logos.index')
            ->with('success', 'Logo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $logo = Logo::findOrFail($id);
        
        // Eliminar imagen del storage
        if ($logo->image_path && Storage::disk('public')->exists(str_replace('storage/', '', $logo->image_path))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $logo->image_path));
        }
        
        $logo->delete();
        
        return redirect()->route('admin.logos.index')
            ->with('success', 'Logo eliminado exitosamente.');
    }

    /**
     * Activate a logo.
     */
    public function activate(string $id)
    {
        $logo = Logo::findOrFail($id);
        $logo->activate();
        
        return redirect()->route('admin.logos.index')
            ->with('success', 'Logo activado exitosamente.');
    }
}
