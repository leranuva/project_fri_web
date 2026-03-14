<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $sliders = Slider::active()->ordered()->get();
        $processSteps = \App\Models\ProcessStep::active()->ordered()->get();
        $alertBanner = \App\Models\AlertBanner::active()->first();
        $processSection = \App\Models\ProcessSection::getActive();
        $benefits = \App\Models\Benefit::active()->ordered()->get();
        $benefitSection = \App\Models\BenefitSection::getActive();
        $stores = \App\Models\Store::active()->ordered()->get();
        $storeSection = \App\Models\StoreSection::getActive();
        $blogPosts = \App\Models\BlogPost::active()->ordered()->limit(3)->get();
        $blogSection = \App\Models\BlogSection::getActive();
        
        // Si no hay process steps, usar colección vacía (la vista tiene fallback)
        if ($processSteps->isEmpty()) {
            $processSteps = collect([]);
        }
        
        // Si no hay benefits, usar colección vacía (la vista tiene fallback)
        if ($benefits->isEmpty()) {
            $benefits = collect([]);
        }
        
        // Si no hay stores, usar colección vacía (la vista tiene fallback)
        if ($stores->isEmpty()) {
            $stores = collect([]);
        }
        
        // Si no hay blog posts, usar colección vacía (la vista tiene fallback)
        if ($blogPosts->isEmpty()) {
            $blogPosts = collect([]);
        }
        
        return view('home', compact('sliders', 'processSteps', 'alertBanner', 'processSection', 'benefits', 'benefitSection', 'stores', 'storeSection', 'blogPosts', 'blogSection'));
    }
}
