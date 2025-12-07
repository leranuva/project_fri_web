<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Compartir el tema activo y datos del footer con todas las vistas
        view()->composer('*', function ($view) {
            $activeTheme = \App\Models\Theme::getActive();
            $footerSection = \App\Models\FooterSection::getActive();
            $footerLinksForFooter = \App\Models\FooterLink::active()->links()->ordered()->get();
            $footerSocials = \App\Models\FooterLink::active()->social()->ordered()->get();
            
            $view->with('activeTheme', $activeTheme);
            $view->with('footerSection', $footerSection);
            $view->with('footerLinksForFooter', $footerLinksForFooter);
            $view->with('footerSocials', $footerSocials);
        });
    }
}
