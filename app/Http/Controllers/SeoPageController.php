<?php

namespace App\Http\Controllers;

use App\Models\SeoPage;
use Illuminate\Http\Request;

class SeoPageController extends Controller
{
    /**
     * Fallback: intentar mostrar página SEO si el slug existe
     */
    public function showFallback(Request $request)
    {
        $slug = $request->path();

        // Excluir paths que no son slugs SEO (contienen /)
        if (str_contains($slug, '/')) {
            abort(404);
        }

        return $this->show($slug);
    }

    /**
     * Mostrar página SEO dinámica (Fase 9)
     */
    public function show(string $slug)
    {
        $page = SeoPage::findBySlug($slug);

        if (!$page) {
            abort(404);
        }

        return view('seo.show', compact('page'));
    }
}
