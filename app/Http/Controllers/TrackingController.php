<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Services\TrackingService;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function __construct(private TrackingService $trackingService) {}

    public function index()
    {
        return redirect()->route('home')->withFragment('tracking');
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'tracking_number' => 'required|string|min:3|max:100',
        ]);

        return redirect()->route('tracking.show', ['trackingNumber' => $validated['tracking_number']]);
    }

    public function show(string $trackingNumber)
    {
        $trackingNumber = trim($trackingNumber);
        abort_unless(mb_strlen($trackingNumber) >= 3 && mb_strlen($trackingNumber) <= 100, 404);

        $package = Package::findByTracking($trackingNumber);
        $status = $package?->status;
        if ($package === null) {
            $status = $this->trackingService->fetchTrackingInfo($trackingNumber)['status'] ?? null;
        }

        if ($status === null) {
            return redirect()->route('home')->withFragment('tracking')
                ->with('tracking_error', 'No se encontró información para ese número de seguimiento.');
        }

        return response()->view('tracking.result', compact('trackingNumber', 'status'))
            ->header('Cache-Control', 'private, no-store');
    }
}
