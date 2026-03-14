<?php

namespace App\Providers;

use App\Events\LeadCreated;
use App\Listeners\SendLeadToWebhook;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\Cotizador\QuoteCalculator::class, function ($app) {
            return new \App\Services\Cotizador\QuoteCalculator(
                $app->make(\App\Services\Cotizador\ShippingCalculator::class),
                $app->make(\App\Services\Cotizador\TaxCalculator::class),
                $app->make(\App\Services\Cotizador\InsuranceCalculator::class),
                $app->make(\App\Services\Cotizador\TotalCalculator::class),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        // Registrar listeners de eventos
        Event::listen(Verified::class, SendWelcomeEmail::class);
        Event::listen(LeadCreated::class, SendLeadToWebhook::class);
        
        // Compartir el tema activo, logo activo y datos del footer con todas las vistas
        view()->composer('*', function ($view) {
            $activeTheme = \App\Models\Theme::getActive();
            $activeLogo = \App\Models\Logo::getActive();
            $footerSection = \App\Models\FooterSection::getActive();
            $footerLinksForFooter = \App\Models\FooterLink::active()->links()->ordered()->get();
            $footerSocials = \App\Models\FooterLink::active()->social()->ordered()->get();

            // SEO: valores por defecto (Fase 8) - las vistas pueden sobrescribir con @section o variables
            $seoTitle = $view->getData()['seoTitle'] ?? config('seo.default_title');
            $seoDescription = $view->getData()['seoDescription'] ?? config('seo.default_description');
            $seoImage = $view->getData()['seoImage'] ?? \App\Helpers\SeoHelper::image();

            $view->with('activeTheme', $activeTheme);
            $view->with('activeLogo', $activeLogo);
            $view->with('footerSection', $footerSection);
            $view->with('footerLinksForFooter', $footerLinksForFooter);
            $view->with('footerSocials', $footerSocials);
            $view->with('seoTitle', $seoTitle);
            $view->with('seoDescription', $seoDescription);
            $view->with('seoImage', $seoImage);
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // Cotizador: 30 cálculos por minuto por IP
        RateLimiter::for('calculate-quotes', function (Request $request) {
            return Limit::perMinute(30)->by($request->ip());
        });

        // API cotizador general: 60 requests/min para products y shipping-methods
        RateLimiter::for('cotizador-api', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });
    }
}
