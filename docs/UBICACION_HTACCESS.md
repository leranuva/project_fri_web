# 📍 Dónde Poner el Archivo .htaccess en Hostinger

## 🎯 RESPUESTA RÁPIDA

El archivo `.htaccess` principal va en la carpeta `public/` de tu proyecto Laravel.

## 📁 Ubicación Correcta

### Estructura en Hostinger:

```
public_html/                    ← Raíz del proyecto
├── app/
├── config/
├── public/                     ← AQUÍ va el .htaccess principal
│   ├── .htaccess              ← ✅ ARCHIVO PRINCIPAL
│   ├── index.php
│   ├── favicon.ico
│   └── build/
├── resources/
├── routes/
└── storage/
```

**Ubicación:** `public_html/public/.htaccess`

---

## 🔧 Dos Escenarios en Hostinger

### Escenario 1: Document Root apunta a `public_html/public` (Recomendado)

```
public_html/
├── app/
├── config/
└── public/                     ← Document Root aquí
    ├── .htaccess              ← ✅ SOLO ESTE
    ├── index.php
    └── build/
```

**Solo necesitas:** `public/.htaccess`

---

### Escenario 2: Document Root apunta a `public_html` (Requiere redirección)

```
public_html/                    ← Document Root aquí
├── .htaccess                  ← ✅ Este redirige a public/
├── index.php                  ← Este redirige a public/index.php
├── app/
├── config/
└── public/
    ├── .htaccess              ← ✅ Este es el principal de Laravel
    ├── index.php
    └── build/
```

**Necesitas DOS archivos:**
1. `public_html/.htaccess` - Para redirigir a `public/`
2. `public_html/public/.htaccess` - El principal de Laravel

---

## 📝 Contenido de los Archivos

### 1. `.htaccess` en `public/` (SIEMPRE necesario)

Este es el archivo principal que ya tienes. Debe estar en `public/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Handle X-XSRF-Token Header
    RewriteCond %{HTTP:x-xsrf-token} .
    RewriteRule .* - [E=HTTP_X_XSRF_TOKEN:%{HTTP:X-XSRF-Token}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Security Headers
<IfModule mod_headers.c>
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>

# Compresión GZIP
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
</IfModule>

# Cache de archivos estáticos
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"
    ExpiresByType image/x-icon "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType text/javascript "access plus 1 month"
</IfModule>
```

### 2. `.htaccess` en la raíz (SOLO si Document Root apunta a `public_html`)

Si NO puedes cambiar el Document Root, crea este archivo en `public_html/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

Y también necesitas un `index.php` en la raíz que redirija:

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

---

## ✅ Verificación

### ¿Dónde está tu .htaccess?

1. **Abre File Manager en Hostinger**
2. **Navega a `public_html/public/`**
3. **Busca el archivo `.htaccess`**

Si está ahí, está en el lugar correcto.

### ¿Funciona correctamente?

1. Visita tu dominio en el navegador
2. Si la página carga, el `.htaccess` está funcionando
3. Si ves error 500 o 404, verifica:
   - Que el archivo existe en `public/.htaccess`
   - Que tiene el contenido correcto
   - Que los permisos son correctos (644)

---

## 🔍 Cómo Verificar la Ubicación

### Desde File Manager:

```
public_html/
├── app/              ← Si ves esta carpeta
├── config/           ← Si ves esta carpeta
└── public/           ← Entra aquí
    └── .htaccess     ← Debe estar AQUÍ
```

### Desde SSH:

```bash
cd ~/domains/tudominio.com/public_html
ls -la public/.htaccess
# Debe mostrar el archivo
```

---

## ⚠️ Errores Comunes

### ❌ Error: Poner .htaccess en la raíz cuando Document Root apunta a public/

```
public_html/
├── .htaccess          ← ❌ INCORRECTO (si Document Root apunta a public/)
└── public/
    └── .htaccess      ← ✅ CORRECTO
```

### ❌ Error: No tener .htaccess en public/

```
public_html/
└── public/
    ├── index.php
    └── (sin .htaccess) ← ❌ ERROR - Laravel no funcionará
```

---

## 📋 Checklist

- [ ] El archivo `.htaccess` está en `public/.htaccess`
- [ ] El contenido es correcto (copia del que ya tienes)
- [ ] Los permisos son 644
- [ ] Si Document Root no apunta a `public/`, creaste el `.htaccess` de redirección en la raíz

---

## 🎯 Resumen

**Ubicación principal:** `public_html/public/.htaccess`

**Ubicación secundaria (solo si es necesario):** `public_html/.htaccess` (para redirección)

**El archivo principal de Laravel SIEMPRE va en `public/.htaccess`**





