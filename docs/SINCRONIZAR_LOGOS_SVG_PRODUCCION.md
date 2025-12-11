# 🔄 Sincronizar Logos SVG de Desarrollo a Producción

## 🎯 Problema
Los logos SVG se agregaron manualmente en desarrollo (local) pero no aparecen en producción (Hostinger).

## 💡 Solución: Exportar e Importar desde Base de Datos

Los logos están guardados en la tabla `stores` en el campo `logo_url`. Necesitas sincronizar estos datos.

---

## 📋 Opción 1: Exportar/Importar SQL (Recomendado)

### Paso 1: Exportar desde Desarrollo (Local)

En tu máquina local, ejecuta:

```bash
# Exportar solo los logos de la tabla stores
php artisan tinker
```

Luego en tinker:
```php
$stores = \App\Models\Store::all();
foreach ($stores as $store) {
    if ($store->logo_url) {
        echo "UPDATE stores SET logo_url = " . DB::getPdo()->quote($store->logo_url) . " WHERE name = " . DB::getPdo()->quote($store->name) . ";\n";
    }
}
exit
```

O más simple, crea un archivo SQL:

```bash
# En tu máquina local
php artisan db:export-stores-logos
```

O manualmente desde phpMyAdmin/MySQL:
```sql
SELECT name, logo_url FROM stores WHERE logo_url IS NOT NULL;
```

### Paso 2: Importar en Producción (Hostinger)

**Opción A: Por SSH (Recomendado)**

1. Crea un archivo `update_logos.sql` con los UPDATE statements
2. Súbelo a Hostinger
3. Ejecuta:

```bash
cd domains/leranuva.com/public_html
mysql -u [usuario] -p[password] [nombre_bd] < update_logos.sql
```

**Opción B: Por phpMyAdmin**
1. Accede a phpMyAdmin en Hostinger
2. Selecciona la base de datos
3. Ve a la tabla `stores`
4. Ejecuta los UPDATE statements manualmente

---

## 📋 Opción 2: Usar Tinker en Producción

### Paso 1: Obtener los logos desde desarrollo

En tu máquina local, ejecuta:

```bash
php artisan tinker
```

```php
$stores = \App\Models\Store::whereNotNull('logo_url')->get(['name', 'logo_url']);
$stores->each(function($store) {
    echo "'" . $store->name . "' => '" . addslashes($store->logo_url) . "',\n";
});
exit
```

Copia la salida.

### Paso 2: Actualizar en producción por SSH

```bash
cd domains/leranuva.com/public_html
php artisan tinker
```

Luego pega y ejecuta (ajusta los valores):

```php
$logos = [
    'Amazon' => '<svg>...</svg>',
    'eBay' => '<svg>...</svg>',
    // ... todos los logos
];

foreach ($logos as $name => $logo) {
    \App\Models\Store::where('name', $name)->update(['logo_url' => $logo]);
}
exit
```

---

## 📋 Opción 3: Actualizar desde Panel de Administración

1. Accede al panel de administración en producción: `/admin/stores`
2. Edita cada tienda manualmente
3. Pega el código SVG en el campo "Logo URL"
4. Guarda

---

## 📋 Opción 4: Crear Script de Migración Temporal

### En Desarrollo (Local)

Crea `database/migrations/2025_12_11_000000_update_store_logos.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Aquí pegas los logos desde tu base de datos local
        $logos = [
            'Amazon' => '<svg>...</svg>',
            'eBay' => '<svg>...</svg>',
            // ... todos los logos
        ];

        foreach ($logos as $name => $logo) {
            DB::table('stores')
                ->where('name', $name)
                ->update(['logo_url' => $logo]);
        }
    }

    public function down(): void
    {
        // Revertir si es necesario
        DB::table('stores')->update(['logo_url' => null]);
    }
};
```

Luego en producción:
```bash
php artisan migrate
```

---

## 🔍 Verificar que los Logos se Actualizaron

### Por SSH:
```bash
cd domains/leranuva.com/public_html
php artisan tinker
```

```php
\App\Models\Store::whereNotNull('logo_url')->get(['name', 'logo_url'])->each(function($store) {
    echo $store->name . ": " . (strlen($store->logo_url) > 0 ? "✓ Tiene logo (" . strlen($store->logo_url) . " caracteres)\n" : "✗ Sin logo\n");
});
exit
```

### Por Base de Datos:
```sql
SELECT name, 
       CASE 
           WHEN logo_url IS NOT NULL AND logo_url != '' THEN 'Tiene logo'
           ELSE 'Sin logo'
       END as estado,
       LENGTH(logo_url) as tamaño
FROM stores;
```

---

## ✅ Después de Actualizar

1. **Limpiar caché:**
```bash
php artisan cache:clear
php artisan view:clear
php artisan view:cache
```

2. **Verificar en el navegador:**
   - Ir a la página de inicio
   - Verificar que los logos se muestran
   - Limpiar caché del navegador (Ctrl + F5)

---

## 🚨 Nota Importante

Los logos SVG pueden ser muy largos. Asegúrate de:
- Que el campo `logo_url` en la tabla `stores` sea de tipo `TEXT` o `LONGTEXT`
- Que no haya límites de tamaño en la base de datos
- Que los SVG estén correctamente escapados (usar `addslashes()` o `DB::getPdo()->quote()`)

---

## 📝 Método Más Rápido (Recomendado)

1. **En desarrollo:** Exporta los logos a un archivo JSON o SQL
2. **En producción:** Importa ese archivo o ejecuta los UPDATE statements

¿Quieres que te ayude a generar el script SQL o el código para tinker con tus logos específicos?

