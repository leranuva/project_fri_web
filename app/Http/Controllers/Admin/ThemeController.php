<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveThemeRequest;
use App\Models\Theme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::orderByDesc('is_active')->orderByDesc('published_at')->orderByDesc('id')->paginate(15);
        $previousTheme = Theme::where('is_active', false)->whereNotNull('published_at')
            ->orderByDesc('published_at')->orderByDesc('id')->first();

        return view('admin.themes.index', compact('themes', 'previousTheme'));
    }

    public function create()
    {
        return view('admin.themes.create');
    }

    public function store(SaveThemeRequest $request)
    {
        $theme = Theme::create($request->paletteData() + ['is_active' => false]);

        return redirect()->route('admin.themes.show', $theme)->with('success', 'Borrador guardado.');
    }

    public function show(Theme $theme)
    {
        return view('admin.themes.show', compact('theme'));
    }

    public function edit(Theme $theme)
    {
        abort_if($theme->published_at || $theme->is_active, 409, 'Duplica el tema publicado para editarlo.');

        return view('admin.themes.edit', compact('theme'));
    }

    public function update(SaveThemeRequest $request, Theme $theme)
    {
        DB::transaction(function () use ($request, $theme): void {
            $draft = Theme::whereKey($theme->getKey())->lockForUpdate()->firstOrFail();
            abort_if($draft->published_at || $draft->is_active, 409, 'Duplica el tema publicado para editarlo.');
            $draft->update($request->paletteData());
        }, 3);

        return redirect()->route('admin.themes.show', $theme)->with('success', 'Borrador actualizado.');
    }

    public function duplicate(Theme $theme)
    {
        $draft = $theme->replicate(['published_at']);
        $draft->name = Str::limit($theme->name, 244, '') . ' · copia';
        $draft->is_active = false;
        $draft->saveOrFail();

        return redirect()->route('admin.themes.edit', $draft)->with('success', 'Copia creada como borrador.');
    }

    public function destroy(Theme $theme)
    {
        $deleted = DB::transaction(function () use ($theme): bool {
            $draft = Theme::whereKey($theme->getKey())->lockForUpdate()->firstOrFail();

            return ! $draft->published_at && ! $draft->is_active && $draft->delete();
        }, 3);

        return redirect()->route('admin.themes.index')->with(
            $deleted ? 'success' : 'error',
            $deleted ? 'Borrador eliminado.' : 'Los temas publicados se conservan en el historial.',
        );
    }

    public function activate(Theme $theme)
    {
        $restoring = $theme->published_at && ! $theme->is_active;
        $theme->activate();

        return redirect()->route('admin.themes.index')->with('success', $restoring ? 'Tema restaurado.' : 'Tema publicado.');
    }
}
