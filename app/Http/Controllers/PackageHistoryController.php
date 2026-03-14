<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Services\TrackingService;

class PackageHistoryController extends Controller
{
    public function __construct(
        private TrackingService $trackingService
    ) {}

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
     * Agregar paquete por número de tracking
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:50',
        ]);

        $trackingNumber = trim($request->tracking_number);
        $package = $this->trackingService->createOrUpdatePackage($trackingNumber, auth()->id());

        return redirect()
            ->route('packages.show', $package->tracking_number)
            ->with('success', 'Paquete agregado correctamente.');
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
     * Actualizar información del paquete desde la API
     */
    public function refresh(string $trackingNumber)
    {
        $package = Package::where('user_id', auth()->id())
            ->where('tracking_number', $trackingNumber)
            ->firstOrFail();

        $this->trackingService->createOrUpdatePackage($trackingNumber, auth()->id());
        $package->refresh();

        return redirect()
            ->route('packages.show', $trackingNumber)
            ->with('success', 'Información actualizada.');
    }
}
