# 🚀 Resumen: Actualizar Proyecto en Hostinger

## ✅ Estado Actual

- ✅ Assets compilados (`npm run build` ejecutado)
- ✅ Archivos listos para subir
- ✅ Migraciones creadas
- ✅ Seeders actualizados

## 📤 QUÉ SUBIR

### Opción Rápida: Subir Todo (Recomendado)

Sube **TODOS** los archivos y carpetas EXCEPTO:

❌ **NO SUBIR:**
- `node_modules/`
- `.git/`
- `.env` (ya existe en servidor)
- `storage/logs/*.log`
- `storage/framework/cache/data/*`
- `storage/framework/sessions/*`
- `storage/framework/views/*`
- `bootstrap/cache/*.php`
- Archivos `.backup`

✅ **SÍ SUBIR:**
- Todo lo demás, especialmente:
  - `app/` (con nuevos modelos y controladores)
  - `database/migrations/` (nuevas migraciones)
  - `database/seeders/` (nuevos seeders)
  - `resources/views/` (nuevas vistas de themes y benefit-sections)
  - `public/build/` (assets compilados - **MUY IMPORTANTE**)
  - `routes/web.php` (rutas actualizadas)
  - `config/` (si hay cambios)

## 🔄 PASOS EN EL SERVIDOR (SSH)

Después de subir los archivos, conecta por SSH y ejecuta:

```bash
# 1. Ir al directorio
cd ~/public_html

# 2. Ejecutar nuevas migraciones
php artisan migrate --force

# 3. Ejecutar nuevos seeders
php artisan db:seed --class=ThemeSeeder
php artisan db:seed --class=BenefitSectionSeeder
php artisan db:seed --class=BenefitSeeder

# 4. Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# 5. Reoptimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 6. Verificar permisos
chmod -R 755 storage bootstrap/cache
chmod 600 .env
```

## ✅ VERIFICACIÓN

Después de actualizar, verifica:

1. ✅ `https://tudominio.com/admin/themes` - Debe funcionar
2. ✅ `https://tudominio.com/admin/benefits` - Debe mostrar colores
3. ✅ Página de inicio - Debe usar el tema activo
4. ✅ Dashboard - Debe tener enlace a "Gestión de Temas"

## 🆕 NUEVAS FUNCIONALIDADES

1. **Gestión de Temas** (`/admin/themes`)
   - Crear, editar, activar temas
   - 3 temas predefinidos incluidos

2. **Gestión de Beneficios Mejorada**
   - Paleta de colores para título y descripción
   - Sin duplicados

3. **Gestión de Sección de Beneficios**
   - Editar título y color de la sección

## 📝 NOTAS IMPORTANTES

- ⚠️ **NO sobrescribas el `.env`** del servidor
- ⚠️ **Haz backup de la BD** antes de migraciones
- ✅ **Sube `public/build/`** - Es crítico para que funcionen los estilos
- ✅ **Verifica permisos** después de subir

## 🐛 Si Algo Sale Mal

1. Revisa los logs: `storage/logs/laravel.log`
2. Limpia caché: `php artisan cache:clear`
3. Verifica permisos: `chmod -R 755 storage bootstrap/cache`
4. Verifica `.env`: Asegúrate de que `APP_DEBUG=false` en producción




