<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaxRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TaxRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taxRates = \App\Models\TaxRate::latest()->paginate(15);
        return view('admin.tax-rates.index', compact('taxRates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tax-rates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:tax_rates,name'],
            'label' => ['required', 'string', 'max:255'],
            'rate' => ['required', 'numeric', 'min:0', 'max:1'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ], [
            'name.required' => 'El nombre del impuesto es obligatorio.',
            'name.unique' => 'Ya existe un impuesto con este nombre.',
            'label.required' => 'La etiqueta del impuesto es obligatoria.',
            'rate.required' => 'La tasa del impuesto es obligatoria.',
            'rate.numeric' => 'La tasa debe ser un número.',
            'rate.min' => 'La tasa no puede ser negativa.',
            'rate.max' => 'La tasa no puede ser mayor a 1 (100%).',
        ]);

        // Convertir is_active a boolean
        $validated['is_active'] = $request->has('is_active') ? true : false;

        TaxRate::create($validated);

        return redirect()->route('admin.tax-rates.index')
            ->with('success', 'Impuesto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $taxRate = TaxRate::findOrFail($id);
        return view('admin.tax-rates.show', compact('taxRate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $taxRate = TaxRate::findOrFail($id);
        return view('admin.tax-rates.edit', compact('taxRate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $taxRate = TaxRate::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('tax_rates', 'name')->ignore($taxRate->id)],
            'label' => ['required', 'string', 'max:255'],
            'rate' => ['required', 'numeric', 'min:0', 'max:1'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ], [
            'name.required' => 'El nombre del impuesto es obligatorio.',
            'name.unique' => 'Ya existe un impuesto con este nombre.',
            'label.required' => 'La etiqueta del impuesto es obligatoria.',
            'rate.required' => 'La tasa del impuesto es obligatoria.',
            'rate.numeric' => 'La tasa debe ser un número.',
            'rate.min' => 'La tasa no puede ser negativa.',
            'rate.max' => 'La tasa no puede ser mayor a 1 (100%).',
        ]);

        // Convertir is_active a boolean
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $taxRate->update($validated);

        return redirect()->route('admin.tax-rates.index')
            ->with('success', 'Impuesto actualizado exitosamente.');
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
                ->withInput(['password' => '', 'delete_tax_rate_id' => $id]);
        }

        $taxRate = TaxRate::findOrFail($id);
        
        $label = $taxRate->label;
        
        $taxRate->delete();
        
        return redirect()->route('admin.tax-rates.index')
            ->with('success', "Impuesto '{$label}' eliminado exitosamente.");
    }
}
