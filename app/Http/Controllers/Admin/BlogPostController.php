<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogPosts = BlogPost::ordered()->paginate(15);
        return view('admin.blog-posts.index', compact('blogPosts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog-posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'featured_image_url' => ['nullable', 'required_without:featured_image_file', 'string', 'url', 'max:500'],
            'featured_image_file' => ['nullable', 'required_without:featured_image_url', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'], // 5MB
            'link' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ], [
            'title.required' => 'El título es obligatorio.',
            'featured_image_url.required_without' => 'Debes proporcionar una URL o subir un archivo de imagen.',
            'featured_image_file.required_without' => 'Debes subir un archivo de imagen o proporcionar una URL.',
            'featured_image_file.image' => 'El archivo debe ser una imagen válida.',
            'featured_image_file.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png, gif o webp.',
            'featured_image_file.max' => 'La imagen no debe ser mayor a 5MB.',
            'featured_image_url.url' => 'La URL de la imagen debe ser una URL válida.',
        ]);

        // Determinar la URL de la imagen
        $imageUrl = null;
        
        if ($request->hasFile('featured_image_file')) {
            // Subir archivo
            $imagePath = $request->file('featured_image_file')->store('blog-posts', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        } elseif ($request->filled('featured_image_url')) {
            // Usar URL
            $imageUrl = $validated['featured_image_url'];
        }

        $blogPost = BlogPost::create([
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'] ?? null,
            'featured_image_url' => $imageUrl,
            'link' => $validated['link'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
            'published_at' => $validated['published_at'] ?? null,
        ]);

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Artículo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blogPost = BlogPost::findOrFail($id);
        return view('admin.blog-posts.show', compact('blogPost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blogPost = BlogPost::findOrFail($id);
        return view('admin.blog-posts.edit', compact('blogPost'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blogPost = BlogPost::findOrFail($id);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'featured_image_url' => ['nullable', 'string', 'max:500'],
            'featured_image_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'], // 5MB
            'link' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ], [
            'title.required' => 'El título es obligatorio.',
            'featured_image_file.image' => 'El archivo debe ser una imagen válida.',
            'featured_image_file.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png, gif o webp.',
            'featured_image_file.max' => 'La imagen no debe ser mayor a 5MB.',
        ]);

        // Determinar la URL de la imagen (solo actualizar si se proporciona una nueva)
        if ($request->hasFile('featured_image_file')) {
            // Eliminar imagen anterior si es un archivo local
            if ($blogPost->featured_image_url && !str_starts_with($blogPost->featured_image_url, 'http')) {
                $oldImagePath = str_replace(asset('storage/'), '', $blogPost->featured_image_url);
                // Limpiar la ruta para obtener solo el path relativo
                $oldImagePath = str_replace('storage/', '', $oldImagePath);
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }
            
            // Subir nuevo archivo
            $imagePath = $request->file('featured_image_file')->store('blog-posts', 'public');
            $blogPost->featured_image_url = asset('storage/' . $imagePath);
        } elseif ($request->filled('featured_image_url') && $request->input('featured_image_url') !== '') {
            // Validar que sea una URL válida si se proporciona
            if (filter_var($request->input('featured_image_url'), FILTER_VALIDATE_URL)) {
                // Solo actualizar si la URL es diferente
                if ($blogPost->featured_image_url !== $request->input('featured_image_url')) {
                    // Eliminar imagen anterior si es un archivo local
                    if ($blogPost->featured_image_url && !str_starts_with($blogPost->featured_image_url, 'http')) {
                        $oldImagePath = str_replace(asset('storage/'), '', $blogPost->featured_image_url);
                        // Limpiar la ruta para obtener solo el path relativo
                        $oldImagePath = str_replace('storage/', '', $oldImagePath);
                        if (Storage::disk('public')->exists($oldImagePath)) {
                            Storage::disk('public')->delete($oldImagePath);
                        }
                    }
                    $blogPost->featured_image_url = $request->input('featured_image_url');
                }
            }
        }
        // Si no se proporciona ni archivo ni URL, mantener la imagen actual

        $blogPost->title = $validated['title'];
        $blogPost->excerpt = $validated['excerpt'] ?? null;
        $blogPost->content = $validated['content'] ?? null;
        $blogPost->link = $validated['link'] ?? null;
        $blogPost->order = $validated['order'] ?? 0;
        $blogPost->is_active = $validated['is_active'] ?? true;
        $blogPost->published_at = $validated['published_at'] ?? null;
        
        $blogPost->save();

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Artículo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blogPost = BlogPost::findOrFail($id);
        $blogPost->delete();
        
        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Artículo eliminado exitosamente.');
    }
}
