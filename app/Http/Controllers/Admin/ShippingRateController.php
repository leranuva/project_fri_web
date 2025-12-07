<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShippingRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ShippingRate::query();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->get('search');
            $filterType = $request->get('filter_type', '');

            // Si hay un tipo de filtro específico, buscar solo en ese campo
            if (!empty($filterType)) {
                switch ($filterType) {
                    case 'method':
                        $query->where('method', 'like', "%{$search}%");
                        break;
                    case 'notes':
                        $query->where('notes', 'like', "%{$search}%");
                        break;
                    default:
                        // Búsqueda general
                        $query->where(function($q) use ($search) {
                            $q->where('method', 'like', "%{$search}%")
                              ->orWhere('notes', 'like', "%{$search}%");
                        });
                        break;
                }
            } else {
                // Búsqueda general en todos los campos
                $query->where(function($q) use ($search) {
                    $q->where('method', 'like', "%{$search}%")
                      ->orWhere('notes', 'like', "%{$search}%");
                });
            }
        }

        // Filtro por método
        if ($request->filled('method')) {
            $query->where('method', $request->get('method'));
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

        $shippingRates = $query->latest()->paginate(15)->withQueryString();
        return view('admin.shipping-rates.index', compact('shippingRates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shipping-rates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'method' => ['required', 'string', 'in:maritimo,aereo,aereoExpres,courier4x4'],
            'min_weight' => ['required', 'numeric', 'min:0'],
            'max_weight' => ['nullable', 'numeric', 'min:0'],
            'max_value_fob' => ['nullable', 'numeric', 'min:0'],
            'cost_per_pound' => ['required', 'numeric', 'min:0'],
            'fixed_cost' => ['nullable', 'numeric', 'min:0'],
            'is_special_case' => ['boolean'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'method.required' => 'El método de envío es obligatorio.',
            'method.in' => 'El método de envío debe ser uno de: maritimo, aereo, aereoExpres, courier4x4.',
            'min_weight.required' => 'El peso mínimo es obligatorio.',
            'min_weight.numeric' => 'El peso mínimo debe ser un número.',
            'min_weight.min' => 'El peso mínimo no puede ser negativo.',
            'max_weight.numeric' => 'El peso máximo debe ser un número.',
            'max_weight.min' => 'El peso máximo no puede ser negativo.',
            'cost_per_pound.required' => 'El costo por libra es obligatorio.',
            'cost_per_pound.numeric' => 'El costo por libra debe ser un número.',
            'cost_per_pound.min' => 'El costo por libra no puede ser negativo.',
        ]);

        // Validar que max_weight sea mayor que min_weight si ambos están presentes
        if ($validated['max_weight'] !== null && $validated['max_weight'] <= $validated['min_weight']) {
            return back()->withErrors(['max_weight' => 'El peso máximo debe ser mayor que el peso mínimo.'])->withInput();
        }

        // Validar que max_weight sea mayor que min_weight si ambos están presentes
        if ($validated['max_weight'] !== null && $validated['max_weight'] <= $validated['min_weight']) {
            return back()->withErrors(['max_weight' => 'El peso máximo debe ser mayor que el peso mínimo.'])->withInput();
        }

        // Convertir booleanos
        $validated['is_special_case'] = $request->has('is_special_case') ? true : false;
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        // Valores por defecto
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        ShippingRate::create($validated);

        return redirect()->route('admin.shipping-rates.index')
            ->with('success', 'Tarifa de envío creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shippingRate = ShippingRate::findOrFail($id);
        return view('admin.shipping-rates.show', compact('shippingRate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $shippingRate = ShippingRate::findOrFail($id);
        return view('admin.shipping-rates.edit', compact('shippingRate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $shippingRate = ShippingRate::findOrFail($id);

        $validated = $request->validate([
            'method' => ['required', 'string', 'in:maritimo,aereo,aereoExpres,courier4x4'],
            'min_weight' => ['required', 'numeric', 'min:0'],
            'max_weight' => ['nullable', 'numeric', 'min:0'],
            'max_value_fob' => ['nullable', 'numeric', 'min:0'],
            'cost_per_pound' => ['required', 'numeric', 'min:0'],
            'fixed_cost' => ['nullable', 'numeric', 'min:0'],
            'is_special_case' => ['boolean'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'method.required' => 'El método de envío es obligatorio.',
            'method.in' => 'El método de envío debe ser uno de: maritimo, aereo, aereoExpres, courier4x4.',
            'min_weight.required' => 'El peso mínimo es obligatorio.',
            'min_weight.numeric' => 'El peso mínimo debe ser un número.',
            'min_weight.min' => 'El peso mínimo no puede ser negativo.',
            'max_weight.numeric' => 'El peso máximo debe ser un número.',
            'max_weight.min' => 'El peso máximo no puede ser negativo.',
            'cost_per_pound.required' => 'El costo por libra es obligatorio.',
            'cost_per_pound.numeric' => 'El costo por libra debe ser un número.',
            'cost_per_pound.min' => 'El costo por libra no puede ser negativo.',
        ]);

        // Validar que max_weight sea mayor que min_weight si ambos están presentes
        if ($validated['max_weight'] !== null && $validated['max_weight'] <= $validated['min_weight']) {
            return back()->withErrors(['max_weight' => 'El peso máximo debe ser mayor que el peso mínimo.'])->withInput();
        }

        // Convertir booleanos
        $validated['is_special_case'] = $request->has('is_special_case') ? true : false;
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        // Valores por defecto
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $shippingRate->update($validated);

        return redirect()->route('admin.shipping-rates.index')
            ->with('success', 'Tarifa de envío actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        // Validar contraseña de administrador
        $request->validate([
            'password' => ['required', 'string'],
        ], [
            'password.required' => 'La contraseña es obligatoria para confirmar la eliminación.',
        ]);

        // Verificar que la contraseña sea correcta
        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()
                ->withErrors(['password' => 'La contraseña ingresada es incorrecta.'])
                ->withInput(['password' => '', 'delete_rate_id' => $id]);
        }

        $shippingRate = ShippingRate::findOrFail($id);
        
        $method = ucfirst($shippingRate->method);
        
        $shippingRate->delete();
        
        return redirect()->route('admin.shipping-rates.index')
            ->with('success', "Tarifa de envío '{$method}' eliminada exitosamente.");
    }
}
