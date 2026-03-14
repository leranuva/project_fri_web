<?php
/**
 * index.php para estructura alternativa en Hostinger
 * 
 * Usar cuando NO puedes cambiar el Document Root a la carpeta public/ de Laravel.
 * 
 * INSTRUCCIONES:
 * 1. Sube todo el proyecto Laravel a una carpeta (ej: flat_rate_imports) dentro de public_html
 * 2. Copia ESTE archivo a public_html/index.php
 * 3. Ajusta la variable $laravelPath según la ruta real de tu proyecto
 * 
 * Ejemplo: si Laravel está en public_html/flat_rate_imports/
 *   $laravelPath = __DIR__ . '/flat_rate_imports';
 */

$laravelPath = __DIR__ . '/flat_rate_imports';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$maintenance = $laravelPath . '/storage/framework/maintenance.php';
if (file_exists($maintenance)) {
    require $maintenance;
}

require $laravelPath . '/vendor/autoload.php';

/** @var Application $app */
$app = require_once $laravelPath . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
