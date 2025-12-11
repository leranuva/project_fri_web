# 🔧 Solución: Cambios No Se Reflejan Después de Subir Archivos

## 🚨 Problema
Después de subir las carpetas `database`, `public` y `resources`, los cambios no se reflejan en el sitio.

## ✅ Solución Paso a Paso

### 1. Conectarse por SSH
```bash
ssh u671466050@us-bos-web1847.ssh.hostinger.com
```

### 2. Navegar al directorio
```bash
cd domains/leranuva.com/public_html
```

### 3. Verificar que los archivos se subieron correctamente
```bash
# Verificar archivos modificados
ls -la resources/views/admin/project-costs/index.blade.php
ls -la resources/views/home.blade.php
ls -la database/seeders/StoreSeeder.php

# Verificar fecha de modificación (debe ser reciente)
stat resources/views/admin/project-costs/index.blade.php
```

### 4. Limpiar TODAS las cachés (MUY IMPORTANTE)
```bash
# Limpiar todas las cachés
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear

# Si optimize:clear no existe, usar:
php artisan clear-compiled
```

### 5. Regenerar cachés
```bash
php artisan config:cache
php artisan view:cache
php artisan route:cache
php artisan optimize
```

### 6. Verificar permisos
```bash
# Verificar permisos de storage y cache
ls -la storage/
ls -la bootstrap/cache/

# Si es necesario, ajustar permisos
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R u671466050:u671466050 storage bootstrap/cache
```

### 7. Verificar logs por errores
```bash
# Ver últimos errores
tail -n 100 storage/logs/laravel.log

# Si hay errores, ver detalles
grep -i error storage/logs/laravel.log | tail -n 20
```

---

## 🔍 Verificaciones Adicionales

### Verificar que los archivos tienen el contenido correcto
```bash
# Verificar que el archivo tiene los estilos CSS nuevos
grep -i "store-logo-svg" resources/views/home.blade.php

# Verificar que el archivo tiene las mejoras responsive
grep -i "overflow-x-auto" resources/views/admin/project-costs/index.blade.php
```

### Verificar sintaxis PHP
```bash
php -l resources/views/admin/project-costs/index.blade.php
php -l resources/views/home.blade.php
php -l database/seeders/StoreSeeder.php
```

---

## 🛠️ Soluciones Específicas

### Si los estilos CSS no se aplican
```bash
# Limpiar caché de vistas específicamente
php artisan view:clear
php artisan view:cache

# Verificar que public/build está actualizado
ls -la public/build/assets/
```

### Si los logos no se muestran
```bash
# Verificar que los logos están en la base de datos
php artisan tinker
# Luego ejecutar:
# \App\Models\Store::whereNotNull('logo_url')->count();
```

### Si hay errores 500
```bash
# Ver el error completo
tail -n 50 storage/logs/laravel.log

# Verificar permisos
ls -la storage/logs/
chmod 775 storage/logs/
chmod 664 storage/logs/laravel.log
```

---

## 🔄 Forzar Recarga Completa

Si después de todo no funciona, hacer un reset completo:

```bash
# 1. Limpiar todo
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear

# 2. Eliminar archivos de caché manualmente
rm -rf bootstrap/cache/*.php
rm -rf storage/framework/cache/*
rm -rf storage/framework/views/*

# 3. Regenerar todo
php artisan config:cache
php artisan view:cache
php artisan route:cache
php artisan optimize

# 4. Verificar permisos
chmod -R 755 storage bootstrap/cache
```

---

## 📝 Checklist de Verificación

- [ ] Archivos subidos correctamente (verificar con `stat`)
- [ ] Todas las cachés limpiadas
- [ ] Cachés regeneradas
- [ ] Permisos correctos (755 para carpetas, 644 para archivos)
- [ ] Sin errores en logs
- [ ] Sintaxis PHP correcta
- [ ] Assets compilados en `public/build/`

---

## ⚠️ Notas Importantes

1. **Caché de Vistas**: Laravel compila las vistas Blade y las guarda en caché. Si no limpias la caché, seguirá mostrando la versión antigua.

2. **Permisos**: Asegúrate de que `storage/` y `bootstrap/cache/` tengan permisos de escritura.

3. **Assets**: Si modificaste CSS/JS, asegúrate de que `public/build/` esté actualizado.

4. **Tiempo de Propagación**: A veces los cambios tardan unos segundos en reflejarse, especialmente en CDN.

---

## 🆘 Si Nada Funciona

1. Verificar que estás editando los archivos correctos
2. Verificar que no hay errores de sintaxis
3. Verificar que los archivos se guardaron correctamente
4. Intentar acceder directamente a la ruta para ver el error
5. Revisar los logs de Apache/Nginx si hay errores 500

---

**Última actualización:** 9 de Diciembre 2025

