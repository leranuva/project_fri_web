# 🔧 Solución: No se Pueden Subir Imágenes en el Slider (Hostinger)

## 🎯 Problema
Las imágenes del slider se suben correctamente en localhost pero no en Hostinger.

## 🔍 Causas Comunes

1. **Enlace simbólico de storage no creado**
2. **Permisos incorrectos en carpetas de storage**
3. **Límites de PHP para subida de archivos**
4. **Carpeta `sliders` no existe**

---

## ✅ Solución Paso a Paso

### Paso 1: Verificar el Enlace Simbólico de Storage

El enlace simbólico conecta `public/storage` con `storage/app/public` para que las imágenes sean accesibles públicamente.

```bash
# Verificar si existe el enlace
ls -la public/storage

# Si NO existe o está roto, crear/regenerar el enlace
# NOTA: Si php artisan storage:link da error "Call to undefined function exec()",
# crear el enlace manualmente con ln -s
```

**⚠️ IMPORTANTE: Si `php artisan storage:link` da error:**

En algunos servidores (como Hostinger), la función `exec()` está deshabilitada. En ese caso, crea el enlace manualmente:

```bash
# Eliminar el enlace existente si está roto
rm -f public/storage

# Crear el enlace simbólico manualmente
ln -s ../storage/app/public public/storage

# Verificar que se creó correctamente
ls -la public/storage
```

**Verificación:**
```bash
# Debe mostrar algo como:
# lrwxrwxrwx 1 usuario usuario 25 Dec  7 10:00 public/storage -> ../storage/app/public
```

Si el enlace no se crea, puede ser un problema de permisos. Ver Paso 2.

---

### Paso 2: Verificar y Corregir Permisos

Las carpetas de storage necesitan permisos de escritura.

```bash
# Navegar al directorio del proyecto
cd ~/domains/tudominio.com/public_html
# O
cd public_html

# Verificar permisos actuales
ls -la storage/app/

# Corregir permisos de storage
chmod -R 755 storage
chmod -R 775 storage/app/public

# Si aún no funciona, intentar con 777 (menos seguro pero funcional)
chmod -R 777 storage/app/public

# Verificar permisos de bootstrap/cache también
chmod -R 755 bootstrap/cache
```

**Permisos recomendados:**
- `storage/` → 755
- `storage/app/` → 755
- `storage/app/public/` → 775 o 777
- `storage/app/public/sliders/` → 775 o 777

---

### Paso 3: Crear la Carpeta `sliders` si No Existe

```bash
# Crear la carpeta si no existe
mkdir -p storage/app/public/sliders

# Dar permisos de escritura
chmod 775 storage/app/public/sliders

# Verificar que se creó
ls -la storage/app/public/
```

---

### Paso 4: Verificar Límites de PHP para Subida de Archivos

El slider permite imágenes hasta 5MB. Verifica que PHP permite subir archivos de ese tamaño.

```bash
# Ver configuración actual de PHP
php -i | grep -E "upload_max_filesize|post_max_size|memory_limit"

# O crear un archivo temporal para verificar
php -r "echo 'upload_max_filesize: ' . ini_get('upload_max_filesize') . PHP_EOL;"
php -r "echo 'post_max_size: ' . ini_get('post_max_size') . PHP_EOL;"
php -r "echo 'memory_limit: ' . ini_get('memory_limit') . PHP_EOL;"
```

**Valores recomendados:**
- `upload_max_filesize` → Al menos 10M (el slider permite hasta 5MB)
- `post_max_size` → Al menos 10M (debe ser mayor o igual a upload_max_filesize)
- `memory_limit` → Al menos 128M

**Si los valores son muy bajos:**

En Hostinger, puedes crear un archivo `.user.ini` en la raíz del proyecto (`public_html/`):

```ini
upload_max_filesize = 10M
post_max_size = 10M
memory_limit = 128M
```

Luego reiniciar PHP o esperar unos minutos para que se apliquen los cambios.

---

### Paso 5: Verificar Propietario de Archivos

A veces el problema es que los archivos pertenecen a un usuario diferente.

```bash
# Ver el propietario actual
ls -la storage/app/public/

# Cambiar propietario (reemplaza 'usuario' con tu usuario de Hostinger)
chown -R usuario:usuario storage/app/public

# Si no conoces tu usuario, verificar con:
whoami
```

---

### Paso 6: Verificar que `storage/app/public` Existe

```bash
# Verificar estructura de carpetas
ls -la storage/app/

# Si no existe public/, crearlo
mkdir -p storage/app/public
chmod 775 storage/app/public
```

---

## 🧪 Verificación Completa

Ejecuta estos comandos en orden para verificar todo:

```bash
# 1. Verificar estructura
ls -la storage/app/public/

# 2. Verificar enlace simbólico
ls -la public/storage

# 3. Verificar permisos
ls -la storage/app/public/ | head -5

# 4. Crear carpeta sliders si no existe
mkdir -p storage/app/public/sliders
chmod 775 storage/app/public/sliders

# 5. Regenerar enlace simbólico
# Si php artisan storage:link da error, usar:
rm -f public/storage
ln -s ../storage/app/public public/storage

# 6. Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## 🚨 Solución Rápida (Todo en Uno)

Si quieres aplicar todas las correcciones de una vez:

```bash
# Navegar al proyecto
cd ~/domains/tudominio.com/public_html
# O
cd public_html

# Crear estructura completa
mkdir -p storage/app/public/sliders

# Dar permisos
chmod -R 755 storage
chmod -R 775 storage/app/public
chmod 775 storage/app/public/sliders

# Crear/regenerar enlace simbólico
# Si php artisan storage:link da error "exec() disabled", usar:
rm -f public/storage
ln -s ../storage/app/public public/storage

# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Verificar
ls -la public/storage
ls -la storage/app/public/sliders
```

---

## 🔍 Diagnóstico de Errores

### Error: "The file could not be uploaded"
- **Causa:** Permisos incorrectos o carpeta no existe
- **Solución:** Ver Pasos 2 y 3

### Error: "File too large"
- **Causa:** Límites de PHP muy bajos
- **Solución:** Ver Paso 4

### Las imágenes se suben pero no se muestran
- **Causa:** Enlace simbólico no existe o está roto
- **Solución:** Ver Paso 1

### Error 500 al subir
- **Causa:** Múltiples posibles (permisos, límites, enlace)
- **Solución:** Revisar logs: `tail -n 50 storage/logs/laravel.log`

---

## 📝 Verificar Logs de Errores

Si nada funciona, revisa los logs:

```bash
# Ver últimos errores
tail -n 100 storage/logs/laravel.log

# Ver errores en tiempo real (mientras intentas subir)
tail -f storage/logs/laravel.log
```

Busca mensajes relacionados con:
- `Permission denied`
- `No such file or directory`
- `upload_max_filesize`
- `post_max_size`

---

## ✅ Checklist Final

Después de aplicar las soluciones, verifica:

- [ ] El enlace `public/storage` existe y apunta a `storage/app/public`
- [ ] La carpeta `storage/app/public/sliders` existe
- [ ] Los permisos son 775 o 777 en `storage/app/public/sliders`
- [ ] PHP permite subir archivos de al menos 10MB
- [ ] No hay errores en `storage/logs/laravel.log`
- [ ] Puedes acceder a `https://tudominio.com/storage/sliders/` (debe mostrar 403 o listado, no 404)

---

## 🎯 Prueba Final

1. **Intenta subir una imagen pequeña** (< 1MB) desde el panel de administración
2. **Verifica que se guarda:**
   ```bash
   ls -la storage/app/public/sliders/
   ```
3. **Verifica que es accesible:**
   - Visita: `https://tudominio.com/storage/sliders/nombre_archivo.jpg`
   - Debe mostrar la imagen, no un error 404

---

*Última actualización: 7 de Diciembre 2025*

