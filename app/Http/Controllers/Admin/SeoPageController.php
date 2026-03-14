<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SeoPage;
use Illuminate\Http\Request;

class SeoPageController extends Controller
{
    public function index(Request $request)
    {
        $query = SeoPage::query();
        if ($request->filled('search')) {
            $s = $request->get('search');
            $query->where(function ($q) use ($s) {
                $q->where('keyword', 'like', "%{$s}%")
                    ->orWhere('slug', 'like', "%{$s}%")
                    ->orWhere('title', 'like', "%{$s}%");
            });
        }
        $seoPages = $query->latest()->paginate(15)->withQueryString();
        return view('admin.seo-pages.index', compact('seoPages'));
    }

    public function create()
    {
        $products = Product::active()->ordered()->get();
        return view('admin.seo-pages.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'keyword' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:seo_pages,slug',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'product_id' => 'nullable|exists:products,id',
            'store_link' => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        SeoPage::create($validated);
        return redirect()->route('admin.seo-pages.index')->with('success', 'Página SEO creada.');
    }

    public function show(SeoPage $seoPage)
    {
        return view('admin.seo-pages.show', compact('seoPage'));
    }

    public function edit(SeoPage $seoPage)
    {
        $products = Product::active()->ordered()->get();
        return view('admin.seo-pages.edit', compact('seoPage', 'products'));
    }

    public function update(Request $request, SeoPage $seoPage)
    {
        $validated = $request->validate([
            'keyword' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:seo_pages,slug,' . $seoPage->id,
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'product_id' => 'nullable|exists:products,id',
            'store_link' => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        $seoPage->update($validated);
        return redirect()->route('admin.seo-pages.index')->with('success', 'Página SEO actualizada.');
    }

    public function destroy(SeoPage $seoPage)
    {
        $seoPage->delete();
        return redirect()->route('admin.seo-pages.index')->with('success', 'Página SEO eliminada.');
    }
}
