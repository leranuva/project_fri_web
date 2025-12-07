<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Services\TrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrackingController extends Controller
{
    protected $trackingService;

    public function __construct(TrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * Mostrar formulario de búsqueda (redirige a home)
     */
    public function index()
    {
        return redirect()->route('home')->withFragment('tracking');
    }

    /**
     * Buscar paquete por número de tracking
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tracking_number' => 'required|string|min:3|max:100',
        ], [
            'tracking_number.required' => 'Por favor ingresa un número de tracking o guía.',
            'tracking_number.min' => 'El número de tracking debe tener al menos 3 caracteres.',
            'tracking_number.max' => 'El número de tracking no puede exceder 100 caracteres.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('home')
                ->withFragment('tracking')
                ->withErrors($validator)
                ->withInput();
        }

        $trackingNumber = trim($request->input('tracking_number'));

        // Buscar paquete en la base de datos primero
        $package = Package::findByTracking($trackingNumber);

        // Si no se encuentra, buscar parcialmente
        if (!$package) {
            $package = Package::byTracking($trackingNumber)->first();
        }

        // Si aún no se encuentra, intentar obtener información automáticamente
        if (!$package) {
            try {
                $userId = auth()->check() ? auth()->id() : null;
                $package = $this->trackingService->createOrUpdatePackage($trackingNumber, $userId);
            } catch (\Exception $e) {
                \Log::error('Error al buscar tracking automático: ' . $e->getMessage());
                
                return redirect()
                    ->route('home')
                    ->withFragment('tracking')
                    ->with('tracking_error', 'No se pudo obtener información automática para el número de tracking: ' . $trackingNumber)
                    ->withInput();
            }
        }

        if ($package) {
            return view('tracking.result', [
                'package' => $package,
                'tracking_number' => $trackingNumber,
            ]);
        }

        return redirect()
            ->route('home')
            ->withFragment('tracking')
            ->with('tracking_error', 'No se encontró información para el número de tracking: ' . $trackingNumber)
            ->withInput();
    }

    /**
     * Mostrar resultado del tracking
     */
    public function show(string $trackingNumber)
    {
        $package = Package::findByTracking($trackingNumber);

        // Si no se encuentra, intentar obtener información automáticamente
        if (!$package) {
            try {
                $userId = auth()->check() ? auth()->id() : null;
                $package = $this->trackingService->createOrUpdatePackage($trackingNumber, $userId);
            } catch (\Exception $e) {
                \Log::error('Error al buscar tracking automático: ' . $e->getMessage());
                
                return redirect()
                    ->route('home')
                    ->withFragment('tracking')
                    ->with('tracking_error', 'No se pudo obtener información para el número de tracking: ' . $trackingNumber);
            }
        }

        if ($package) {
            return view('tracking.result', [
                'package' => $package,
                'tracking_number' => $trackingNumber,
            ]);
        }

        return redirect()
            ->route('home')
            ->withFragment('tracking')
            ->with('tracking_error', 'No se encontró información para el número de tracking: ' . $trackingNumber);
    }
}
