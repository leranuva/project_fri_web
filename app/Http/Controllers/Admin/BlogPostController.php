<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

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
            'featured_image_url' => ['nullable', 'url', 'max:500'],
            'link' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ], [
            'title.required' => 'El título es obligatorio.',
            'featured_image_url.url' => 'La URL de la imagen debe ser una URL válida.',
        ]);

        $blogPost = BlogPost::create([
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'] ?? null,
            'featured_image_url' => $validated['featured_image_url'] ?? null,
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
            'featured_image_url' => ['nullable', 'url', 'max:500'],
            'link' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ], [
            'title.required' => 'El título es obligatorio.',
            'featured_image_url.url' => 'La URL de la imagen debe ser una URL válida.',
        ]);

        $blogPost->title = $validated['title'];
        $blogPost->excerpt = $validated['excerpt'] ?? null;
        $blogPost->content = $validated['content'] ?? null;
        $blogPost->featured_image_url = $validated['featured_image_url'] ?? null;
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
