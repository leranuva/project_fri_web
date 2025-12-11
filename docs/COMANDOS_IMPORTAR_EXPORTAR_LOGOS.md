# 🚀 Comandos para Importar/Exportar Logos SVG

## ✅ Solución Automática - Ya está listo!

He creado dos comandos artisan que hacen todo automáticamente. **No necesitas hacer nada manualmente.**

---

## 📤 Paso 1: Exportar desde Desarrollo (Local)

En tu máquina local, ejecuta:

```bash
php artisan stores:export-logos
```

Esto creará el archivo: `storage/app/store_logos.json`

**Salida esperada:**
```
📤 Exportando logos de tiendas...
✅ Logos exportados exitosamente a: C:\xampp\htdocs\web_fri_pro\storage\app/store_logos.json
📊 Total de logos exportados: 12
```

---

## 📥 Paso 2: Subir Archivo a Producción

Sube el archivo `storage/app/store_logos.json` a Hostinger en la misma ubicación:
- `storage/app/store_logos.json`

---

## 📥 Paso 3: Importar en Producción (Hostinger)

Conéctate por SSH y ejecuta:

```bash
cd domains/leranuva.com/public_html

# Importar los logos
php artisan stores:import-logos

# Limpiar caché
php artisan view:clear
php artisan view:cache
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

## ✅ Verificar en Producción

```bash
php artisan tinker
```

```php
\App\Models\Store::whereNotNull('logo_url')->count();
// Debería mostrar: 12
exit
```

---

## 🎯 Resumen Rápido

### En Desarrollo:
```bash
php artisan stores:export-logos
```
→ Sube `storage/app/store_logos.json` a Hostinger

### En Producción:
```bash
php artisan stores:import-logos
php artisan view:clear
php artisan view:cache
```

---

## 🔧 Opciones Avanzadas

### Exportar con nombre personalizado:
```bash
php artisan stores:export-logos --file=mis_logos.json
```

### Importar desde archivo personalizado:
```bash
php artisan stores:import-logos --file=mis_logos.json
```

---

## ⚠️ Notas Importantes

1. **Ubicación del archivo**: El archivo debe estar en `storage/app/` tanto en desarrollo como en producción.

2. **Permisos**: Asegúrate de que `storage/app/` tenga permisos de escritura en producción:
   ```bash
   chmod -R 755 storage/app
   ```

3. **Caché**: Siempre limpia la caché después de importar:
   ```bash
   php artisan view:clear
   php artisan view:cache
   ```

---

## 🆘 Solución de Problemas

### Si el archivo no se encuentra en producción:
```bash
# Verificar que el archivo existe
ls -la storage/app/store_logos.json

# Si no existe, verificar la ruta completa
find . -name "store_logos.json"
```

### Si hay errores de permisos:
```bash
chmod -R 755 storage/app
chown -R u671466050:u671466050 storage/app
```

### Si algunos logos no se importan:
El comando mostrará qué tiendas no se encontraron. Verifica que los nombres coincidan exactamente.

---

## ✅ ¡Listo!

Con estos comandos, **no necesitas hacer nada manualmente**. Todo es automático:

1. ✅ Exportar desde desarrollo
2. ✅ Subir un solo archivo JSON
3. ✅ Importar en producción
4. ✅ Limpiar caché

**¡Mucho más fácil que hacerlo manualmente!** 🎉

