<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlertBanner;
use Illuminate\Http\Request;

class AlertBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alertBanners = AlertBanner::latest()->paginate(15);
        return view('admin.alert-banners.index', compact('alertBanners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.alert-banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon_svg' => ['required', 'string'],
            'button_text_auth' => ['nullable', 'string', 'max:100'],
            'button_link_auth' => ['nullable', 'string', 'max:500'],
            'button_text_guest' => ['nullable', 'string', 'max:100'],
            'button_link_guest' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $alertBanner = AlertBanner::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'icon_svg' => $validated['icon_svg'],
            'button_text_auth' => $validated['button_text_auth'] ?? null,
            'button_link_auth' => $validated['button_link_auth'] ?? null,
            'button_text_guest' => $validated['button_text_guest'] ?? null,
            'button_link_guest' => $validated['button_link_guest'] ?? null,
            'background_color' => $validated['background_color'] ?? 'transparent',
            'title_color' => $validated['title_color'] ?? '#ffffff',
            'description_color' => $validated['description_color'] ?? '#ffffff',
            'container_color' => $validated['container_color'] ?? 'rgba(255, 255, 255, 0.15)',
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('admin.alert-banners.index')
            ->with('success', 'Banner de alerta creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $alertBanner = AlertBanner::findOrFail($id);
        return view('admin.alert-banners.show', compact('alertBanner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $alertBanner = AlertBanner::findOrFail($id);
        return view('admin.alert-banners.edit', compact('alertBanner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $alertBanner = AlertBanner::findOrFail($id);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon_svg' => ['required', 'string'],
            'button_text_auth' => ['nullable', 'string', 'max:100'],
            'button_link_auth' => ['nullable', 'string', 'max:500'],
            'button_text_guest' => ['nullable', 'string', 'max:100'],
            'button_link_guest' => ['nullable', 'string', 'max:500'],
            'background_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$|^transparent$/'],
            'title_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'description_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'container_color' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $alertBanner->title = $validated['title'];
        $alertBanner->description = $validated['description'];
        $alertBanner->icon_svg = $validated['icon_svg'];
        $alertBanner->button_text_auth = $validated['button_text_auth'] ?? null;
        $alertBanner->button_link_auth = $validated['button_link_auth'] ?? null;
        $alertBanner->button_text_guest = $validated['button_text_guest'] ?? null;
        $alertBanner->button_link_guest = $validated['button_link_guest'] ?? null;
        $alertBanner->background_color = $validated['background_color'] ?? 'transparent';
        $alertBanner->title_color = $validated['title_color'] ?? '#ffffff';
        $alertBanner->description_color = $validated['description_color'] ?? '#ffffff';
        $alertBanner->container_color = $validated['container_color'] ?? 'rgba(255, 255, 255, 0.15)';
        $alertBanner->is_active = $validated['is_active'] ?? true;
        
        $alertBanner->save();

        return redirect()->route('admin.alert-banners.index')
            ->with('success', 'Banner de alerta actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alertBanner = AlertBanner::findOrFail($id);
        $alertBanner->delete();
        
        return redirect()->route('admin.alert-banners.index')
            ->with('success', 'Banner de alerta eliminado exitosamente.');
    }
}
