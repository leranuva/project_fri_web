<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

abstract class BaseAdminController extends Controller
{
    /**
     * Número de elementos por página en listados
     */
    protected int $perPage = 15;

    /**
     * Nombre de la ruta base para redirects (ej: admin.products)
     */
    abstract protected function getResourceName(): string;

    /**
     * Paginar query con parámetros de búsqueda preservados
     */
    protected function paginate(Builder $query, int $perPage = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $query->latest()->paginate($perPage ?? $this->perPage)->withQueryString();
    }

    /**
     * Redirect exitoso después de create/update
     */
    protected function redirectSuccess(string $message = 'Operación completada exitosamente.'): RedirectResponse
    {
        return redirect()->route("admin.{$this->getResourceName()}.index")
            ->with('success', $message);
    }

    /**
     * Redirect con error
     */
    protected function redirectError(string $message, string $route = null): RedirectResponse
    {
        $route = $route ?? "admin.{$this->getResourceName()}.index";

        return redirect()->route($route)
            ->with('error', $message);
    }
}
