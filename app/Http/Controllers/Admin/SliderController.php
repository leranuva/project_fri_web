<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::latest()->paginate(15);
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'required_without:image_file', 'string', 'url', 'max:500'],
            'image_file' => ['nullable', 'required_without:image_url', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'], // 5MB
            'cta' => ['nullable', 'string', 'max:100'],
            'cta_link' => ['nullable', 'string', 'url', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'title_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'subtitle_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        ], [
            'image_url.required_without' => 'Debes proporcionar una URL o subir un archivo de imagen.',
            'image_file.required_without' => 'Debes subir un archivo de imagen o proporcionar una URL.',
            'image_file.image' => 'El archivo debe ser una imagen válida.',
            'image_file.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png, gif o webp.',
            'image_file.max' => 'La imagen no debe ser mayor a 5MB.',
        ]);

        // Determinar la URL de la imagen
        $imageUrl = null;
        
        if ($request->hasFile('image_file')) {
            // Subir archivo
            $imagePath = $request->file('image_file')->store('sliders', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        } elseif ($request->filled('image_url')) {
            // Usar URL
            $imageUrl = $validated['image_url'];
        }

        $slider = Slider::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'description' => $validated['description'] ?? null,
            'image' => $imageUrl,
            'cta' => $validated['cta'] ?? null,
            'cta_link' => $validated['cta_link'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
            'title_color' => $validated['title_color'] ?? '#ffffff',
            'subtitle_color' => $validated['subtitle_color'] ?? '#ffffff',
        ]);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slide creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.show', compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $slider = Slider::findOrFail($id);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'required_without:image_file', 'string', 'url', 'max:500'],
            'image_file' => ['nullable', 'required_without:image_url', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'], // 5MB
            'cta' => ['nullable', 'string', 'max:100'],
            'cta_link' => ['nullable', 'string', 'url', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'title_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'subtitle_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        ], [
            'image_url.required_without' => 'Debes proporcionar una URL o subir un archivo de imagen.',
            'image_file.required_without' => 'Debes subir un archivo de imagen o proporcionar una URL.',
            'image_file.image' => 'El archivo debe ser una imagen válida.',
            'image_file.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png, gif o webp.',
            'image_file.max' => 'La imagen no debe ser mayor a 5MB.',
        ]);

        // Determinar la URL de la imagen (solo actualizar si se proporciona una nueva)
        if ($request->hasFile('image_file')) {
            // Eliminar imagen anterior si es un archivo local
            if ($slider->image && !str_starts_with($slider->image, 'http')) {
                $oldImagePath = str_replace(asset('storage/'), '', $slider->image);
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }
            
            // Subir nuevo archivo
            $imagePath = $request->file('image_file')->store('sliders', 'public');
            $slider->image = asset('storage/' . $imagePath);
        } elseif ($request->filled('image_url')) {
            // Solo actualizar si la URL es diferente
            if ($slider->image !== $validated['image_url']) {
                // Eliminar imagen anterior si es un archivo local
                if ($slider->image && !str_starts_with($slider->image, 'http')) {
                    $oldImagePath = str_replace(asset('storage/'), '', $slider->image);
                    if (Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }
                }
                $slider->image = $validated['image_url'];
            }
        }
        // Si no se proporciona ni archivo ni URL, mantener la imagen actual

        $slider->title = $validated['title'];
        $slider->subtitle = $validated['subtitle'] ?? null;
        $slider->description = $validated['description'] ?? null;
        $slider->cta = $validated['cta'] ?? null;
        $slider->cta_link = $validated['cta_link'] ?? null;
        $slider->order = $validated['order'] ?? 0;
        $slider->is_active = $validated['is_active'] ?? true;
        $slider->title_color = $validated['title_color'] ?? '#ffffff';
        $slider->subtitle_color = $validated['subtitle_color'] ?? '#ffffff';
        
        $slider->save();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slide actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);
        
        // Eliminar imagen si es un archivo local
        if ($slider->image && !str_starts_with($slider->image, 'http')) {
            $imagePath = str_replace(asset('storage/'), '', $slider->image);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }
        
        $slider->delete();
        
        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slide eliminado exitosamente.');
    }
}
