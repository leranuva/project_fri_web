<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::query();
        if ($request->filled('search')) {
            $s = $request->get('search');
            $query->where(function ($q) use ($s) {
                $q->where('email', 'like', "%{$s}%")
                    ->orWhere('producto', 'like', "%{$s}%")
                    ->orWhere('pais', 'like', "%{$s}%");
            });
        }
        if ($request->filled('min_score')) {
            $query->where('score', '>=', (int) $request->get('min_score'));
        }
        $leads = $query->orderByDesc('score')->latest()->paginate(20)->withQueryString();
        return view('admin.leads.index', compact('leads'));
    }
}
