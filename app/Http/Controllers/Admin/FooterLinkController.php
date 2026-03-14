<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterLink;
use Illuminate\Http\Request;

class FooterLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $footerLinks = FooterLink::ordered()->paginate(15);
        return view('admin.footer-links.index', compact('footerLinks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.footer-links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:500'],
            'type' => ['required', 'in:link,social'],
            'icon_svg' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'label.required' => 'El texto del enlace es obligatorio.',
            'url.required' => 'La URL es obligatoria.',
            'type.required' => 'El tipo es obligatorio.',
        ]);

        $footerLink = FooterLink::create([
            'label' => $validated['label'],
            'url' => $validated['url'],
            'type' => $validated['type'],
            'icon_svg' => $validated['icon_svg'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('admin.footer-links.index')
            ->with('success', 'Enlace del footer creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $footerLink = FooterLink::findOrFail($id);
        return view('admin.footer-links.show', compact('footerLink'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $footerLink = FooterLink::findOrFail($id);
        return view('admin.footer-links.edit', compact('footerLink'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $footerLink = FooterLink::findOrFail($id);
        
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:500'],
            'type' => ['required', 'in:link,social'],
            'icon_svg' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'label.required' => 'El texto del enlace es obligatorio.',
            'url.required' => 'La URL es obligatoria.',
            'type.required' => 'El tipo es obligatorio.',
        ]);

        $footerLink->label = $validated['label'];
        $footerLink->url = $validated['url'];
        $footerLink->type = $validated['type'];
        $footerLink->icon_svg = $validated['icon_svg'] ?? null;
        $footerLink->order = $validated['order'] ?? 0;
        $footerLink->is_active = $validated['is_active'] ?? true;
        
        $footerLink->save();

        return redirect()->route('admin.footer-links.index')
            ->with('success', 'Enlace del footer actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $footerLink = FooterLink::findOrFail($id);
        $footerLink->delete();
        
        return redirect()->route('admin.footer-links.index')
            ->with('success', 'Enlace del footer eliminado exitosamente.');
    }
}
