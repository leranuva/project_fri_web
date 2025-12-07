# 🔧 Comandos SSH para Hostinger - 6 de Diciembre 2025

## 📋 Comandos Completos

Copia y pega estos comandos uno por uno en la consola SSH de Hostinger:

```bash
# 1. Ir al directorio del proyecto
cd ~/public_html

# 2. Verificar que estás en el directorio correcto
pwd

# 3. Ejecutar nuevas migraciones
php artisan migrate --force

# 4. Ejecutar seeder del Cotizador
php artisan db:seed --class=CotizadorSectionSeeder

# 5. Ejecutar seeder de Temas (actualizado con Dance Studio)
php artisan db:seed --class=ThemeSeeder

# 6. Limpiar todas las cachés
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# 7. Reoptimizar (crear cachés optimizados)
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 8. Verificar permisos de storage y cache
chmod -R 755 storage bootstrap/cache
chmod 600 .env

# 9. Verificar que el storage link existe
php artisan storage:link

# 10. Verificar estado de migraciones
php artisan migrate:status
```

---

## 🚀 Versión en una sola línea (para copiar completo)

Si prefieres ejecutar todo de una vez:

```bash
cd ~/public_html && php artisan migrate --force && php artisan db:seed --class=CotizadorSectionSeeder && php artisan db:seed --class=ThemeSeeder && php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan event:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan event:cache && chmod -R 755 storage bootstrap/cache && chmod 600 .env && php artisan storage:link
```

---

## 📝 Explicación de cada comando

### 1. Navegación
```bash
cd ~/public_html
```
- Cambia al directorio donde está tu proyecto Laravel
- En Hostinger generalmente es `~/public_html` o `~/domains/tudominio.com/public_html`

### 2. Migraciones
```bash
php artisan migrate --force
```
- Ejecuta las nuevas migraciones (crea tabla `cotizador_sections` y agrega campos de color)
- `--force` es necesario en producción

### 3. Seeders
```bash
php artisan db:seed --class=CotizadorSectionSeeder
php artisan db:seed --class=ThemeSeeder
```
- Crea la configuración inicial del cotizador
- Agrega el nuevo tema "Dance Studio" a la base de datos

### 4. Limpiar Caché
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
```
- Elimina todas las cachés para que los cambios se reflejen

### 5. Optimizar
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```
- Crea cachés optimizados para mejor rendimiento en producción

### 6. Permisos
```bash
chmod -R 755 storage bootstrap/cache
chmod 600 .env
```
- Asegura que Laravel pueda escribir en `storage/` y `bootstrap/cache/`
- Protege el archivo `.env`

### 7. Storage Link
```bash
php artisan storage:link
```
- Crea el enlace simbólico para archivos públicos (si no existe)

---

## ✅ Verificación Post-Ejecución

Después de ejecutar los comandos, verifica:

```bash
# Verificar que las migraciones se ejecutaron
php artisan migrate:status

# Verificar que los seeders funcionaron (debe mostrar 4 temas)
php artisan tinker
# Luego en tinker: \App\Models\Theme::count()
# Debe retornar: 4
# Salir: exit
```

---

## 🐛 Si hay errores

### Error: "Class not found"
```bash
composer dump-autoload
php artisan clear-compiled
```

### Error: "Migration already exists"
```bash
php artisan migrate:status
# Si la migración ya está ejecutada, está bien, continúa
```

### Error: "Permission denied"
```bash
chmod -R 755 storage bootstrap/cache
chmod 600 .env
```

### Error: "Storage link already exists"
```bash
# Está bien, significa que ya existe el enlace
```

---

## 📊 Orden de Ejecución Recomendado

1. ✅ **Primero**: Migraciones (crean las tablas)
2. ✅ **Segundo**: Seeders (poblan las tablas)
3. ✅ **Tercero**: Limpiar caché (elimina datos antiguos)
4. ✅ **Cuarto**: Optimizar (crea nuevas cachés)
5. ✅ **Quinto**: Permisos (asegura acceso correcto)

---

## ⚠️ Notas Importantes

- Ejecuta los comandos en el orden indicado
- Si algún comando falla, revisa el error antes de continuar
- Los comandos de limpieza y optimización son seguros de ejecutar múltiples veces
- El comando `migrate --force` solo ejecuta migraciones pendientes, no afecta las existentes

---

✅ **Listo para ejecutar en Hostinger**

