# ✅ Checklist de Actualización - 6 de Diciembre 2025

## 📦 PREPARACIÓN LOCAL

- [x] Assets compilados (`npm run build` ejecutado)
- [x] `public/build/` contiene archivos compilados actualizados
- [x] Verificar que no hay errores locales
- [x] Probar funcionalidades nuevas localmente

---

## 📤 ARCHIVOS A SUBIR

### 🆕 Archivos NUEVOS

#### Modelos
- [ ] `app/Models/CotizadorSection.php`

#### Controladores
- [ ] `app/Http/Controllers/Admin/CotizadorSectionController.php`
- [ ] `app/Http/Controllers/Admin/DashboardGuideController.php`

#### Migraciones
- [ ] `database/migrations/2025_12_06_210609_create_cotizador_sections_table.php`
- [ ] `database/migrations/2025_12_06_211102_add_color_fields_to_cotizador_sections_table.php`

#### Seeders
- [ ] `database/seeders/CotizadorSectionSeeder.php`

#### Vistas
- [ ] `resources/views/admin/cotizador-sections/edit.blade.php`
- [ ] `resources/views/admin/dashboard-guide/index.blade.php`

### 📝 Archivos MODIFICADOS

#### Controladores
- [ ] `app/Http/Controllers/CotizadorController.php`
- [ ] `app/Http/Controllers/Admin/ThemeController.php`

#### Vistas
- [ ] `resources/views/cotizador.blade.php`
- [ ] `resources/views/dashboard.blade.php`
- [ ] `resources/views/components/ui/form-group.blade.php`

#### Seeders
- [ ] `database/seeders/ThemeSeeder.php`

#### Rutas
- [ ] `routes/web.php`

#### CSS
- [ ] `resources/css/app.css`

#### Assets Compilados ⚠️ **CRÍTICO**
- [ ] `public/build/manifest.json`
- [ ] `public/build/assets/app-*.css`
- [ ] `public/build/assets/app-*.js`

---

## 🔧 EN EL SERVIDOR (SSH)

Después de subir archivos:

- [ ] Conectar por SSH
- [ ] Ir al directorio: `cd ~/public_html`
- [ ] Ejecutar migraciones: `php artisan migrate --force`
- [ ] Ejecutar seeder CotizadorSection: `php artisan db:seed --class=CotizadorSectionSeeder`
- [ ] Ejecutar seeder Theme: `php artisan db:seed --class=ThemeSeeder`
- [ ] Limpiar caché: `php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear`
- [ ] Optimizar: `php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan event:cache`
- [ ] Verificar permisos: `chmod -R 755 storage bootstrap/cache && chmod 600 .env`

---

## ✅ VERIFICACIÓN FINAL

### Dashboard
- [ ] `https://tudominio.com/dashboard` carga correctamente
- [ ] Botón "Guía" visible y funcional
- [ ] Enlace "Cotizador" en sección de administración

### Guía Interactiva
- [ ] `https://tudominio.com/admin/dashboard-guide` carga
- [ ] Tour interactivo funciona
- [ ] Navegación entre pasos funciona
- [ ] Barra de progreso se actualiza

### Gestión del Cotizador
- [ ] `https://tudominio.com/admin/cotizador-sections` carga
- [ ] Formulario de edición funciona
- [ ] Colores se guardan correctamente
- [ ] Vista previa de colores funciona

### Cotizador
- [ ] `https://tudominio.com/cotizador` carga
- [ ] Títulos y labels usan colores configurados
- [ ] Funcionalidad del cotizador intacta
- [ ] Sin errores en consola

### Gestión de Temas
- [ ] `https://tudominio.com/admin/themes` muestra 4 temas
- [ ] Tema "Dance Studio" visible
- [ ] Activación de temas funciona
- [ ] Colores del tema se aplican correctamente

### Página Principal
- [ ] `https://tudominio.com/` carga correctamente
- [ ] Tema activo se aplica correctamente
- [ ] Sin errores en consola del navegador

---

## 🐛 Solución de Problemas

Si algo no funciona:

- [ ] Verificar que `public/build/` se subió completamente
- [ ] Verificar que las migraciones se ejecutaron: `php artisan migrate:status`
- [ ] Verificar que los seeders se ejecutaron correctamente
- [ ] Limpiar caché nuevamente: `php artisan cache:clear`
- [ ] Verificar permisos: `ls -la storage bootstrap/cache`
- [ ] Revisar logs: `tail -f storage/logs/laravel.log`

---

## 📋 Comandos SSH Completos

```bash
# Ir al directorio
cd ~/public_html

# Migraciones
php artisan migrate --force

# Seeders
php artisan db:seed --class=CotizadorSectionSeeder
php artisan db:seed --class=ThemeSeeder

# Limpiar
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# Optimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Permisos
chmod -R 755 storage bootstrap/cache
chmod 600 .env
```

---

✅ **¡Actualización completada!** Si todos los checkboxes están marcados, la actualización fue exitosa.

