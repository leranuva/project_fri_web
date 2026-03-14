<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CotizadorController;
use Illuminate\Support\Facades\Route;

// Página de inicio (pública)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Página de presentación para cliente (temporal)
Route::get('/presentacion', fn () => view('presentacion'))->name('presentacion');

// Cotizador (puede ser público o requerir autenticación según necesidad)
Route::get('/cotizador', [CotizadorController::class, 'index'])->name('cotizador');

// Sitemap (Fase 8)
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// Blog (Fase 8 - para sitemap)
Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show')->where('slug', '[0-9]+-[a-z0-9\-]+');

// Tracking de paquetes (público)
Route::get('/tracking', [\App\Http\Controllers\TrackingController::class, 'index'])->name('tracking.index');
Route::post('/tracking/search', [\App\Http\Controllers\TrackingController::class, 'search'])->name('tracking.search');
Route::get('/tracking/{trackingNumber}', [\App\Http\Controllers\TrackingController::class, 'show'])->name('tracking.show');

// Calculadoras virales (Fase 13.1)
Route::get('/calculadora-aranceles', [\App\Http\Controllers\CalculatorController::class, 'aranceles'])->name('calculator.aranceles');
Route::get('/calculadora-courier-4x4', [\App\Http\Controllers\CalculatorController::class, 'courier4x4'])->name('calculator.courier4x4');
Route::get('/calculadora-amazon-ecuador', [\App\Http\Controllers\CalculatorController::class, 'amazonEcuador'])->name('calculator.amazon');

// Cotización compartida (Fase 13.2)
Route::get('/quote/{token}', [\App\Http\Controllers\QuoteShareController::class, 'show'])->name('quote.show');

// Widget embebible (Fase 14.2)
Route::get('/embed/cotizador', [\App\Http\Controllers\EmbedController::class, 'cotizador'])->name('embed.cotizador');

// API Endpoints para el Cotizador (con rate limiting)
Route::prefix('api/cotizador')->middleware(['throttle:cotizador-api'])->group(function () {
    Route::get('/data', [CotizadorController::class, 'getData'])->name('cotizador.data');
    Route::get('/debug', fn () => response()->json([
        'products_count' => \App\Models\Product::active()->count(),
        'shipping_methods' => \App\Models\ShippingRate::active()->select('method')->distinct()->pluck('method')->toArray(),
    ]))->name('cotizador.debug');
    Route::get('/products', [CotizadorController::class, 'getProducts'])->name('cotizador.products');
    Route::get('/shipping-methods', [CotizadorController::class, 'getActiveShippingMethods'])->name('cotizador.shippingMethods');
    Route::post('/calculate', [CotizadorController::class, 'calculate'])->middleware('throttle:calculate-quotes')->name('cotizador.calculate');
    Route::post('/share', [\App\Http\Controllers\QuoteShareController::class, 'store'])->name('cotizador.share');
});

// Dashboard (requiere autenticación)
Route::get('/dashboard', function () {
    $user = auth()->user();
    $stats = null;
    $analytics = null;

    if ($user->role === 'admin') {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'admin_users' => \App\Models\User::where('role', 'admin')->count(),
            'customer_users' => \App\Models\User::where('role', 'customer')->count(),
            'total_products' => \App\Models\Product::count(),
        ];

        // Analytics de cotizaciones
        $analytics = [
            'quotes_today' => \App\Models\Quote::whereDate('created_at', today())->count(),
            'quotes_this_week' => \App\Models\Quote::where('created_at', '>=', now()->startOfWeek())->count(),
            'quotes_total' => \App\Models\Quote::count(),
            'top_products' => \App\Models\Quote::select('product_key')
                ->selectRaw('count(*) as total')
                ->groupBy('product_key')
                ->orderByDesc('total')
                ->limit(5)
                ->get(),
            'top_shipping_methods' => \App\Models\Quote::select('shipping_method')
                ->selectRaw('count(*) as total')
                ->groupBy('shipping_method')
                ->orderByDesc('total')
                ->get(),
            'avg_total' => \App\Models\Quote::avg('total'),
        ];
    }

    return view('dashboard', compact('stats', 'analytics'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de perfil, cotizaciones y paquetes (requieren autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/mis-cotizaciones', [\App\Http\Controllers\QuoteHistoryController::class, 'index'])->name('quotes.index');
    Route::get('/pagar/{quote}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payments.show');
    Route::post('/pagar/{quote}', [\App\Http\Controllers\PaymentController::class, 'process'])->name('payments.process');
    Route::get('/mis-paquetes', [\App\Http\Controllers\PackageHistoryController::class, 'index'])->name('packages.index');
    Route::post('/mis-paquetes', [\App\Http\Controllers\PackageHistoryController::class, 'store'])->name('packages.store');
    Route::get('/mis-paquetes/{trackingNumber}', [\App\Http\Controllers\PackageHistoryController::class, 'show'])->name('packages.show');
    Route::post('/mis-paquetes/{trackingNumber}/refresh', [\App\Http\Controllers\PackageHistoryController::class, 'refresh'])->name('packages.refresh');
});

// Rutas de administración (requieren autenticación y rol admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('shipping-rates', \App\Http\Controllers\Admin\ShippingRateController::class);
    Route::resource('tax-rates', \App\Http\Controllers\Admin\TaxRateController::class);
    Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class);
    Route::resource('process-steps', \App\Http\Controllers\Admin\ProcessStepController::class);
    Route::resource('alert-banners', \App\Http\Controllers\Admin\AlertBannerController::class);
    Route::resource('benefits', \App\Http\Controllers\Admin\BenefitController::class);
    Route::resource('packages', \App\Http\Controllers\Admin\PackageController::class);
    Route::resource('themes', \App\Http\Controllers\Admin\ThemeController::class);
    Route::post('themes/{id}/activate', [\App\Http\Controllers\Admin\ThemeController::class, 'activate'])->name('themes.activate');
    Route::get('process-sections', [\App\Http\Controllers\Admin\ProcessSectionController::class, 'index'])->name('process-sections.index');
    Route::patch('process-sections/{id}', [\App\Http\Controllers\Admin\ProcessSectionController::class, 'update'])->name('process-sections.update');
    Route::get('benefit-sections', [\App\Http\Controllers\Admin\BenefitSectionController::class, 'index'])->name('benefit-sections.index');
    Route::patch('benefit-sections/{id}', [\App\Http\Controllers\Admin\BenefitSectionController::class, 'update'])->name('benefit-sections.update');
    Route::resource('stores', \App\Http\Controllers\Admin\StoreController::class);
    Route::get('store-sections', [\App\Http\Controllers\Admin\StoreSectionController::class, 'index'])->name('store-sections.index');
    Route::patch('store-sections/{id}', [\App\Http\Controllers\Admin\StoreSectionController::class, 'update'])->name('store-sections.update');
    Route::resource('logos', \App\Http\Controllers\Admin\LogoController::class);
    Route::post('logos/{id}/activate', [\App\Http\Controllers\Admin\LogoController::class, 'activate'])->name('logos.activate');
    Route::resource('blog-posts', \App\Http\Controllers\Admin\BlogPostController::class);
    Route::get('blog-sections', [\App\Http\Controllers\Admin\BlogSectionController::class, 'index'])->name('blog-sections.index');
    Route::patch('blog-sections/{id}', [\App\Http\Controllers\Admin\BlogSectionController::class, 'update'])->name('blog-sections.update');
    Route::resource('footer-links', \App\Http\Controllers\Admin\FooterLinkController::class);
    Route::get('footer-sections', [\App\Http\Controllers\Admin\FooterSectionController::class, 'index'])->name('footer-sections.index');
    Route::patch('footer-sections/{id}', [\App\Http\Controllers\Admin\FooterSectionController::class, 'update'])->name('footer-sections.update');
    Route::get('cotizador-sections', [\App\Http\Controllers\Admin\CotizadorSectionController::class, 'index'])->name('cotizador-sections.index');
    Route::patch('cotizador-sections/{id}', [\App\Http\Controllers\Admin\CotizadorSectionController::class, 'update'])->name('cotizador-sections.update');
    Route::get('dashboard-guide', [\App\Http\Controllers\Admin\DashboardGuideController::class, 'index'])->name('dashboard-guide.index');
    Route::get('project-costs', [\App\Http\Controllers\Admin\ProjectCostsController::class, 'index'])->name('project-costs.index');
    Route::resource('seo-pages', \App\Http\Controllers\Admin\SeoPageController::class);
    Route::get('leads', [\App\Http\Controllers\Admin\LeadController::class, 'index'])->name('leads.index');
});

require __DIR__.'/auth.php';

// Fallback: Páginas SEO dinámicas (Fase 9) - solo si no coincide con ninguna ruta
Route::fallback([\App\Http\Controllers\SeoPageController::class, 'showFallback']);
