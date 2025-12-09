# 🔧 Comandos SSH Hostinger - 7 de Diciembre 2025

## 📋 Comandos para Actualización

### 1. Conectar por SSH

```bash
ssh usuario@hostinger.com
# O usar el panel de Hostinger > SSH Access
```

### 2. Navegar al Directorio del Proyecto

```bash
cd public_html
# O el directorio donde está tu proyecto Laravel
```

### 3. Limpiar Caché (OBLIGATORIO)

```bash
# Limpiar todos los cachés
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
```

### 4. Regenerar Autoload (si es necesario)

```bash
composer dump-autoload
```

### 5. Optimizar para Producción (RECOMENDADO)

```bash
# Cachear configuración
php artisan config:cache

# Cachear rutas
php artisan route:cache

# Cachear vistas
php artisan view:cache
```

### 6. Configurar WhatsApp (NUEVO)

```bash
# Agregar variables de WhatsApp al .env
# Editar .env y agregar (IMPORTANTE: el mensaje entre comillas):
# WHATSAPP_NUMBER=593999999999
# WHATSAPP_MESSAGE="Hola, me interesa conocer más sobre sus servicios de importación."

# Limpiar caché de configuración después de agregar las variables
php artisan config:clear
php artisan config:cache
```

**Nota:** El número debe estar en formato internacional sin espacios (ejemplo: `593999999999` para Ecuador).

### 7. Verificar Rutas

```bash
# Verificar que la nueva ruta existe
php artisan route:list | grep project-costs
php artisan route:list | grep shipping-methods
```

### 8. Verificar Permisos (si hay problemas)

```bash
# Asegurar permisos correctos
chmod -R 755 storage bootstrap/cache
chown -R usuario:usuario storage bootstrap/cache
```

---

## 🧪 Comandos de Verificación

### Verificar que los archivos están en su lugar

```bash
# Verificar controlador
ls -la app/Http/Controllers/Admin/ProjectCostsController.php

# Verificar vista
ls -la resources/views/admin/project-costs/index.blade.php

# Verificar modelo actualizado
grep -n "getWeightRangesForMethod" app/Models/ShippingRate.php

# Verificar componente de WhatsApp
ls -la resources/views/components/whatsapp-float.blade.php

# Verificar configuración de WhatsApp
grep -n "whatsapp" config/app.php
```

### Verificar logs de errores

```bash
# Ver últimos errores
tail -n 50 storage/logs/laravel.log

# Ver errores en tiempo real
tail -f storage/logs/laravel.log
```

---

## 🔄 Rollback (si es necesario)

Si algo sale mal, puedes revertir los cambios:

```bash
# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Restaurar archivos desde backup (si tienes)
# Usar git o backup previo
```

---

## 📝 Checklist de Verificación Post-Despliegue

```bash
# 1. Verificar que no hay errores de sintaxis
php artisan route:list

# 2. Verificar que las rutas están registradas
php artisan route:list | grep -E "project-costs|shipping-methods"

# 3. Verificar logs
tail -n 20 storage/logs/laravel.log

# 4. Verificar permisos
ls -la storage/logs/
ls -la bootstrap/cache/
```

---

## 🚨 Solución de Problemas Comunes

### Error: "Class not found"
```bash
composer dump-autoload
php artisan config:clear
```

### Error: "Route not found"
```bash
php artisan route:clear
php artisan route:cache
php artisan route:list
```

### Error: "View not found"
```bash
php artisan view:clear
php artisan view:cache
```

### Assets no se cargan
```bash
# Verificar que public/build existe
ls -la public/build/

# Si no existe, compilar localmente y subir
# npm run build (en local)
```

### Botón de WhatsApp no aparece
```bash
# Verificar que el componente existe
ls -la resources/views/components/whatsapp-float.blade.php

# Verificar que está incluido en los layouts
grep -n "whatsapp-float" resources/views/layouts/*.blade.php

# Verificar configuración en .env
grep WHATSAPP .env

# Limpiar caché de vistas
php artisan view:clear
php artisan view:cache
```

---

## 📞 Comandos Útiles Adicionales

### Ver información del sistema
```bash
php artisan about
```

### Ver versión de PHP
```bash
php -v
```

### Ver espacio en disco
```bash
df -h
```

### Ver procesos PHP
```bash
ps aux | grep php
```

---

---

## 📸 Solución: Subida de Imágenes en Slider

### Problema: No se pueden subir imágenes desde el PC en Hostinger

**Solución rápida:**

```bash
# 1. Crear estructura de carpetas
mkdir -p storage/app/public/sliders

# 2. Dar permisos
chmod -R 755 storage
chmod -R 775 storage/app/public
chmod 775 storage/app/public/sliders

# 3. Crear/regenerar enlace simbólico
# Si php artisan storage:link da error "exec() disabled", crear manualmente:
rm -f public/storage
ln -s ../storage/app/public public/storage

# 4. Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

**Verificar:**
```bash
# Verificar enlace simbólico
ls -la public/storage

# Verificar carpeta sliders
ls -la storage/app/public/sliders
```

**Si aún no funciona, verificar límites de PHP:**
```bash
php -r "echo 'upload_max_filesize: ' . ini_get('upload_max_filesize') . PHP_EOL;"
php -r "echo 'post_max_size: ' . ini_get('post_max_size') . PHP_EOL;"
```

Si los valores son muy bajos (< 5M), crear archivo `.user.ini` en la raíz:
```ini
upload_max_filesize = 10M
post_max_size = 10M
```

**Ver documentación completa:** `docs/SOLUCION_SUBIDA_IMAGENES_SLIDER.md`

---

## 📱 Configuración de WhatsApp

### Variables de Entorno Requeridas

Agregar al archivo `.env` en el servidor:

```env
WHATSAPP_NUMBER=593999999999
WHATSAPP_MESSAGE="Hola, me interesa conocer más sobre sus servicios de importación."
```

**⚠️ IMPORTANTE:** El mensaje DEBE estar entre comillas dobles (`"`) porque contiene comas y espacios.

### Formato del Número

- **Formato:** Código de país + número sin espacios ni símbolos
- **Ejemplo Ecuador:** `593999999999` (593 = código país, 999999999 = número)
- **Ejemplo USA:** `12025551234` (1 = código país, 2025551234 = número)

### Archivos Relacionados

- `resources/views/components/whatsapp-float.blade.php` - Componente del botón flotante
- `resources/views/layouts/app.blade.php` - Layout principal (incluye WhatsApp)
- `resources/views/layouts/guest.blade.php` - Layout invitado (incluye WhatsApp)
- `config/app.php` - Configuración de WhatsApp

---

*Última actualización: 7 de Diciembre 2025 - Incluye implementación de WhatsApp flotante*

