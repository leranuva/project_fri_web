# 🔧 Solución: Error 403 Forbidden

## ❌ Error

```
403 Forbidden
Access to this resource on the server is denied!
```

## 🔍 Causas Comunes

1. **Permisos incorrectos** en archivos/carpetas
2. **Document Root** no apunta a `public/`
3. **Archivo .htaccess** no funciona o está mal configurado
4. **Permisos del index.php** incorrectos
5. **Estructura de carpetas** incorrecta

## ✅ Soluciones

### Solución 1: Verificar y Corregir Permisos

```bash
# Permisos de carpetas (755)
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod -R 755 public

# Permisos de archivos (644)
find public -type f -exec chmod 644 {} \;
chmod 644 public/index.php
chmod 644 public/.htaccess

# Permisos del .env (600)
chmod 600 .env
```

**Desde File Manager de Hostinger:**
- `storage/` → Permisos: **755**
- `bootstrap/cache/` → Permisos: **755**
- `public/` → Permisos: **755**
- `public/index.php` → Permisos: **644**
- `public/.htaccess` → Permisos: **644**

### Solución 2: Verificar Document Root

El **Document Root** debe apuntar a `public_html/public` (no a `public_html`).

**En Hostinger:**
1. Ve a **Dominios** → **Administrar**
2. Busca **Configuración de PHP** o **Document Root**
3. Cambia a: `/public_html/public`
4. Guarda los cambios

**Si NO puedes cambiar el Document Root**, necesitas crear archivos de redirección:

#### Crear `index.php` en la raíz (`public_html/index.php`):

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

#### Crear `.htaccess` en la raíz (`public_html/.htaccess`):

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### Solución 3: Verificar el .htaccess en public/

Asegúrate de que `public/.htaccess` existe y tiene el contenido correcto:

```bash
# Verificar que existe
ls -la public/.htaccess

# Ver contenido
cat public/.htaccess
```

El archivo debe tener el contenido estándar de Laravel (ya lo tienes configurado).

### Solución 4: Verificar Estructura de Carpetas

La estructura debe ser:

```
public_html/
├── app/
├── bootstrap/
├── config/
├── public/              ← Document Root debe apuntar aquí
│   ├── .htaccess
│   ├── index.php
│   └── build/
├── resources/
├── routes/
├── storage/
└── vendor/
```

Verificar:
```bash
# Debe mostrar estas carpetas
ls -la | grep -E "app|config|public|vendor"
```

### Solución 5: Verificar Permisos del Usuario

A veces el problema es que el usuario del servidor no tiene permisos. Verifica:

```bash
# Ver quién es el propietario
ls -la public/index.php

# Si es necesario, cambiar propietario (ajusta el usuario)
# chown -R u671466050:u671466050 .
```

### Solución 6: Activar mod_rewrite

En Hostinger, asegúrate de que `mod_rewrite` está activado. Normalmente lo está por defecto, pero verifica en el panel.

## 🔍 Diagnóstico

### Paso 1: Verificar Permisos

```bash
# Ver permisos actuales
ls -la public/
ls -la storage/
ls -la bootstrap/cache/
```

### Paso 2: Probar Acceso Directo

Intenta acceder directamente a:
- `https://tudominio.com/index.php`
- `https://tudominio.com/public/index.php`

Si `index.php` funciona pero la raíz no, el problema es el `.htaccess` o el Document Root.

### Paso 3: Verificar Logs

```bash
# Ver logs de Laravel
tail -f storage/logs/laravel.log

# Ver logs del servidor (si tienes acceso)
# tail -f /var/log/apache2/error.log
```

### Paso 4: Probar sin .htaccess

Temporalmente, renombra el `.htaccess`:

```bash
mv public/.htaccess public/.htaccess.backup
```

Si funciona sin `.htaccess`, el problema está en la configuración del `.htaccess`.

## 📝 Comandos Completos (Copia y Pega)

```bash
# 1. Corregir permisos
chmod -R 755 storage bootstrap/cache public
chmod 644 public/index.php
chmod 644 public/.htaccess
chmod 600 .env

# 2. Verificar estructura
ls -la public/

# 3. Probar acceso
curl -I https://tudominio.com
```

## ⚠️ Si Nada Funciona

1. **Contacta a Hostinger** - Puede ser una configuración del servidor
2. **Verifica el plan de hosting** - Algunos planes tienen restricciones
3. **Revisa el panel de Hostinger** - Puede haber configuraciones de seguridad activas

## ✅ Verificación Final

Después de aplicar las soluciones:

1. Visita: `https://tudominio.com`
2. Debe cargar la página de inicio
3. Si aún da 403, prueba: `https://tudominio.com/index.php`





