<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking.index');
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'tracking_number' => ['required', 'string', 'min:3', 'max:100', 'regex:/\A[A-Za-z0-9-]+\z/'],
        ], [
            'tracking_number.regex' => 'Ingresa el número de seguimiento con letras, números o guiones.',
        ]);

        return redirect()->route('tracking.show', ['trackingNumber' => $validated['tracking_number']]);
    }

    public function show(string $trackingNumber)
    {
        $trackingNumber = trim($trackingNumber);
        abort_unless(preg_match('/\A[A-Za-z0-9-]{3,100}\z/', $trackingNumber), 404);

        $package = Package::findByTracking($trackingNumber);
        if ($package === null) {
            return redirect()->route('tracking.index')
                ->withInput(['tracking_number' => $trackingNumber])
                ->with('tracking_error', 'Aún no hay un envío registrado con este número de seguimiento.');
        }

        $status = $package->status;
        $carrier = $package->carrier;
        $events = collect($package->tracking_history ?? [])
            ->filter(fn ($event) => is_array($event) && ($event['public'] ?? false) === true)
            ->reverse()->sortByDesc('date')->values()->all();

        return response()->view('tracking.result', compact('trackingNumber', 'status', 'carrier', 'events'))
            ->header('Cache-Control', 'private, no-store');
    }
}
