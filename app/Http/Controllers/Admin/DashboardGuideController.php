<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardGuideController extends Controller
{
    /**
     * Display the interactive dashboard guide.
     */
    public function index()
    {
        return view('admin.dashboard-guide.index');
    }
}
