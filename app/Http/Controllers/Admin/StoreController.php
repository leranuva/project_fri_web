<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

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
            'website_url' => ['nullable', 'url', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'El nombre de la tienda es obligatorio.',
            'website_url.url' => 'La URL del sitio web debe ser una URL válida.',
        ]);

        $store = Store::create([
            'name' => $validated['name'],
            'logo_url' => $validated['logo_url'] ?? null,
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
            'website_url' => ['nullable', 'url', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'El nombre de la tienda es obligatorio.',
            'website_url.url' => 'La URL del sitio web debe ser una URL válida.',
        ]);

        $store->name = $validated['name'];
        $store->logo_url = $validated['logo_url'] ?? null;
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
