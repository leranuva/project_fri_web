<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::active()->published()->ordered()->paginate(12);
        $blogSection = \App\Models\BlogSection::getActive();

        return view('blog.index', compact('posts', 'blogSection'));
    }

    public function show(string $slug)
    {
        $parts = explode('-', $slug, 2);
        $id = (int) ($parts[0] ?? 0);

        $post = BlogPost::active()->published()->find($id);

        if (!$post) {
            abort(404);
        }

        $seoTitle = $post->title . ' | ' . config('app.name');
        $seoDescription = $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 160);
        $seoImage = $post->featured_image_url ?? config('seo.default_image');
        $blogSection = \App\Models\BlogSection::getActive();

        return view('blog.show', compact('post', 'blogSection', 'seoTitle', 'seoDescription', 'seoImage'));
    }
}
