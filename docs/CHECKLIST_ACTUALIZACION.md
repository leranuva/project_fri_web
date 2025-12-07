# ✅ Checklist de Actualización en Hostinger

## 📦 ANTES DE SUBIR

- [x] Assets compilados (`npm run build` ejecutado)
- [x] `public/build/` contiene archivos compilados
- [x] Verificar que no hay errores locales

## 📤 ARCHIVOS A SUBIR

### Carpetas Completas (Nuevas o Modificadas)
- [ ] `app/` - Toda la carpeta (incluye nuevos modelos y controladores)
- [ ] `database/migrations/` - Todas las migraciones (incluye nuevas)
- [ ] `database/seeders/` - Todos los seeders (incluye nuevos)
- [ ] `resources/views/admin/themes/` - **NUEVA** - Carpeta completa
- [ ] `resources/views/admin/benefit-sections/` - **NUEVA** - Carpeta completa
- [ ] `resources/views/admin/benefits/` - Carpeta completa (modificada)
- [ ] `resources/views/` - Todas las vistas modificadas
- [ ] `public/build/` - **CRÍTICO** - Assets compilados
- [ ] `routes/web.php` - Archivo modificado
- [ ] `config/` - Si hay cambios
- [ ] `app/Providers/AppServiceProvider.php` - Modificado

### NO Subir
- [ ] `.env` - NO tocar (ya existe en servidor)
- [ ] `node_modules/` - NO subir
- [ ] `.git/` - NO subir
- [ ] `storage/logs/*.log` - NO subir logs
- [ ] `storage/framework/cache/data/*` - NO subir cache
- [ ] `storage/framework/sessions/*` - NO subir sesiones
- [ ] `storage/framework/views/*` - NO subir vistas compiladas

## 🔧 EN EL SERVIDOR (SSH)

Después de subir archivos:

- [ ] Ejecutar: `php artisan migrate --force`
- [ ] Ejecutar: `php artisan db:seed --class=ThemeSeeder`
- [ ] Ejecutar: `php artisan db:seed --class=BenefitSectionSeeder`
- [ ] Ejecutar: `php artisan db:seed --class=BenefitSeeder`
- [ ] Limpiar caché: `php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear`
- [ ] Optimizar: `php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan event:cache`
- [ ] Verificar permisos: `chmod -R 755 storage bootstrap/cache && chmod 600 .env`

## ✅ VERIFICACIÓN FINAL

- [ ] Sitio web carga correctamente
- [ ] `/admin/themes` funciona y muestra temas
- [ ] `/admin/benefits` funciona y muestra colores
- [ ] Página de inicio usa el tema activo
- [ ] Dashboard tiene enlace a "Gestión de Temas"
- [ ] No hay errores en `storage/logs/laravel.log`

## 🎯 RESUMEN RÁPIDO

**Comando único para ejecutar en servidor después de subir:**

```bash
cd ~/public_html && \
php artisan migrate --force && \
php artisan db:seed --class=ThemeSeeder && \
php artisan db:seed --class=BenefitSectionSeeder && \
php artisan db:seed --class=BenefitSeeder && \
php artisan cache:clear && \
php artisan config:clear && \
php artisan route:clear && \
php artisan view:clear && \
php artisan event:clear && \
php artisan config:cache && \
php artisan route:cache && \
php artisan view:cache && \
php artisan event:cache && \
chmod -R 755 storage bootstrap/cache && \
chmod 600 .env
```




