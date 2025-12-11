# 📤 Exportar Logos SVG desde Desarrollo

## 🎯 Objetivo
Obtener los logos SVG que agregaste manualmente en desarrollo para importarlos en producción.

---

## 📋 Método 1: Usando Tinker (Más Fácil)

### Paso 1: En tu máquina local (Desarrollo)

Ejecuta:

```bash
php artisan tinker
```

Luego ejecuta este comando:

```php
\App\Models\Store::whereNotNull('logo_url')->get(['name', 'logo_url'])->each(function($store) {
    echo "UPDATE stores SET logo_url = " . DB::getPdo()->quote($store->logo_url) . " WHERE name = " . DB::getPdo()->quote($store->name) . ";\n";
});
exit
```

**Copia toda la salida** (los comandos UPDATE).

### Paso 2: En Producción (Hostinger)

1. Crea un archivo `update_logos.sql` con los comandos UPDATE que copiaste
2. Súbelo a Hostinger
3. Ejecuta por SSH:

```bash
cd domains/leranuva.com/public_html
mysql -u [usuario_bd] -p[nombre_bd] < update_logos.sql
```

O ejecuta los UPDATE directamente:

```bash
php artisan tinker
```

Pega los comandos UPDATE (sin el `UPDATE` inicial, solo los valores):

```php
DB::table('stores')->where('name', 'Amazon')->update(['logo_url' => '<svg>...</svg>']);
DB::table('stores')->where('name', 'eBay')->update(['logo_url' => '<svg>...</svg>']);
// ... todos los logos
exit
```

---

## 📋 Método 2: Exportar a JSON

### Paso 1: En Desarrollo

```bash
php artisan tinker
```

```php
$stores = \App\Models\Store::whereNotNull('logo_url')->get(['name', 'logo_url']);
file_put_contents('store_logos.json', $stores->toJson(JSON_PRETTY_PRINT));
echo "Logos exportados a store_logos.json\n";
exit
```

### Paso 2: Importar en Producción

1. Sube el archivo `store_logos.json` a Hostinger
2. Ejecuta:

```bash
cd domains/leranuva.com/public_html
php artisan tinker
```

```php
$logos = json_decode(file_get_contents('store_logos.json'), true);
foreach ($logos as $item) {
    \App\Models\Store::where('name', $item['name'])->update(['logo_url' => $item['logo_url']]);
    echo "Actualizado: {$item['name']}\n";
}
exit
```

---

## 📋 Método 3: Usando el Seeder (Recomendado)

### Paso 1: En Desarrollo

```bash
php artisan tinker
```

```php
$stores = \App\Models\Store::whereNotNull('logo_url')->get(['name', 'logo_url']);
$stores->each(function($store) {
    echo "'" . $store->name . "' => " . var_export($store->logo_url, true) . ",\n";
});
exit
```

### Paso 2: En Producción

1. Edita `database/seeders/UpdateStoreLogosSeeder.php`
2. Pega los logos en el array `$logos`
3. Ejecuta:

```bash
php artisan db:seed --class=UpdateStoreLogosSeeder
```

---

## 📋 Método 4: Exportar SQL Directo

### En Desarrollo

```bash
php artisan tinker
```

```php
$stores = \App\Models\Store::whereNotNull('logo_url')->get();
$sql = "START TRANSACTION;\n";
foreach ($stores as $store) {
    $logo = addslashes($store->logo_url);
    $name = addslashes($store->name);
    $sql .= "UPDATE stores SET logo_url = '{$logo}' WHERE name = '{$name}';\n";
}
$sql .= "COMMIT;\n";
file_put_contents('update_logos.sql', $sql);
echo "SQL exportado a update_logos.sql\n";
exit
```

Luego sube `update_logos.sql` a Hostinger y ejecuta:

```bash
mysql -u [usuario] -p[nombre_bd] < update_logos.sql
```

---

## ✅ Verificar Exportación

En desarrollo, verifica que tienes los logos:

```bash
php artisan tinker
```

```php
\App\Models\Store::whereNotNull('logo_url')->count();
// Debería mostrar el número de tiendas con logos
exit
```

---

## 🚀 Método Más Rápido (Recomendado)

**Opción A: Copiar y Pegar Manualmente**

1. En desarrollo, ve a `/admin/stores`
2. Abre cada tienda que tiene logo
3. Copia el código SVG
4. En producción, ve a `/admin/stores`
5. Pega el código SVG en cada tienda
6. Guarda

**Opción B: Usar el Método 1 (Tinker con UPDATE)**

Es el más rápido y seguro.

---

## ⚠️ Nota Importante

Los SVG pueden ser muy largos. Asegúrate de:
- Usar `DB::getPdo()->quote()` o `addslashes()` para escapar comillas
- Verificar que el campo `logo_url` acepta texto largo (debería ser TEXT o LONGTEXT)

---

¿Cuál método prefieres usar? Te recomiendo el **Método 1** (Tinker con UPDATE) porque es el más directo.

