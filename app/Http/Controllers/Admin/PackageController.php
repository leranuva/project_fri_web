<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Package::with('user')->latest();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('tracking_number', 'like', "%{$search}%")
                  ->orWhere('carrier', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('origin', 'like', "%{$search}%")
                  ->orWhere('destination', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        $packages = $query->paginate(15)->withQueryString();
        
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'customer')->orderBy('name')->get();
        return view('admin.packages.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'tracking_number' => ['required', 'string', 'max:100', 'unique:packages,tracking_number'],
            'carrier' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:pending,in_transit,received,in_customs,delivered'],
            'origin' => ['nullable', 'string', 'max:255'],
            'destination' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'value' => ['nullable', 'numeric', 'min:0'],
            'shipped_date' => ['nullable', 'date'],
            'estimated_delivery' => ['nullable', 'date'],
            'delivered_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ], [
            'tracking_number.required' => 'El número de tracking es obligatorio.',
            'tracking_number.unique' => 'Ya existe un paquete con este número de tracking.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',
        ]);

        // Procesar tracking_history si se proporciona
        $trackingHistory = null;
        if ($request->filled('tracking_history')) {
            $history = json_decode($request->input('tracking_history'), true);
            if (is_array($history)) {
                $trackingHistory = $history;
            }
        }

        $package = Package::create([
            'user_id' => $validated['user_id'] ?? null,
            'tracking_number' => $validated['tracking_number'],
            'carrier' => $validated['carrier'] ?? null,
            'status' => $validated['status'],
            'origin' => $validated['origin'] ?? null,
            'destination' => $validated['destination'] ?? null,
            'description' => $validated['description'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'value' => $validated['value'] ?? null,
            'shipped_date' => $validated['shipped_date'] ? Carbon::parse($validated['shipped_date']) : null,
            'estimated_delivery' => $validated['estimated_delivery'] ? Carbon::parse($validated['estimated_delivery']) : null,
            'delivered_date' => $validated['delivered_date'] ? Carbon::parse($validated['delivered_date']) : null,
            'tracking_history' => $trackingHistory,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paquete creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $package = Package::with('user')->findOrFail($id);
        return view('admin.packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $package = Package::findOrFail($id);
        $users = User::where('role', 'customer')->orderBy('name')->get();
        return view('admin.packages.edit', compact('package', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $package = Package::findOrFail($id);

        $validated = $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'tracking_number' => ['required', 'string', 'max:100', Rule::unique('packages', 'tracking_number')->ignore($package->id)],
            'carrier' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:pending,in_transit,received,in_customs,delivered'],
            'origin' => ['nullable', 'string', 'max:255'],
            'destination' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'value' => ['nullable', 'numeric', 'min:0'],
            'shipped_date' => ['nullable', 'date'],
            'estimated_delivery' => ['nullable', 'date'],
            'delivered_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ], [
            'tracking_number.required' => 'El número de tracking es obligatorio.',
            'tracking_number.unique' => 'Ya existe un paquete con este número de tracking.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',
        ]);

        // Procesar tracking_history si se proporciona
        $trackingHistory = $package->tracking_history;
        if ($request->filled('tracking_history')) {
            $history = json_decode($request->input('tracking_history'), true);
            if (is_array($history)) {
                $trackingHistory = $history;
            }
        }

        $package->update([
            'user_id' => $validated['user_id'] ?? null,
            'tracking_number' => $validated['tracking_number'],
            'carrier' => $validated['carrier'] ?? null,
            'status' => $validated['status'],
            'origin' => $validated['origin'] ?? null,
            'destination' => $validated['destination'] ?? null,
            'description' => $validated['description'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'value' => $validated['value'] ?? null,
            'shipped_date' => $validated['shipped_date'] ? Carbon::parse($validated['shipped_date']) : null,
            'estimated_delivery' => $validated['estimated_delivery'] ? Carbon::parse($validated['estimated_delivery']) : null,
            'delivered_date' => $validated['delivered_date'] ? Carbon::parse($validated['delivered_date']) : null,
            'tracking_history' => $trackingHistory,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paquete actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Paquete eliminado exitosamente.');
    }
}
