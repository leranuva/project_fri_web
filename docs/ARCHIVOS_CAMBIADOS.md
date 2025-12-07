# 📝 Archivos Modificados/Agregados para Actualizar en Hostinger

## 🆕 Archivos NUEVOS a Subir

### Modelos
- `app/Models/Theme.php`
- `app/Models/BenefitSection.php`

### Controladores
- `app/Http/Controllers/Admin/ThemeController.php`
- `app/Http/Controllers/Admin/BenefitSectionController.php`
- `app/Http/Controllers/TrackingController.php` (si no existe)

### Servicios
- `app/Services/TrackingService.php` (si no existe)

### Migraciones
- `database/migrations/2025_12_03_013352_create_benefits_table.php`
- `database/migrations/2025_12_03_014053_add_color_fields_to_benefits_table.php`
- `database/migrations/2025_12_03_014536_add_unique_constraint_to_benefits_title.php`
- `database/migrations/2025_12_03_015041_create_benefit_sections_table.php`
- `database/migrations/2025_12_03_015446_add_title_color_to_benefit_sections_table.php`
- `database/migrations/2025_12_03_015933_create_themes_table.php`

### Seeders
- `database/seeders/ThemeSeeder.php`
- `database/seeders/BenefitSectionSeeder.php`
- `database/seeders/BenefitSeeder.php` (actualizado)

### Vistas - Nuevas Carpetas
- `resources/views/admin/themes/` (carpeta completa)
  - `index.blade.php`
  - `create.blade.php`
  - `edit.blade.php`
  - `show.blade.php`
- `resources/views/admin/benefit-sections/` (carpeta completa)
  - `edit.blade.php`
- `resources/views/tracking/` (si no existe)
  - `result.blade.php`

### Vistas - Modificadas
- `resources/views/admin/benefits/index.blade.php`
- `resources/views/admin/benefits/create.blade.php`
- `resources/views/admin/benefits/edit.blade.php`
- `resources/views/admin/benefits/show.blade.php`
- `resources/views/home.blade.php`
- `resources/views/dashboard.blade.php`
- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/guest.blade.php`
- `resources/views/components/ui/card.blade.php`

### Configuración
- `app/Providers/AppServiceProvider.php`
- `config/services.php` (si tiene trackingmore)
- `routes/web.php`

### Assets Compilados
- `public/build/` (carpeta completa - MUY IMPORTANTE)
  - `manifest.json`
  - `assets/app-*.css`
  - `assets/app-*.js`
  - `assets/cotizador-alpine-*.js`
  - etc.

### Otros
- `public/favicon.svg` (si no existe)

## 🔄 Archivos MODIFICADOS a Subir

- `app/Http/Controllers/Admin/BenefitController.php`
- `app/Http/Controllers/HomeController.php`
- `app/Models/Benefit.php`
- `database/seeders/BenefitSeeder.php`

## ⚠️ Archivos que NO Debes Subir

- ❌ `.env` (ya existe en el servidor)
- ❌ `storage/logs/*.log`
- ❌ `storage/framework/cache/data/*`
- ❌ `storage/framework/sessions/*`
- ❌ `storage/framework/views/*`
- ❌ `bootstrap/cache/*.php`
- ❌ `node_modules/`
- ❌ `.git/`

## 📋 Comandos a Ejecutar en el Servidor

Después de subir los archivos, ejecuta estos comandos en SSH:

```bash
# 1. Ir al directorio del proyecto
cd ~/public_html  # o tu ruta

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

# 6. Verificar storage link
php artisan storage:link

# 7. Verificar permisos
chmod -R 755 storage bootstrap/cache
chmod 600 .env
```

## ✅ Verificación Post-Despliegue

1. Visita `https://tudominio.com/admin/themes` - Debe mostrar la gestión de temas
2. Visita `https://tudominio.com/admin/benefits` - Debe mostrar beneficios con colores
3. Verifica que el tema activo se aplica en la página de inicio
4. Verifica que los colores de beneficios se muestran correctamente




