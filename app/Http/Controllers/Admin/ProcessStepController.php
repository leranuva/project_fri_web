<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcessStep;
use Illuminate\Http\Request;

class ProcessStepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $processSteps = ProcessStep::latest()->paginate(15);
        return view('admin.process-steps.index', compact('processSteps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.process-steps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'step_number' => ['required', 'integer', 'min:1'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon_svg' => ['required', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $processStep = ProcessStep::create([
            'step_number' => $validated['step_number'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'icon_svg' => $validated['icon_svg'],
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('admin.process-steps.index')
            ->with('success', 'Paso del proceso creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $processStep = ProcessStep::findOrFail($id);
        return view('admin.process-steps.show', compact('processStep'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $processStep = ProcessStep::findOrFail($id);
        return view('admin.process-steps.edit', compact('processStep'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $processStep = ProcessStep::findOrFail($id);
        
        $validated = $request->validate([
            'step_number' => ['required', 'integer', 'min:1'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon_svg' => ['required', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $processStep->step_number = $validated['step_number'];
        $processStep->title = $validated['title'];
        $processStep->description = $validated['description'];
        $processStep->icon_svg = $validated['icon_svg'];
        $processStep->order = $validated['order'] ?? 0;
        $processStep->is_active = $validated['is_active'] ?? true;
        
        $processStep->save();

        return redirect()->route('admin.process-steps.index')
            ->with('success', 'Paso del proceso actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $processStep = ProcessStep::findOrFail($id);
        $processStep->delete();
        
        return redirect()->route('admin.process-steps.index')
            ->with('success', 'Paso del proceso eliminado exitosamente.');
    }
}
