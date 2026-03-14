<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = Store::ordered()->paginate(15);
        return view('admin.stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.stores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo_url' => ['nullable', 'string'],
            'logo_image' => ['nullable', 'image', 'mimes:png', 'max:2048'], // Solo PNG, máximo 2MB
            'website_url' => ['nullable', 'url', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'El nombre de la tienda es obligatorio.',
            'website_url.url' => 'La URL del sitio web debe ser una URL válida.',
            'logo_image.image' => 'El archivo debe ser una imagen válida.',
            'logo_image.mimes' => 'La imagen debe ser de tipo PNG.',
            'logo_image.max' => 'La imagen no debe ser mayor a 2MB.',
        ]);

        // Manejar subida de imagen PNG
        $logoImagePath = null;
        if ($request->hasFile('logo_image')) {
            $logoImagePath = $request->file('logo_image')->store('stores', 'public');
        }

        $store = Store::create([
            'name' => $validated['name'],
            'logo_url' => $validated['logo_url'] ?? null,
            'logo_image' => $logoImagePath ? asset('storage/' . $logoImagePath) : null,
            'website_url' => $validated['website_url'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('admin.stores.index')
            ->with('success', 'Tienda creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $store = Store::findOrFail($id);
        return view('admin.stores.show', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $store = Store::findOrFail($id);
        return view('admin.stores.edit', compact('store'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $store = Store::findOrFail($id);
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo_url' => ['nullable', 'string'],
            'logo_image' => ['nullable', 'image', 'mimes:png', 'max:2048'], // Solo PNG, máximo 2MB
            'website_url' => ['nullable', 'url', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'El nombre de la tienda es obligatorio.',
            'website_url.url' => 'La URL del sitio web debe ser una URL válida.',
            'logo_image.image' => 'El archivo debe ser una imagen válida.',
            'logo_image.mimes' => 'La imagen debe ser de tipo PNG.',
            'logo_image.max' => 'La imagen no debe ser mayor a 2MB.',
        ]);

        // Manejar subida de imagen PNG
        if ($request->hasFile('logo_image')) {
            // Eliminar imagen anterior si existe
            if ($store->logo_image && !str_starts_with($store->logo_image, 'http')) {
                $oldImagePath = str_replace(asset('storage/'), '', $store->logo_image);
                $oldImagePath = str_replace('storage/', '', $oldImagePath);
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }
            
            // Subir nueva imagen
            $logoImagePath = $request->file('logo_image')->store('stores', 'public');
            $store->logo_image = asset('storage/' . $logoImagePath);
            // Limpiar logo_url cuando se sube PNG
            $store->logo_url = null;
        } elseif ($request->has('logo_url')) {
            // Si el campo logo_url está presente en el request (incluso si está vacío)
            // Esto significa que se seleccionó "Código SVG"
            $newLogoSvg = $request->input('logo_url', '');
            
            // Si se proporciona SVG nuevo, actualizar
            if ($newLogoSvg !== '' && $newLogoSvg !== $store->logo_url) {
                // Eliminar imagen PNG si existe
                if ($store->logo_image && !str_starts_with($store->logo_image, 'http')) {
                    $oldImagePath = str_replace(asset('storage/'), '', $store->logo_image);
                    $oldImagePath = str_replace('storage/', '', $oldImagePath);
                    if (Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }
                }
                $store->logo_image = null;
                $store->logo_url = $newLogoSvg;
            } elseif ($newLogoSvg === '' && $store->logo_url) {
                // Si se limpia el SVG y había uno, limpiarlo
                $store->logo_url = null;
            }
        }
        // Si no se proporciona ni PNG ni SVG, mantener los valores actuales

        $store->name = $validated['name'];
        $store->website_url = $validated['website_url'] ?? null;
        $store->order = $validated['order'] ?? 0;
        $store->is_active = $validated['is_active'] ?? true;
        
        $store->save();

        return redirect()->route('admin.stores.index')
            ->with('success', 'Tienda actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $store = Store::findOrFail($id);
        $store->delete();
        
        return redirect()->route('admin.stores.index')
            ->with('success', 'Tienda eliminada exitosamente.');
    }
}
