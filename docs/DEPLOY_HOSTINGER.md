# 🚀 Guía de Despliegue en Hostinger

Esta guía te ayudará a desplegar tu aplicación Laravel en Hostinger.

## 📋 Requisitos Previos

- Cuenta de Hostinger con hosting activo
- Acceso SSH (recomendado) o File Manager
- Base de datos MySQL creada en Hostinger
- Dominio configurado

## 🔧 Paso 1: Preparar el Proyecto Localmente

### 1.1 Compilar Assets para Producción

```bash
npm run build
```

### 1.2 Optimizar para Producción

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 1.3 Verificar que el Storage Link esté creado

```bash
php artisan storage:link
```

## 📤 Paso 2: Subir Archivos al Servidor

### Opción A: Usando FTP/SFTP (FileZilla, WinSCP, etc.)

**Archivos a subir:**
- ✅ Todo el contenido del proyecto EXCEPTO:
  - `node_modules/` (no subir)
  - `.git/` (no subir)
  - `.env` (no subir, crear uno nuevo en el servidor)
  - `storage/logs/*` (no subir los logs)
  - `tests/` (opcional, no necesario en producción)

**Estructura en Hostinger:**
```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/          ← Este es el directorio raíz web
│   ├── index.php
│   ├── .htaccess
│   ├── favicon.ico
│   └── build/
├── resources/
├── routes/
├── storage/
├── vendor/
├── artisan
├── composer.json
└── .env
```

### Opción B: Usando Git (Recomendado)

1. Crea un repositorio Git (GitHub, GitLab, etc.)
2. Sube tu código al repositorio
3. En Hostinger, clona el repositorio:

```bash
cd ~/domains/tudominio.com/public_html
git clone https://github.com/tu-usuario/tu-repositorio.git .
```

## 🔐 Paso 3: Configurar el Archivo .env

1. En el servidor, crea un archivo `.env` basado en `.env.example`:

```bash
cp .env.example .env
```

2. Edita el archivo `.env` con tus datos de Hostinger:

```env
APP_NAME="Flat Rate Imports"
APP_ENV=production
APP_KEY=                    # Generar con: php artisan key:generate
APP_DEBUG=false
APP_URL=https://tudominio.com

DB_CONNECTION=mysql
DB_HOST=localhost          # O la IP que te proporcione Hostinger
DB_PORT=3306
DB_DATABASE=u123456789_nombre_db
DB_USERNAME=u123456789_usuario
DB_PASSWORD=tu_contraseña

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=noreply@tudominio.com
MAIL_PASSWORD=tu_contraseña_email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@tudominio.com"
MAIL_FROM_NAME="Flat Rate Imports"
```

3. Genera la clave de aplicación:

```bash
php artisan key:generate
```

## 🗄️ Paso 4: Configurar la Base de Datos

1. En el panel de Hostinger, crea una base de datos MySQL
2. Anota las credenciales (host, usuario, contraseña, nombre de BD)
3. Ejecuta las migraciones:

```bash
php artisan migrate --force
```

4. (Opcional) Ejecuta los seeders para datos iniciales:

```bash
php artisan db:seed --class=SliderSeeder
php artisan db:seed --class=ProcessStepSeeder
php artisan db:seed --class=ProcessSectionSeeder
php artisan db:seed --class=AlertBannerSeeder
```

## 📁 Paso 5: Configurar Permisos

En Hostinger, configura los permisos correctos:

```bash
chmod -R 755 storage bootstrap/cache
chmod -R 755 public
```

O desde el File Manager de Hostinger:
- `storage/` → Permisos: 755
- `bootstrap/cache/` → Permisos: 755
- `public/` → Permisos: 755

## 🔗 Paso 6: Crear Storage Link

```bash
php artisan storage:link
```

Esto crea un enlace simbólico de `storage/app/public` a `public/storage`.

## ⚙️ Paso 7: Instalar Dependencias

### 7.1 Dependencias de PHP (Composer)

```bash
composer install --optimize-autoloader --no-dev
```

### 7.2 Dependencias de Node.js (si es necesario)

```bash
npm install --production
npm run build
```

## 🎯 Paso 8: Configurar el Document Root

En Hostinger, asegúrate de que el **Document Root** apunte a la carpeta `public/`:

- **Document Root:** `/public_html/public` (o la ruta completa a tu carpeta public)

Si no puedes cambiar el Document Root, mueve el contenido de `public/` a la raíz y ajusta `index.php`.

## 🔄 Paso 9: Optimizar para Producción

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan optimize
```

## ✅ Paso 10: Verificar el Despliegue

1. Visita tu dominio en el navegador
2. Verifica que la página carga correctamente
3. Prueba el login/registro
4. Verifica que las imágenes se cargan (storage link)
5. Revisa los logs si hay errores: `storage/logs/laravel.log`

## 🛠️ Solución de Problemas Comunes

### Error 500 - Internal Server Error

1. Verifica los permisos de carpetas:
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

2. Revisa el archivo `.env`:
   - `APP_DEBUG=true` temporalmente para ver errores
   - Verifica que `APP_KEY` esté configurado

3. Revisa los logs:
   ```bash
   tail -f storage/logs/laravel.log
   ```

### Las imágenes no se cargan

1. Verifica que el storage link esté creado:
   ```bash
   php artisan storage:link
   ```

2. Verifica permisos de `storage/app/public`:
   ```bash
   chmod -R 755 storage/app/public
   ```

### Error de base de datos

1. Verifica las credenciales en `.env`
2. Asegúrate de que la base de datos existe
3. Verifica que el usuario tiene permisos

### Assets (CSS/JS) no se cargan

1. Verifica que `npm run build` se ejecutó correctamente
2. Verifica que la carpeta `public/build/` existe
3. Limpia la caché:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   ```

## 📝 Notas Importantes

- **Nunca subas el archivo `.env`** a Git o al servidor público
- Mantén `APP_DEBUG=false` en producción
- Usa HTTPS en producción (`APP_URL=https://...`)
- Configura backups regulares de la base de datos
- Monitorea los logs regularmente

## 🔒 Seguridad

1. Cambia los permisos de `.env`:
   ```bash
   chmod 600 .env
   ```

2. Asegúrate de que `storage/` y `bootstrap/cache/` no sean accesibles públicamente

3. Verifica que el `.htaccess` en `public/` esté configurado correctamente

## 📞 Soporte

Si tienes problemas, revisa:
- Logs de Laravel: `storage/logs/laravel.log`
- Logs del servidor en el panel de Hostinger
- Documentación de Hostinger sobre Laravel





