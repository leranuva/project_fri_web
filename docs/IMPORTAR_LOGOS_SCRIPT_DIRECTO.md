# 📥 Importar Logos con Script Directo

## 🎯 Solución Rápida

Como los comandos artisan no están en producción, usa este script PHP directo.

---

## 📤 Paso 1: Subir Archivos

Sube estos 2 archivos a Hostinger:

1. **`storage/app/store_logos.json`** → Subir a `storage/app/store_logos.json`
2. **`import_logos.php`** → Subir a la raíz del proyecto (`public_html/import_logos.php`)

---

## 📥 Paso 2: Ejecutar en Producción

Por SSH, ejecuta:

```bash
cd domains/leranuva.com/public_html
php import_logos.php
```

**Salida esperada:**
```
📥 Importando logos de tiendas...

  ✓ Actualizado: Amazon
  ✓ Actualizado: eBay
  ✓ Actualizado: Walmart
  ...

✅ Importación completada!
📊 Total actualizado: 12
```

---

## 🔄 Paso 3: Limpiar Caché

```bash
php artisan view:clear
php artisan view:cache
```

---

## ✅ Verificar

```bash
php artisan tinker
```

```php
\App\Models\Store::whereNotNull('logo_url')->count();
// Debería mostrar: 12
exit
```

---

## 🗑️ Paso 4: Eliminar Script (Opcional)

Después de importar, puedes eliminar el script por seguridad:

```bash
rm import_logos.php
```

---

## 🆘 Si hay Errores

### Error: "El archivo no existe"
```bash
# Verificar que el archivo está en la ubicación correcta
ls -la storage/app/store_logos.json

# Si no está, verificar la ruta completa
find . -name "store_logos.json"
```

### Error: "Error al decodificar JSON"
```bash
# Verificar que el archivo JSON es válido
php -r "json_decode(file_get_contents('storage/app/store_logos.json')); echo json_last_error() === JSON_ERROR_NONE ? 'JSON válido' : 'JSON inválido';"
```

### Error: "Tienda no encontrada"
Verifica que los nombres de las tiendas coincidan exactamente con los de la base de datos.

---

## ✅ ¡Listo!

Con este script, **no necesitas los comandos artisan**. Solo:
1. ✅ Subir 2 archivos
2. ✅ Ejecutar el script
3. ✅ Limpiar caché

**¡Mucho más simple!** 🎉



