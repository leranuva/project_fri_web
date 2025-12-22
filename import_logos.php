<?php

/**
 * Script para importar logos SVG de tiendas desde store_logos.json
 * 
 * USO:
 * 1. Sube store_logos.json a storage/app/
 * 2. Ejecuta: php import_logos.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Store;
use Illuminate\Support\Facades\File;

echo "📥 Importando logos de tiendas...\n\n";

$filepath = storage_path('app/store_logos.json');

if (!File::exists($filepath)) {
    echo "❌ El archivo no existe: {$filepath}\n";
    echo "💡 Asegúrate de subir store_logos.json a: storage/app/\n";
    exit(1);
}

$content = File::get($filepath);
$data = json_decode($content, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo "❌ Error al decodificar el archivo JSON: " . json_last_error_msg() . "\n";
    exit(1);
}

if (empty($data)) {
    echo "⚠️  El archivo está vacío.\n";
    exit(1);
}

$updated = 0;
$notFound = 0;

foreach ($data as $item) {
    if (!isset($item['name']) || !isset($item['logo_url'])) {
        echo "⚠️  Item inválido: " . json_encode($item) . "\n";
        continue;
    }

    $store = Store::where('name', $item['name'])->first();

    if ($store) {
        $store->update(['logo_url' => $item['logo_url']]);
        $updated++;
        echo "  ✓ Actualizado: {$item['name']}\n";
    } else {
        $notFound++;
        echo "  ⚠️  Tienda no encontrada: {$item['name']}\n";
    }
}

echo "\n✅ Importación completada!\n";
echo "📊 Total actualizado: {$updated}\n";

if ($notFound > 0) {
    echo "⚠️  Tiendas no encontradas: {$notFound}\n";
}

echo "\n🔄 Limpia la caché con: php artisan view:clear && php artisan view:cache\n";



