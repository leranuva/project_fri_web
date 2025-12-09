<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectCostsController extends Controller
{
    /**
     * Display the project costs presentation.
     */
    public function index()
    {
        return view('admin.project-costs.index');
    }
}

