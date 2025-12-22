# Solución: Estilos No Cargan Después de Migrar a Otro Hosting

## 🔴 Problema

Después de copiar el proyecto de un hosting a otro en Hostinger y cambiar la base de datos, los estilos no cargan.

## ✅ Solución Completa Paso a Paso

### Paso 1: Verificar Estructura de Archivos

```bash
# Verificar que los archivos compilados existen
ls -la public/build/
ls -la public/build/assets/

# Verificar manifest.json
cat public/build/manifest.json
```

### Paso 2: Limpiar TODAS las Cachés

```bash
# Limpiar absolutamente todo
php artisan optimize:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear

# Eliminar cachés manualmente
rm -rf bootstrap/cache/*
rm -rf storage/framework/cache/*
rm -rf storage/framework/views/*
```

### Paso 3: Verificar y Corregir .env

```bash
# Verificar APP_URL (MUY IMPORTANTE)
cat .env | grep APP_URL

# Debe ser el dominio correcto del nuevo hosting
# Ejemplo: APP_URL=https://nuevodominio.com

# Verificar APP_ENV
cat .env | grep APP_ENV
# Debe ser: APP_ENV=production

# Verificar APP_KEY
cat .env | grep APP_KEY
# Debe tener una clave válida
```

### Paso 4: Regenerar APP_KEY (si es necesario)

```bash
# Si APP_KEY está vacío o incorrecto
php artisan key:generate

# O agregar manualmente si falla
```

### Paso 5: Verificar y Corregir Permisos

```bash
# Permisos de storage
chmod -R 775 storage
chmod -R 775 storage/logs
chmod -R 775 storage/framework

# Permisos de bootstrap/cache
chmod -R 775 bootstrap/cache

# Permisos de public/build
chmod -R 755 public/build
chmod 644 public/build/manifest.json
chmod 644 public/build/assets/*

# Permisos de .env
chmod 644 .env
```

### Paso 6: Regenerar Cachés

```bash
# Regenerar con la nueva configuración
php artisan config:cache
php artisan view:cache
php artisan route:cache
php artisan optimize
```

### Paso 7: Verificar Manifest.json

El `manifest.json` debe coincidir con los archivos físicos en `public/build/assets/`:

```bash
# Ver qué archivos hay
ls -la public/build/assets/

# Ver qué dice el manifest
cat public/build/manifest.json

# Si no coinciden, necesitas recompilar (ver Paso 8)
```

### Paso 8: Recompilar Assets (si es necesario)

Si el `manifest.json` no coincide con los archivos o están desactualizados:

**Opción A: Si tienes Node.js en el servidor:**
```bash
npm install
npm run build
```

**Opción B: Compilar localmente y subir:**
1. En tu máquina local:
   ```bash
   npm run build
   ```
2. Sube la carpeta `public/build/` completa al servidor

## 🔧 Comandos Completos (Copia y Pega)

```bash
# 1. Verificar estructura
ls -la public/build/
cat public/build/manifest.json | head -20

# 2. Limpiar TODAS las cachés
php artisan optimize:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear
rm -rf bootstrap/cache/*
rm -rf storage/framework/cache/*
rm -rf storage/framework/views/*

# 3. Verificar .env
cat .env | grep -E "APP_URL|APP_ENV|APP_KEY|APP_DEBUG"

# 4. Corregir APP_URL si es necesario
# nano .env
# Buscar APP_URL y cambiarlo al dominio correcto

# 5. Verificar permisos
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod -R 755 public/build
chmod 644 public/build/manifest.json
chmod 644 .env

# 6. Regenerar cachés
php artisan config:cache
php artisan view:cache
php artisan route:cache
php artisan optimize

# 7. Verificar que funciona
php artisan config:show app.url
php artisan config:show app.env
```

## 🔍 Verificación en el Navegador

1. **Abre el sitio** en el navegador
2. **Presiona F12** para abrir herramientas de desarrollador
3. **Ve a la pestaña Network** (Red)
4. **Recarga con Ctrl+F5** (limpiar caché)
5. **Busca archivos .css y .js**
6. **Verifica las URLs:**
   - Deben ser: `https://tudominio.com/build/assets/app-*.css`
   - NO deben ser: `http://localhost:5173/...` (Vite dev server)

## ⚠️ Problemas Comunes

### Error: "Vite manifest not found"

```bash
# Verificar que existe
ls -la public/build/manifest.json

# Si no existe, necesitas compilar:
# npm run build (localmente y subir public/build/)
```

### Los Archivos Cargar pero dan 404

```bash
# Verificar que los archivos mencionados en manifest.json existen
cat public/build/manifest.json
ls -la public/build/assets/

# Si no coinciden, recompilar
```

### APP_URL Incorrecto

El `APP_URL` debe ser exactamente el dominio del nuevo hosting:

```bash
# Verificar
cat .env | grep APP_URL

# Editar si es necesario
nano .env
# Cambiar a: APP_URL=https://nuevodominio.com

# Regenerar
php artisan config:clear
php artisan config:cache
```

### Caché del Navegador

Aunque los archivos estén bien, el navegador puede tener caché:

1. **Limpiar caché del navegador:**
   - `Ctrl+Shift+Delete` (Windows/Linux)
   - `Cmd+Shift+Delete` (Mac)
   - Seleccionar "Imágenes y archivos en caché"
   - Limpiar

2. **O usar modo incógnito:**
   - `Ctrl+Shift+N` (Chrome)
   - `Ctrl+Shift+P` (Firefox)

## 📝 Checklist de Migración

- [ ] Archivos compilados en `public/build/`
- [ ] `manifest.json` existe y es válido
- [ ] `.env` tiene `APP_URL` correcto del nuevo dominio
- [ ] `.env` tiene `APP_ENV=production`
- [ ] `.env` tiene `APP_KEY` configurado
- [ ] Base de datos configurada correctamente
- [ ] Permisos de `storage/` y `bootstrap/cache/` son 775
- [ ] Permisos de `public/build/` son 755
- [ ] Cachés limpiadas y regeneradas
- [ ] Migraciones ejecutadas (`php artisan migrate --force`)

## 🆘 Si Nada Funciona

1. **Verificar logs:**
   ```bash
   tail -n 50 storage/logs/laravel.log
   ```

2. **Activar debug temporalmente:**
   ```bash
   # En .env
   APP_DEBUG=true
   
   # Limpiar y regenerar
   php artisan config:clear
   php artisan config:cache
   ```

3. **Ver el error específico** en el navegador (F12 → Console)

4. **Verificar que Vite está en modo producción:**
   - En el código fuente, busca `@vite`
   - Debe generar enlaces a `/build/assets/...`
   - NO debe intentar conectar a `localhost:5173`


