# 🎯 Instrucciones Específicas para Hostinger

## 📁 Estructura de Carpetas en Hostinger

En Hostinger, tu proyecto debe estar estructurado así:

```
public_html/              ← Document Root debe apuntar aquí
├── index.php            ← Archivo principal (debe redirigir a public/)
├── .htaccess            ← Redirección a public/
└── public/              ← Carpeta pública real
    ├── index.php
    ├── .htaccess
    ├── favicon.ico
    └── build/
```

**O mejor aún, si puedes cambiar el Document Root:**

```
public_html/             ← Document Root apunta a public_html/public
├── app/
├── bootstrap/
├── config/
├── database/
├── public/              ← Document Root aquí
│   ├── index.php
│   ├── .htaccess
│   └── build/
├── resources/
├── routes/
├── storage/
├── vendor/
└── artisan
```

## 🔧 Configuración del Document Root

### Opción 1: Cambiar Document Root (Recomendado)

1. En el panel de Hostinger, ve a **Dominios** → **Administrar**
2. Busca **Configuración de PHP**
3. Cambia el **Document Root** a: `/public_html/public`
4. Guarda los cambios

### Opción 2: Si NO puedes cambiar Document Root

Crea un archivo `index.php` en la raíz (`public_html/index.php`):

```php
<?php
/**
 * Redirige todas las peticiones a la carpeta public/
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
```

Y crea un `.htaccess` en la raíz (`public_html/.htaccess`):

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

## 🗄️ Configuración de Base de Datos

En Hostinger, las credenciales de MySQL suelen tener este formato:

```env
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_nombre_db
DB_USERNAME=u123456789_usuario
DB_PASSWORD=tu_contraseña
```

**Nota:** El prefijo `u123456789_` es común en Hostinger. Úsalo tal como aparece en el panel.

## 📧 Configuración de Email

Para usar el correo de Hostinger:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@tudominio.com
MAIL_PASSWORD=tu_contraseña_email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@tudominio.com"
MAIL_FROM_NAME="Flat Rate Imports"
```

## 🔐 Permisos en Hostinger

Desde SSH o File Manager:

```bash
# Permisos de carpetas
chmod 755 storage
chmod 755 bootstrap/cache
chmod 755 public

# Permisos de archivos
chmod 644 .env
chmod 644 public/index.php
```

**Desde File Manager de Hostinger:**
- Click derecho en la carpeta → **Cambiar permisos**
- `storage/` → **755**
- `bootstrap/cache/` → **755**
- `public/` → **755**

## 🚀 Comandos en Hostinger (SSH)

Si tienes acceso SSH:

```bash
# Navegar al directorio
cd ~/domains/tudominio.com/public_html

# Instalar dependencias
composer install --optimize-autoloader --no-dev

# Generar clave
php artisan key:generate

# Migrar base de datos
php artisan migrate --force

# Crear storage link
php artisan storage:link

# Optimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Permisos
chmod -R 755 storage bootstrap/cache
```

## ⚠️ Problemas Comunes en Hostinger

### Error: "Class 'PDO' not found"

**Solución:** Activa la extensión PDO en el panel de Hostinger:
1. Ve a **Configuración de PHP**
2. Activa **PDO** y **PDO_MySQL**
3. Guarda y reinicia

### Error: "The stream or file could not be opened"

**Solución:** Verifica permisos:
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Error: "No application encryption key has been specified"

**Solución:**
```bash
php artisan key:generate
```

### Assets (CSS/JS) no cargan

**Solución:**
1. Verifica que `npm run build` se ejecutó
2. Verifica que `public/build/` existe
3. Limpia caché: `php artisan cache:clear`

### Error 500 después del despliegue

**Solución:**
1. Activa `APP_DEBUG=true` temporalmente en `.env`
2. Revisa `storage/logs/laravel.log`
3. Verifica permisos de carpetas
4. Verifica que todas las dependencias están instaladas

## 📝 Checklist Pre-Despliegue

- [ ] Assets compilados (`npm run build`)
- [ ] `.env.example` creado
- [ ] `.env` configurado en el servidor
- [ ] `APP_KEY` generado
- [ ] Base de datos creada y migrada
- [ ] Storage link creado
- [ ] Permisos configurados (755 para storage y bootstrap/cache)
- [ ] `APP_DEBUG=false` en producción
- [ ] `APP_URL` configurado con HTTPS
- [ ] Document Root apunta a `public/`

## 🔒 Seguridad Post-Despliegue

1. **Cambiar permisos de .env:**
   ```bash
   chmod 600 .env
   ```

2. **Verificar que .env no sea accesible públicamente**

3. **Configurar backups automáticos de la BD**

4. **Monitorear logs regularmente:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

## 📞 Soporte Hostinger

Si tienes problemas específicos de Hostinger:
- Panel de Control: https://hpanel.hostinger.com
- Documentación: https://support.hostinger.com
- Soporte: Desde el panel de control





