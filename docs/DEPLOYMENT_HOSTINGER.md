# Despliegue de Flat Rate Imports en Hostinger

Guía paso a paso para subir el proyecto Laravel a Hostinger (shared hosting o VPS).

---

## Requisitos previos

- **PHP:** 8.2 o superior (Hostinger soporta 8.2, 8.3)
- **Extensiones PHP:** pdo_mysql, mbstring, openssl, tokenizer, xml, ctype, json, bcmath, fileinfo
- **Composer:** instalado en el servidor (Hostinger incluye Composer 2)
- **Base de datos MySQL:** creada desde el panel de Hostinger

---

## Opción A: Hostinger Shared Hosting

### 1. Crear base de datos en Hostinger

1. Entra al **Panel de control (hPanel)** de Hostinger
2. **Bases de datos** → **MySQL Databases**
3. Crea una base de datos (ej: `u199005242_flat_rate`)
4. Crea un usuario y asígnale todos los privilegios
5. Anota: **host** (ej: `localhost` o `mysql.hostinger.com`), **nombre BD**, **usuario**, **contraseña**

### 2. Subir archivos al servidor

**Opción recomendada: subir vía FTP/File Manager**

1. **Prepara el proyecto localmente** (en tu PC):

```bash
# En la carpeta del proyecto
composer install --optimize-autoloader --no-dev
npm ci
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

2. **Comprime** el proyecto (excluye `node_modules`, `.env`, `.git`):
   - Incluye: `app`, `bootstrap`, `config`, `database`, `public`, `resources`, `routes`, `storage`, `vendor`, `composer.json`, `composer.lock`, `package.json`, `package-lock.json`, `vite.config.js`, `tailwind.config.js`, `postcss.config.js`

3. **Sube** el archivo ZIP al servidor vía File Manager o FTP

4. **Estructura en Hostinger:**
   - Si usas **dominio principal**: sube a `domains/tudominio.com/` (fuera de `public_html`)
   - Si usas **addon domain**: sube a la carpeta del addon domain

### 3. Configurar el directorio público

Hostinger permite cambiar el **Document Root** para que apunte a la carpeta `public` de Laravel:

1. **hPanel** → **Dominios** → tu dominio → **Configuración avanzada**
2. **Document Root** → Cambiar a: `public_html/flat_rate_imports/public` (o la ruta donde esté tu proyecto + `/public`)

**Alternativa si no puedes cambiar Document Root:**

Copia el contenido de `public/` a `public_html/` y edita `public_html/index.php`:

```php
// Cambiar estas líneas (ajusta la ruta según tu estructura):
require __DIR__.'/../flat_rate_imports/vendor/autoload.php';
$app = require_once __DIR__.'/../flat_rate_imports/bootstrap/app.php';
```

### 4. Configurar .env en producción

1. En el servidor, copia `.env.production.example` o `.env.example` a `.env`
2. **NO copies desde tablas de documentación** — el formato con `|` y `` ` `` es inválido
3. Edita `.env` con estos valores (cada variable en una línea, sin caracteres extra):

```env
APP_NAME=FlatRateImports
APP_ENV=production
APP_KEY=                    # Se genera con: php artisan key:generate
APP_DEBUG=false
APP_URL=https://tudominio.com
APP_TIMEZONE=America/Guayaquil
APP_LOCALE=es
APP_FALLBACK_LOCALE=es

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u199005242_flat_rate
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync
```

**Importante:** En shared hosting, usa `QUEUE_CONNECTION=sync` si no tienes acceso a cron para el queue worker.

### 5. Permisos y enlaces

Conecta por **SSH** (Hostinger lo ofrece en planes Business y superiores) o usa el **Terminal** del File Manager:

```bash
cd /home/usuario/domains/tudominio.com/flat_rate_imports

# IMPORTANTE: Borrar caché de Laravel (evita error "PailServiceProvider not found")
rm -f bootstrap/cache/*.php

# Permisos para storage y cache
chmod -R 775 storage bootstrap/cache

# Generar clave de aplicación (si no la generaste localmente)
php artisan key:generate

# Crear enlace simbólico para storage
php artisan storage:link

# Ejecutar migraciones
php artisan migrate --force

# Poblar productos y métodos de envío (necesario para el cotizador)
php artisan db:seed --force

# Limpiar caché del cotizador
php artisan cache:clear

# Optimizar para producción (opcional, después de que todo funcione)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6. Cron (opcional pero recomendado)

En **hPanel** → **Cron Jobs**, añade:

```
* * * * * cd /home/usuario/domains/tudominio.com/flat_rate_imports && php artisan schedule:run >> /dev/null 2>&1
```

---

## Opción B: Hostinger VPS con plantilla Laravel

Hostinger ofrece una plantilla VPS con Laravel preinstalado. Consulta la [documentación oficial](https://support.hostinger.com/en/articles/9070980-how-to-use-the-laravel-vps-template-at-hostinger).

---

## Checklist post-despliegue

- [ ] `APP_DEBUG=false` en producción
- [ ] `APP_URL` con la URL real (https://)
- [ ] Base de datos configurada y migraciones ejecutadas
- [ ] `php artisan storage:link` ejecutado
- [ ] Permisos 775 en `storage` y `bootstrap/cache`
- [ ] SSL/HTTPS activado (Hostinger incluye Let's Encrypt)
- [ ] Variables de entorno sensibles configuradas (TrackingMore, Google OAuth, etc.)

---

## Variables de entorno a configurar en producción

> **IMPORTANTE:** NO copies las líneas de la tabla de abajo al archivo .env. Esa tabla es solo documentación.
> Usa el archivo `.env.production.example` como base y rellena los valores.

| Variable | Descripción |
|---------|-------------|
| TRACKINGMORE_API_KEY | API de TrackingMore para seguimiento de paquetes |
| GOOGLE_CLIENT_ID / GOOGLE_CLIENT_SECRET | OAuth Google (inicio de sesión) |
| GOOGLE_REDIRECT_URI | URL de callback (ej: https://tudominio.com/auth/google/callback) |
| MAIL_* | Configuración SMTP para emails |
| WEBHOOK_LEADS_URL | URL de webhook para leads (n8n/Zapier) |
| GOOGLE_ANALYTICS_ID | ID de Google Analytics |
| MAIL_* | Configuración SMTP para enviar cotizaciones por email (Hostinger ofrece SMTP en el panel) |

---

## Crear ZIP para subir (Windows)

1. Ejecuta el script de preparación:
```powershell
cd C:\projects\flat_rate_imports
.\scripts\deploy-prepare.ps1
```

2. Crea un ZIP manualmente incluyendo:
   - `app`, `bootstrap`, `config`, `database`, `public`, `resources`, `routes`, `storage`, `vendor`
   - `composer.json`, `composer.lock`, `package.json`, `package-lock.json`
   - `vite.config.js`, `tailwind.config.js`, `postcss.config.js` (si existen)
   - Archivos en `public/` (index.php, .htaccess, assets compilados, etc.)

3. **Excluir:** `.env`, `node_modules`, `.git`, archivos de log

---

## Solución de problemas

### "The environment file is invalid! Encountered an invalid name at [...]"

Si copiaste variables desde una tabla de documentación, el `.env` tendrá formato inválido (pipes `|`, backticks `` ` ``).

**Solución:** Recrea el `.env` desde cero usando `.env.production.example`:

```bash
cp .env.production.example .env
nano .env
```

Rellena solo los valores necesarios (DB_*, APP_URL, APP_KEY después de key:generate). Cada variable debe estar en su propia línea, así:

```
GOOGLE_REDIRECT_URI=https://tudominio.com/auth/google/callback
WEBHOOK_LEADS_URL=
```

Nunca pongas comentarios en la misma línea ni caracteres como `|` o `` ` ``.

### Error 500
- Revisa `storage/logs/laravel.log`
- Verifica permisos en `storage` y `bootstrap/cache`
- Ejecuta `php artisan config:clear` y `php artisan cache:clear`

### Assets no cargan (CSS/JS)
- Asegúrate de haber ejecutado `npm run build` antes de subir
- Verifica que `APP_URL` en `.env` sea correcto

### Base de datos no conecta
- Comprueba `DB_HOST` (puede ser `localhost` o el host que indique Hostinger)
- Verifica que el usuario tenga permisos sobre la base de datos

### CORS / Vite intenta cargar desde localhost:5173

El sitio carga scripts desde el servidor de desarrollo de Vite. Solución:

1. **Eliminar el archivo `hot`** en el servidor (si existe):
```bash
rm -f public/hot
# o si el proyecto está en public_html:
rm -f hot
```

2. **Compilar assets en local** y subir la carpeta `public/build`:
```bash
npm run build
```
Sube la carpeta `public/build/` completa al servidor.

3. **Verificar** que exista `public/build/manifest.json` en el servidor.

### Productos y métodos de envío no aparecen en el cotizador

1. Ejecuta los seeders: `php artisan db:seed --force`
2. Limpia la caché del cotizador: `php artisan cotizador:clear-cache`
3. Si sigue vacío, limpia toda la caché: `php artisan cache:clear`

### URLs generan http en lugar de https
- Asegúrate de que `APP_URL` use `https://`
- En Hostinger, activa SSL (Let's Encrypt) desde el panel
- Verifica que `APP_ENV=production`
