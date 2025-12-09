<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CotizadorController;
use Illuminate\Support\Facades\Route;

// Página de inicio (pública)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Cotizador (puede ser público o requerir autenticación según necesidad)
Route::get('/cotizador', [CotizadorController::class, 'index'])->name('cotizador');

// Tracking de paquetes (público)
Route::get('/tracking', [\App\Http\Controllers\TrackingController::class, 'index'])->name('tracking.index');
Route::post('/tracking/search', [\App\Http\Controllers\TrackingController::class, 'search'])->name('tracking.search');
Route::get('/tracking/{trackingNumber}', [\App\Http\Controllers\TrackingController::class, 'show'])->name('tracking.show');

// API Endpoints para el Cotizador
Route::prefix('api/cotizador')->group(function () {
    Route::post('/calculate', [CotizadorController::class, 'calculate'])->name('cotizador.calculate');
    Route::get('/products', [CotizadorController::class, 'getProducts'])->name('cotizador.products');
    Route::get('/shipping-methods', [CotizadorController::class, 'getActiveShippingMethods'])->name('cotizador.shippingMethods');
    Route::post('/send-email', [CotizadorController::class, 'sendEmail'])->name('cotizador.sendEmail');
});

// Dashboard (requiere autenticación)
Route::get('/dashboard', function () {
    $stats = [
        'total_users' => \App\Models\User::count(),
        'admin_users' => \App\Models\User::where('role', 'admin')->count(),
        'customer_users' => \App\Models\User::where('role', 'customer')->count(),
        'total_products' => \App\Models\Product::count(),
    ];
    
    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de perfil (requieren autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
});

require __DIR__.'/auth.php';
