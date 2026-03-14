<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $benefits = Benefit::latest()->paginate(15);
        return view('admin.benefits.index', compact('benefits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.benefits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:benefits,title'],
            'description' => ['required', 'string'],
            'icon_svg' => ['required', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'title_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'description_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.unique' => 'Ya existe un beneficio con este título.',
            'description.required' => 'La descripción es obligatoria.',
            'icon_svg.required' => 'El icono SVG es obligatorio.',
        ]);

        $benefit = Benefit::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'icon_svg' => $validated['icon_svg'],
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
            'title_color' => $validated['title_color'] ?? '#ffffff',
            'description_color' => $validated['description_color'] ?? '#ffffff',
        ]);

        return redirect()->route('admin.benefits.index')
            ->with('success', 'Beneficio creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $benefit = Benefit::findOrFail($id);
        return view('admin.benefits.show', compact('benefit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $benefit = Benefit::findOrFail($id);
        return view('admin.benefits.edit', compact('benefit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $benefit = Benefit::findOrFail($id);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('benefits', 'title')->ignore($benefit->id)],
            'description' => ['required', 'string'],
            'icon_svg' => ['required', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'title_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'description_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.unique' => 'Ya existe un beneficio con este título.',
            'description.required' => 'La descripción es obligatoria.',
            'icon_svg.required' => 'El icono SVG es obligatorio.',
        ]);

        $benefit->title = $validated['title'];
        $benefit->description = $validated['description'];
        $benefit->icon_svg = $validated['icon_svg'];
        $benefit->order = $validated['order'] ?? 0;
        $benefit->is_active = $validated['is_active'] ?? true;
        $benefit->title_color = $validated['title_color'] ?? '#ffffff';
        $benefit->description_color = $validated['description_color'] ?? '#ffffff';
        
        $benefit->save();

        return redirect()->route('admin.benefits.index')
            ->with('success', 'Beneficio actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $benefit = Benefit::findOrFail($id);
        $benefit->delete();
        
        return redirect()->route('admin.benefits.index')
            ->with('success', 'Beneficio eliminado exitosamente.');
    }
}
