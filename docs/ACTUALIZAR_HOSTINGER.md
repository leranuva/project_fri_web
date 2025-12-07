# 🚀 Guía para Actualizar el Proyecto en Hostinger

Esta guía te ayudará a actualizar tu proyecto en Hostinger con los cambios recientes.

## 📋 Cambios Recientes Incluidos

- ✅ Sistema de gestión de temas (3 temas predefinidos)
- ✅ Gestión de beneficios con paleta de colores
- ✅ Gestión de sección de beneficios con paleta de colores
- ✅ Corrección de duplicados en beneficios
- ✅ Mejoras en componentes UI

## 🔧 Paso 1: Preparar el Proyecto Localmente

### 1.1 Compilar Assets para Producción

```bash
npm run build
```

Esto genera los archivos en `public/build/` que DEBEN subirse.

### 1.2 Verificar Archivos Compilados

Verifica que existan estos archivos:
- `public/build/assets/app-*.js`
- `public/build/assets/app-*.css`
- `public/build/manifest.json`

## 📤 Paso 2: Archivos a Subir

### ✅ SUBIR TODO EXCEPTO:

**NO subir:**
- ❌ `node_modules/` (no necesario)
- ❌ `.git/` (no necesario)
- ❌ `.env` (ya existe en el servidor, NO sobrescribir)
- ❌ `storage/logs/*.log` (logs locales)
- ❌ `storage/framework/cache/data/*` (cache local)
- ❌ `storage/framework/sessions/*` (sesiones locales)
- ❌ `storage/framework/views/*` (vistas compiladas locales)
- ❌ `bootstrap/cache/*.php` (cache de bootstrap local)
- ❌ Archivos `.backup`
- ❌ `database/database.sqlite` (si existe)

### ✅ ESTRUCTURA COMPLETA A SUBIR:

```
public_html/
├── app/                    ✅ SUBIR (todos los cambios)
├── bootstrap/              ✅ SUBIR (sin cache)
├── config/                 ✅ SUBIR
├── database/              ✅ SUBIR (migrations y seeders)
│   ├── migrations/        ✅ SUBIR (nuevas migraciones)
│   └── seeders/           ✅ SUBIR (nuevos seeders)
├── public/                ✅ SUBIR (MUY IMPORTANTE)
│   ├── index.php
│   ├── .htaccess
│   ├── favicon.svg
│   ├── favicon.ico
│   └── build/             ✅ SUBIR (assets compilados)
├── resources/             ✅ SUBIR (todas las vistas)
│   └── views/
│       └── admin/
│           └── themes/    ✅ NUEVO - Subir completo
├── routes/                ✅ SUBIR
├── storage/               ✅ SUBIR (estructura, sin logs)
│   ├── app/
│   │   └── public/        ✅ Subir si hay imágenes
│   └── framework/         ✅ Subir estructura vacía
├── vendor/                ✅ SUBIR (o instalar en servidor)
├── artisan                ✅ SUBIR
├── composer.json          ✅ SUBIR
├── composer.lock          ✅ SUBIR
├── package.json           ✅ SUBIR
├── tailwind.config.js     ✅ SUBIR
├── vite.config.js         ✅ SUBIR
└── postcss.config.js      ✅ SUBIR
```

## 🔄 Paso 3: Proceso de Actualización en Hostinger

### Opción A: Actualización Completa (Recomendado)

1. **Hacer backup de la base de datos actual** (desde el panel de Hostinger)

2. **Subir todos los archivos nuevos/modificados** vía FTP/SFTP

3. **Conectar por SSH** y ejecutar:

```bash
# Ir al directorio del proyecto
cd ~/public_html  # o la ruta donde está tu proyecto

# Ejecutar nuevas migraciones
php artisan migrate --force

# Ejecutar nuevos seeders (si es necesario)
php artisan db:seed --class=ThemeSeeder
php artisan db:seed --class=BenefitSeeder
php artisan db:seed --class=BenefitSectionSeeder

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Reoptimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Verificar storage link
php artisan storage:link

# Verificar permisos
chmod -R 755 storage bootstrap/cache
chmod 600 .env
```

### Opción B: Actualización Selectiva (Solo archivos modificados)

Si solo quieres subir los cambios específicos:

**Archivos nuevos/modificados a subir:**
- ✅ `app/Models/Theme.php` (NUEVO)
- ✅ `app/Models/BenefitSection.php` (NUEVO)
- ✅ `app/Http/Controllers/Admin/ThemeController.php` (NUEVO)
- ✅ `app/Http/Controllers/Admin/BenefitSectionController.php` (NUEVO)
- ✅ `app/Http/Controllers/Admin/BenefitController.php` (MODIFICADO)
- ✅ `app/Http/Controllers/HomeController.php` (MODIFICADO)
- ✅ `app/Providers/AppServiceProvider.php` (MODIFICADO)
- ✅ `app/Services/TrackingService.php` (si no existe)
- ✅ `database/migrations/*_create_themes_table.php` (NUEVO)
- ✅ `database/migrations/*_create_benefit_sections_table.php` (NUEVO)
- ✅ `database/migrations/*_add_color_fields_to_benefits_table.php` (NUEVO)
- ✅ `database/migrations/*_add_title_color_to_benefit_sections_table.php` (NUEVO)
- ✅ `database/seeders/ThemeSeeder.php` (NUEVO)
- ✅ `database/seeders/BenefitSectionSeeder.php` (NUEVO)
- ✅ `database/seeders/BenefitSeeder.php` (MODIFICADO)
- ✅ `resources/views/admin/themes/` (NUEVO - carpeta completa)
- ✅ `resources/views/admin/benefit-sections/` (NUEVO - carpeta completa)
- ✅ `resources/views/admin/benefits/` (MODIFICADO - todas las vistas)
- ✅ `resources/views/home.blade.php` (MODIFICADO)
- ✅ `resources/views/dashboard.blade.php` (MODIFICADO)
- ✅ `resources/views/layouts/app.blade.php` (MODIFICADO)
- ✅ `resources/views/layouts/guest.blade.php` (MODIFICADO)
- ✅ `resources/views/components/ui/card.blade.php` (MODIFICADO)
- ✅ `routes/web.php` (MODIFICADO)
- ✅ `public/build/` (NUEVO - assets compilados)
- ✅ `public/favicon.svg` (si no existe)

## 🗄️ Paso 4: Ejecutar Migraciones y Seeders

Después de subir los archivos, conecta por SSH y ejecuta:

```bash
# Ejecutar nuevas migraciones
php artisan migrate --force

# Ejecutar seeders nuevos
php artisan db:seed --class=ThemeSeeder
php artisan db:seed --class=BenefitSectionSeeder
php artisan db:seed --class=BenefitSeeder
```

## ⚙️ Paso 5: Limpiar y Optimizar

```bash
# Limpiar todo
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# Reoptimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

## ✅ Paso 6: Verificar

1. Visita tu sitio web
2. Verifica que el tema se aplica correctamente
3. Prueba acceder a `/admin/themes`
4. Verifica que los beneficios se muestran con colores
5. Revisa los logs si hay errores: `storage/logs/laravel.log`

## 🔍 Verificación de Archivos Críticos

Asegúrate de que estos archivos estén actualizados:

- [ ] `app/Providers/AppServiceProvider.php` - Tiene el view composer para temas
- [ ] `routes/web.php` - Tiene las rutas de themes y benefit-sections
- [ ] `public/build/` - Tiene los assets compilados
- [ ] `resources/views/layouts/app.blade.php` - Usa `$activeTheme`
- [ ] `resources/views/layouts/guest.blade.php` - Usa `$activeTheme`

## 🚨 IMPORTANTE

1. **NO sobrescribas el `.env`** - Mantén el que ya tienes en el servidor
2. **Haz backup de la BD** antes de ejecutar migraciones
3. **Verifica permisos** después de subir archivos
4. **Limpia la caché** después de subir cambios

## 📝 Checklist Rápido

- [ ] `npm run build` ejecutado localmente
- [ ] `public/build/` tiene archivos compilados
- [ ] Archivos nuevos subidos (themes, benefit-sections)
- [ ] Migraciones ejecutadas en servidor
- [ ] Seeders ejecutados en servidor
- [ ] Caché limpiada y reoptimizada
- [ ] Permisos verificados
- [ ] Sitio web funcionando correctamente




