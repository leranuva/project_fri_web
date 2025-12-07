# 📝 Ejemplo de Archivo .env para Hostinger

## 🎯 Archivo Completo

He creado el archivo `.env.HOSTINGER.EJEMPLO` con un ejemplo completo. Aquí tienes la versión resumida:

## 📋 Ejemplo Básico

```env
# ============================================
# CONFIGURACIÓN DE LA APLICACIÓN
# ============================================
APP_NAME="Flat Rate Imports"
APP_ENV=production
APP_KEY=base64:TU_CLAVE_AQUI_GENERADA_CON_PHP_ARTISAN_KEY_GENERATE
APP_DEBUG=false
APP_URL=https://tudominio.com

# ============================================
# BASE DE DATOS - HOSTINGER
# ============================================
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_nombre_base_datos
DB_USERNAME=u123456789_usuario_db
DB_PASSWORD=tu_contraseña_segura_aqui

# ============================================
# CONFIGURACIÓN DE CORREO - HOSTINGER SMTP
# ============================================
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=noreply@tudominio.com
MAIL_PASSWORD=tu_contraseña_del_correo
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@tudominio.com"
MAIL_FROM_NAME="Flat Rate Imports"

# ============================================
# CONFIGURACIÓN DE SESIONES Y CACHE
# ============================================
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

## 🔧 Valores a Cambiar

### 1. APP_KEY
```bash
# Generar con:
php artisan key:generate
```

### 2. APP_URL
```env
APP_URL=https://tudominio.com
# O si usas subdominio:
APP_URL=https://www.tudominio.com
```

### 3. Base de Datos (Hostinger)

En Hostinger, las credenciales suelen tener este formato:

```env
DB_HOST=localhost
# O a veces:
DB_HOST=127.0.0.1

DB_DATABASE=u123456789_nombre_db
# El formato es: u[numero]_[nombre]
# Ejemplo: u123456789_flatrate

DB_USERNAME=u123456789_usuario
# Mismo formato que la base de datos

DB_PASSWORD=tu_contraseña
# La contraseña que configuraste en Hostinger
```

**Dónde encontrar estos datos:**
1. Panel de Hostinger → **Bases de datos MySQL**
2. Verás el nombre de la BD, usuario y contraseña
3. Copia exactamente como aparecen (incluyendo el prefijo `u123456789_`)

### 4. Correo (Hostinger SMTP)

```env
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587              # Para TLS
# O
MAIL_PORT=465              # Para SSL (cambiar MAIL_ENCRYPTION=ssl)

MAIL_USERNAME=tu_email@tudominio.com
MAIL_PASSWORD=contraseña_del_email
```

**Dónde encontrar estos datos:**
1. Panel de Hostinger → **Correo electrónico**
2. Crea una cuenta de correo (ej: `noreply@tudominio.com`)
3. Usa la contraseña que configuraste

## 📝 Pasos para Configurar

### Paso 1: Crear el archivo
```bash
# En el servidor (SSH)
cd ~/domains/tudominio.com/public_html
cp .env.example .env
```

### Paso 2: Editar con tus datos
```bash
nano .env
# O desde File Manager, edita el archivo .env
```

### Paso 3: Cambiar estos valores:

1. **APP_KEY** - Generar:
   ```bash
   php artisan key:generate
   ```

2. **APP_URL** - Tu dominio:
   ```env
   APP_URL=https://tudominio.com
   ```

3. **Base de datos** - Desde panel Hostinger:
   ```env
   DB_DATABASE=u123456789_tu_base_datos
   DB_USERNAME=u123456789_tu_usuario
   DB_PASSWORD=tu_contraseña
   ```

4. **Correo** - Desde panel Hostinger:
   ```env
   MAIL_USERNAME=noreply@tudominio.com
   MAIL_PASSWORD=contraseña_del_correo
   ```

### Paso 4: Configurar permisos
```bash
chmod 600 .env
```

## ✅ Verificación

Para verificar que el `.env` está correcto:

```bash
# Verificar que Laravel lee el .env
php artisan config:show app.name
php artisan config:show app.url

# Probar conexión a base de datos
php artisan migrate:status

# Probar envío de correo (opcional)
php artisan tinker
>>> Mail::raw('Test', function($msg) { $msg->to('tu@email.com')->subject('Test'); });
```

## 🔒 Seguridad

1. **Permisos del archivo:**
   ```bash
   chmod 600 .env
   ```

2. **No subir a Git:**
   - El `.env` ya está en `.gitignore`
   - Nunca lo subas a repositorios públicos

3. **Valores sensibles:**
   - No compartas el contenido del `.env`
   - Cambia las contraseñas si se compromete

## ⚠️ Errores Comunes

### Error: "No application encryption key"
```bash
php artisan key:generate
```

### Error: "Access denied for user"
- Verifica que `DB_USERNAME` y `DB_PASSWORD` son correctos
- Verifica que el usuario tiene permisos en la base de datos

### Error: "Could not find driver"
- En Hostinger, activa la extensión PDO_MySQL en el panel

### Error: "Connection refused" (correo)
- Verifica `MAIL_HOST` y `MAIL_PORT`
- Verifica que el correo existe en Hostinger
- Prueba con `MAIL_PORT=465` y `MAIL_ENCRYPTION=ssl`

## 📞 Ayuda

Si tienes problemas:
1. Revisa `storage/logs/laravel.log`
2. Activa temporalmente `APP_DEBUG=true` para ver errores
3. Verifica que todos los valores están sin espacios extra
4. Verifica que las comillas están correctas





