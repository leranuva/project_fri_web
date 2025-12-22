# Solución: Archivos Duplicados en Ubicaciones Incorrectas

## 🔴 Problema Detectado

Los archivos compilados están duplicados en ubicaciones incorrectas:
- `public/build/assets/app-A08r1SLL.css` (correcto)
- `public/build/assets/public/build/assets/app-A08r1SLL.css` (incorrecto - duplicado)

## ✅ Solución: Limpiar y Corregir Estructura

### Paso 1: Verificar Estructura Real

```bash
# Verificar dónde estás
pwd

# Debe ser: /home/u199005242/domains/flatrateimports.com/public_html

# Verificar estructura correcta
ls -la public/build/assets/ | head -15

# NO debe haber archivos con ruta "public/build/assets/" dentro de assets/
```

### Paso 2: Eliminar Archivos Duplicados

```bash
# Eliminar archivos duplicados incorrectos
rm -f public/build/assets/public/build/assets/*

# Verificar que se eliminaron
ls -la public/build/assets/
```

### Paso 3: Verificar que Solo Quedan los Archivos Correctos

```bash
# Listar archivos en assets (solo deben ser los compilados)
ls -la public/build/assets/

# Debe mostrar solo:
# - app-*.css
# - app-*.js
# - cotizador-alpine-*.js
# - index.es-*.js
# - purify.es-*.js
# NO debe mostrar carpetas "public/" dentro
```

### Paso 4: Verificar el Archivo "storage" en public/

```bash
# Verificar qué es ese archivo "storage"
ls -la public/storage
file public/storage

# Si es un enlace simbólico roto, eliminarlo
if [ -L public/storage ] && [ ! -e public/storage ]; then
    rm public/storage
    echo "Enlace simbólico roto eliminado"
fi

# Crear el enlace simbólico correcto
php artisan storage:link

# O manualmente si falla:
# ln -s ../storage/app/public public/storage
```

## 🔧 Comandos Completos (Copia y Pega)

```bash
# 1. Verificar ubicación actual
pwd

# 2. Ver estructura de public/build/assets/
ls -la public/build/assets/

# 3. Eliminar archivos duplicados incorrectos
find public/build/assets/ -name "public" -type d -exec rm -rf {} + 2>/dev/null
rm -rf public/build/assets/public 2>/dev/null

# 4. Verificar que quedan solo los archivos correctos
ls -la public/build/assets/

# 5. Verificar y corregir enlace storage
ls -la public/storage
if [ -L public/storage ] && [ ! -e public/storage ]; then
    rm public/storage
fi
php artisan storage:link 2>/dev/null || ln -s ../storage/app/public public/storage

# 6. Verificar permisos
chmod -R 755 public/build
chmod 644 public/build/manifest.json
chmod 644 public/build/assets/*

# 7. Limpiar cachés nuevamente
php artisan view:clear
php artisan config:clear
php artisan config:cache
```

## 🔍 Verificación Final

Después de limpiar:

```bash
# 1. Verificar estructura limpia
ls -la public/build/assets/

# Debe mostrar solo archivos .css y .js, NO carpetas "public"

# 2. Verificar que los archivos del manifest existen
cat public/build/manifest.json | grep '"file"'

# 3. Verificar acceso directo (desde el navegador):
# https://flatrateimports.com/build/assets/app-A08r1SLL.css
# Debe cargar el CSS, no dar 404
```

## ⚠️ Si el Problema Persiste

1. **Verificar que el Document Root apunta a `public/`:**
   - En el panel de Hostinger, verifica la configuración del dominio
   - El Document Root debe ser: `public_html/public`
   - NO debe ser: `public_html`

2. **Si el Document Root es `public_html` (no `public_html/public`):**
   - Necesitas crear un `index.php` en la raíz que redirija
   - O cambiar el Document Root a `public_html/public`

3. **Verificar en el navegador:**
   - Abre: `https://flatrateimports.com/build/assets/app-A08r1SLL.css`
   - Si da 404, el problema es de rutas/configuración del servidor
   - Si carga el CSS, el problema es que Laravel no los está referenciando


