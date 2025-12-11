# 🚀 Comandos SSH para Hostinger - 9 de Diciembre 2025

## 📋 Pasos de Despliegue

### 1. Conectarse por SSH
```bash
ssh u671466050@us-bos-web1847.ssh.hostinger.com
```

### 2. Navegar al directorio del proyecto
```bash
cd domains/leranuva.com/public_html
```

### 3. Verificar archivos subidos
```bash
ls -la resources/views/admin/project-costs/
ls -la resources/views/home.blade.php
ls -la database/seeders/StoreSeeder.php
```

### 4. Compilar Assets (si es necesario)
```bash
# Verificar si node_modules existe
ls -la node_modules

# Si no existe, instalar dependencias
npm install

# Compilar assets
npm run build

# Verificar que se compilaron
ls -la public/build/assets/
```

### 5. Limpiar y Regenerar Caché
```bash
# Limpiar todas las cachés
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Regenerar cachés
php artisan config:cache
php artisan view:cache
php artisan route:cache
```

### 6. Verificar Permisos
```bash
# Verificar permisos de directorios importantes
ls -la storage/
ls -la bootstrap/cache/

# Si es necesario, ajustar permisos
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 7. Verificar Logs (si hay errores)
```bash
# Ver últimos errores
tail -n 50 storage/logs/laravel.log

# Ver errores en tiempo real
tail -f storage/logs/laravel.log
```

---

## 🔍 Verificación Post-Despliegue

### Verificar que los archivos están actualizados
```bash
# Verificar fecha de modificación de archivos clave
stat resources/views/admin/project-costs/index.blade.php
stat resources/views/home.blade.php
stat database/seeders/StoreSeeder.php
```

### Verificar sintaxis PHP (sin errores)
```bash
php -l resources/views/admin/project-costs/index.blade.php
php -l database/seeders/StoreSeeder.php
```

---

## 🛠️ Solución de Problemas

### Si los estilos no se aplican
```bash
# Limpiar caché de vistas
php artisan view:clear
php artisan view:cache

# Verificar que los assets se compilaron
ls -la public/build/assets/
```

### Si los logos no se muestran
```bash
# Verificar que los logos están en la base de datos
php artisan tinker
# Luego ejecutar:
# \App\Models\Store::all()->pluck('name', 'logo_url');
```

### Si hay errores de sintaxis
```bash
# Verificar sintaxis de todos los archivos PHP
find . -name "*.php" -exec php -l {} \;
```

---

## 📝 Notas Importantes

1. **Assets**: Si no se compilaron los assets localmente, asegúrate de ejecutar `npm run build` en el servidor.

2. **Caché**: Siempre limpiar y regenerar caché después de subir cambios en vistas.

3. **Permisos**: Asegúrate de que `storage/` y `bootstrap/cache/` tengan permisos de escritura.

4. **Logos**: Los logos deben agregarse desde el panel de administración. El seeder está limpio para no sobrescribir los existentes.

---

## ✅ Checklist de Verificación

- [ ] Archivos subidos correctamente
- [ ] Assets compilados (si es necesario)
- [ ] Caché limpiada y regenerada
- [ ] Permisos correctos
- [ ] Sin errores en logs
- [ ] Sección de costos responsive funcionando
- [ ] Logos de tiendas mostrándose correctamente

---

## 🔄 Rollback (si es necesario)

Si necesitas revertir los cambios:

```bash
# Restaurar desde backup (si existe)
cp resources/views/admin/project-costs/index.blade.php.backup resources/views/admin/project-costs/index.blade.php
cp resources/views/home.blade.php.backup resources/views/home.blade.php

# Limpiar caché después del rollback
php artisan view:clear
php artisan view:cache
```

