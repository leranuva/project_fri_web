# Solución: Error 500 Internal Server Error

## 🔴 Problema

El servidor devuelve un error **500 Internal Server Error** al acceder al sitio web.

## 🔍 Diagnóstico Paso a Paso

### Paso 1: Verificar los Logs de Laravel

El primer paso es revisar los logs para identificar el error específico:

```bash
# Ver los últimos errores en el log
tail -n 100 storage/logs/laravel.log

# O ver el log completo de hoy
tail -n 500 storage/logs/laravel.log | grep "$(date +%Y-%m-%d)"

# Ver errores recientes (últimas 50 líneas)
tail -n 50 storage/logs/laravel.log
```

### Paso 2: Verificar Permisos de Storage

```bash
# Verificar permisos actuales
ls -la storage/
ls -la storage/logs/

# Si storage/logs no tiene permisos de escritura, corregir:
chmod -R 775 storage/logs
chmod -R 775 storage/framework
```

### Paso 3: Verificar que Existen las Carpetas Necesarias

```bash
# Verificar estructura de storage
ls -la storage/
ls -la storage/app/
ls -la storage/framework/
ls -la storage/logs/

# Si faltan carpetas, crearlas:
mkdir -p storage/app/public
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
```

### Paso 4: Verificar el Archivo .env

```bash
# Verificar que .env existe y tiene configuración correcta
ls -la .env

# Verificar variables importantes
cat .env | grep APP_KEY
cat .env | grep APP_URL
cat .env | grep DB_
```

### Paso 5: Verificar Errores de PHP

```bash
# Verificar si hay errores de sintaxis en PHP
php -l app/Http/Kernel.php
php -l config/app.php

# Verificar errores de PHP en general
php artisan --version
```

## ✅ Soluciones Comunes

### Solución 1: Limpiar Cachés

```bash
# Limpiar TODAS las cachés
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear

# Regenerar cachés
php artisan config:cache
php artisan view:cache
php artisan route:cache
php artisan optimize
```

### Solución 2: Verificar y Corregir Permisos

```bash
# Configurar permisos correctos
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod -R 775 storage/logs
chmod -R 775 storage/framework
chmod -R 775 storage/app/public

# Verificar permisos del archivo .env
chmod 644 .env
```

### Solución 3: Verificar APP_KEY

```bash
# Si APP_KEY está vacío o incorrecto, generarlo:
php artisan key:generate

# Luego limpiar y regenerar cachés:
php artisan config:clear
php artisan config:cache
```

### Solución 4: Verificar Base de Datos

```bash
# Verificar conexión a la base de datos
php artisan tinker
# Luego en tinker:
# DB::connection()->getPdo();
# exit

# Si hay error de conexión, verificar .env:
cat .env | grep DB_
```

### Solución 5: Verificar Errores de Sintaxis en Vistas

```bash
# Compilar vistas para detectar errores
php artisan view:clear
php artisan view:cache

# Si hay error, ver el mensaje específico
```

## 🔧 Comandos de Diagnóstico Completo

Copia y pega estos comandos en orden:

```bash
# 1. Ver logs recientes
echo "=== ÚLTIMOS ERRORES EN LOG ==="
tail -n 100 storage/logs/laravel.log

# 2. Verificar permisos
echo "=== PERMISOS DE STORAGE ==="
ls -la storage/ | head -20
ls -la storage/logs/ | head -10

# 3. Verificar estructura
echo "=== ESTRUCTURA DE STORAGE ==="
ls -la storage/app/
ls -la storage/framework/

# 4. Verificar .env
echo "=== CONFIGURACIÓN .ENV ==="
cat .env | grep -E "APP_KEY|APP_URL|APP_ENV|DB_" | head -10

# 5. Verificar PHP
echo "=== VERSIÓN PHP Y LARAVEL ==="
php --version
php artisan --version

# 6. Verificar errores de sintaxis
echo "=== VERIFICAR SINTAXIS ==="
php -l app/Http/Kernel.php
php -l config/app.php
```

## 📋 Checklist de Verificación

- [ ] Los logs muestran un error específico
- [ ] `storage/logs/` tiene permisos 775
- [ ] `storage/framework/` tiene permisos 775
- [ ] Existe el archivo `.env` con configuración correcta
- [ ] `APP_KEY` está configurado en `.env`
- [ ] `APP_URL` está configurado correctamente
- [ ] Las credenciales de base de datos son correctas
- [ ] No hay errores de sintaxis en PHP
- [ ] Las cachés están limpias y regeneradas

## 🆘 Errores Específicos Comunes

### Error: "No application encryption key"

```bash
php artisan key:generate
php artisan config:clear
php artisan config:cache
```

### Error: "Class 'PDO' not found"

Activa la extensión PDO en el panel de Hostinger:
1. Ve a **Configuración de PHP**
2. Activa **PDO** y **PDO_MySQL**
3. Guarda y reinicia

### Error: "The stream or file could not be opened"

```bash
chmod -R 775 storage/logs
chmod -R 775 storage/framework
```

### Error: "SQLSTATE[HY000] [2002] Connection refused"

Verifica las credenciales de base de datos en `.env`:
```bash
cat .env | grep DB_
```

### Error: "View [nombre] not found"

```bash
php artisan view:clear
php artisan view:cache
```

## 📝 Pasos Inmediatos (Copia y Pega)

Si necesitas una solución rápida, ejecuta estos comandos:

```bash
# 1. Ver el error específico
tail -n 50 storage/logs/laravel.log

# 2. Limpiar todo
php artisan optimize:clear

# 3. Corregir permisos
chmod -R 775 storage/logs
chmod -R 775 storage/framework

# 4. Verificar APP_KEY
php artisan key:generate

# 5. Regenerar cachés
php artisan config:cache
php artisan view:cache
php artisan route:cache
php artisan optimize

# 6. Verificar
php artisan --version
```

## 🔍 Información para Soporte

Si el problema persiste, recopila esta información:

1. **Últimas líneas del log:**
   ```bash
   tail -n 100 storage/logs/laravel.log > error_log.txt
   ```

2. **Permisos actuales:**
   ```bash
   ls -la storage/ > permisos_storage.txt
   ```

3. **Configuración (sin contraseñas):**
   ```bash
   cat .env | grep -v PASSWORD > config_env.txt
   ```

4. **Versiones:**
   ```bash
   php --version > version_php.txt
   php artisan --version > version_laravel.txt
   ```

## ⚠️ Notas Importantes

1. **Siempre revisa los logs primero** - Te dirán exactamente qué está fallando.

2. **Los permisos 775** permiten que el servidor web escriba en las carpetas necesarias.

3. **Limpia las cachés** después de cualquier cambio en `.env` o configuración.

4. **APP_KEY es crítico** - Si falta o está incorrecto, Laravel no funcionará.

5. **En Hostinger**, algunos comandos pueden requerir permisos especiales. Si `chmod` no funciona, usa el File Manager del panel.


