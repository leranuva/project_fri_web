<?php

namespace App\Http\Controllers;

use App\Models\Package;

class PackageHistoryController extends Controller
{
    /**
     * Mostrar paquetes del usuario autenticado
     */
    public function index()
    {
        $packages = Package::where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('packages.index', compact('packages'));
    }

    /**
     * Consultar un paquete ya asignado al cliente por número de tracking
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:50',
        ]);

        $trackingNumber = trim($request->tracking_number);
        $package = Package::where('user_id', auth()->id())
            ->where('tracking_number', $trackingNumber)
            ->firstOrFail();

        return redirect()
            ->route('packages.show', $package->tracking_number);
    }

    /**
     * Ver detalle de un paquete
     */
    public function show(string $trackingNumber)
    {
        $package = Package::where('user_id', auth()->id())
            ->where('tracking_number', $trackingNumber)
            ->firstOrFail();

        return view('packages.show', compact('package'));
    }

    /**
     * Volver al estado registrado por el administrador
     */
    public function refresh(string $trackingNumber)
    {
        $package = Package::where('user_id', auth()->id())
            ->where('tracking_number', $trackingNumber)
            ->firstOrFail();

        return redirect()->route('packages.show', $package->tracking_number);
    }
}
