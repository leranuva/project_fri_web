<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->get('search');
            $filterType = $request->get('filter_type', '');

            // Si hay un tipo de filtro específico, buscar solo en ese campo
            if (!empty($filterType)) {
                switch ($filterType) {
                    case 'sku':
                        $query->where('key', 'like', "%{$search}%");
                        break;
                    case 'arancel':
                        $query->where('arancel_code', 'like', "%{$search}%");
                        break;
                    case 'name':
                        $query->where('name', 'like', "%{$search}%");
                        break;
                    default:
                        // Si no hay tipo específico, buscar en todos los campos
                        $query->where(function($q) use ($search) {
                            $q->where('key', 'like', "%{$search}%")
                              ->orWhere('arancel_code', 'like', "%{$search}%")
                              ->orWhere('name', 'like', "%{$search}%");
                        });
                        break;
                }
            } else {
                // Búsqueda general en todos los campos
                $query->where(function($q) use ($search) {
                    $q->where('key', 'like', "%{$search}%")
                      ->orWhere('arancel_code', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%");
                });
            }
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:products,key'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
            'arancel_code' => ['nullable', 'string', 'max:50'],
            'arancel_subpartida' => ['nullable', 'string', 'max:50'],
            'ad_valorem' => ['required', 'numeric', 'min:0', 'max:1'],
            'arancel_especifico' => ['nullable', 'numeric', 'min:0'],
            'new_percent' => ['nullable', 'numeric', 'min:0', 'max:1'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'key.required' => 'La clave del producto es obligatoria.',
            'key.unique' => 'Ya existe un producto con esta clave.',
            'name.required' => 'El nombre del producto es obligatorio.',
            'ad_valorem.required' => 'El ad-valorem es obligatorio.',
            'ad_valorem.numeric' => 'El ad-valorem debe ser un número.',
            'ad_valorem.min' => 'El ad-valorem no puede ser negativo.',
            'ad_valorem.max' => 'El ad-valorem no puede ser mayor a 1 (100%).',
        ]);

        // Convertir is_active a boolean
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        // Valores por defecto
        $validated['arancel_especifico'] = $validated['arancel_especifico'] ?? 0;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'key' => ['required', 'string', 'max:255', Rule::unique('products', 'key')->ignore($product->id)],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
            'arancel_code' => ['nullable', 'string', 'max:50'],
            'arancel_subpartida' => ['nullable', 'string', 'max:50'],
            'ad_valorem' => ['required', 'numeric', 'min:0', 'max:1'],
            'arancel_especifico' => ['nullable', 'numeric', 'min:0'],
            'new_percent' => ['nullable', 'numeric', 'min:0', 'max:1'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'key.required' => 'La clave del producto es obligatoria.',
            'key.unique' => 'Ya existe un producto con esta clave.',
            'name.required' => 'El nombre del producto es obligatorio.',
            'ad_valorem.required' => 'El ad-valorem es obligatorio.',
            'ad_valorem.numeric' => 'El ad-valorem debe ser un número.',
            'ad_valorem.min' => 'El ad-valorem no puede ser negativo.',
            'ad_valorem.max' => 'El ad-valorem no puede ser mayor a 1 (100%).',
        ]);

        // Convertir is_active a boolean
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        // Valores por defecto si son null
        $validated['arancel_especifico'] = $validated['arancel_especifico'] ?? 0;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        
        $productName = $product->name;
        
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', "Producto '{$productName}' eliminado exitosamente.");
    }
}
