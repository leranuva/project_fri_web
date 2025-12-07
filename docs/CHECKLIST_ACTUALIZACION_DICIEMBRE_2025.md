# ✅ Checklist de Actualización en Hostinger - Diciembre 2025

## 📦 ANTES DE SUBIR

- [x] Assets compilados (`npm run build` ejecutado)
- [x] `public/build/` contiene archivos compilados
- [ ] Verificar que no hay errores locales
- [ ] Backup de base de datos realizado

## 📤 ARCHIVOS A SUBIR

### Carpetas Completas (Nuevas o Modificadas)
- [ ] `app/` - Toda la carpeta (incluye nuevos modelos y controladores)
- [ ] `database/migrations/` - Todas las migraciones (incluye 6 nuevas)
- [ ] `database/seeders/` - Todos los seeders (incluye 6 nuevos)
- [ ] `resources/views/admin/store-sections/` - **NUEVA** - Carpeta completa
- [ ] `resources/views/admin/stores/` - **NUEVA** - Carpeta completa
- [ ] `resources/views/admin/blog-sections/` - **NUEVA** - Carpeta completa
- [ ] `resources/views/admin/blog-posts/` - **NUEVA** - Carpeta completa
- [ ] `resources/views/admin/footer-sections/` - **NUEVA** - Carpeta completa
- [ ] `resources/views/admin/footer-links/` - **NUEVA** - Carpeta completa
- [ ] `resources/views/auth/` - Vistas modificadas (forgot-password, reset-password)
- [ ] `resources/views/components/footer.blade.php` - Modificado
- [ ] `resources/views/home.blade.php` - Modificado
- [ ] `resources/views/dashboard.blade.php` - Modificado
- [ ] `public/build/` - **CRÍTICO** - Assets compilados
- [ ] `routes/web.php` - Archivo modificado
- [ ] `app/Providers/AppServiceProvider.php` - Modificado
- [ ] `app/Http/Controllers/HomeController.php` - Modificado

### Archivos Específicos Nuevos
**Modelos:**
- [ ] `app/Models/StoreSection.php`
- [ ] `app/Models/Store.php`
- [ ] `app/Models/BlogSection.php`
- [ ] `app/Models/BlogPost.php`
- [ ] `app/Models/FooterSection.php`
- [ ] `app/Models/FooterLink.php`

**Controladores:**
- [ ] `app/Http/Controllers/Admin/StoreSectionController.php`
- [ ] `app/Http/Controllers/Admin/StoreController.php`
- [ ] `app/Http/Controllers/Admin/BlogSectionController.php`
- [ ] `app/Http/Controllers/Admin/BlogPostController.php`
- [ ] `app/Http/Controllers/Admin/FooterSectionController.php`
- [ ] `app/Http/Controllers/Admin/FooterLinkController.php`

**Migraciones:**
- [ ] `database/migrations/2025_12_04_010017_create_store_sections_table.php`
- [ ] `database/migrations/2025_12_04_010019_create_stores_table.php`
- [ ] `database/migrations/2025_12_04_011455_create_blog_sections_table.php`
- [ ] `database/migrations/2025_12_04_011457_create_blog_posts_table.php`
- [ ] `database/migrations/2025_12_04_012429_create_footer_sections_table.php`
- [ ] `database/migrations/2025_12_04_012538_create_footer_links_table.php`

**Seeders:**
- [ ] `database/seeders/StoreSectionSeeder.php`
- [ ] `database/seeders/StoreSeeder.php`
- [ ] `database/seeders/BlogSectionSeeder.php`
- [ ] `database/seeders/BlogPostSeeder.php`
- [ ] `database/seeders/FooterSectionSeeder.php`
- [ ] `database/seeders/FooterLinkSeeder.php`

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

### 1. Migraciones
- [ ] Ejecutar: `php artisan migrate --force`

### 2. Seeders (6 seeders)
- [ ] Ejecutar: `php artisan db:seed --class=StoreSectionSeeder`
- [ ] Ejecutar: `php artisan db:seed --class=StoreSeeder`
- [ ] Ejecutar: `php artisan db:seed --class=BlogSectionSeeder`
- [ ] Ejecutar: `php artisan db:seed --class=BlogPostSeeder`
- [ ] Ejecutar: `php artisan db:seed --class=FooterSectionSeeder`
- [ ] Ejecutar: `php artisan db:seed --class=FooterLinkSeeder`

### 3. Limpiar Caché
- [ ] Ejecutar: `php artisan cache:clear`
- [ ] Ejecutar: `php artisan config:clear`
- [ ] Ejecutar: `php artisan route:clear`
- [ ] Ejecutar: `php artisan view:clear`
- [ ] Ejecutar: `php artisan event:clear`

### 4. Reoptimizar
- [ ] Ejecutar: `php artisan config:cache`
- [ ] Ejecutar: `php artisan route:cache`
- [ ] Ejecutar: `php artisan view:cache`
- [ ] Ejecutar: `php artisan event:cache`

### 5. Verificar Storage Link
- [ ] Ejecutar: `php artisan storage:link` (si no existe)

### 6. Permisos
- [ ] Ejecutar: `chmod -R 755 storage bootstrap/cache`
- [ ] Ejecutar: `chmod 600 .env`

## ✅ VERIFICACIÓN FINAL

### Funcionalidades - Tiendas
- [ ] Dashboard muestra enlace a "Tiendas"
- [ ] Gestión de Tiendas funciona: `/admin/stores`
- [ ] Configuración de Tiendas funciona: `/admin/store-sections`
- [ ] Página de inicio muestra tiendas dinámicamente

### Funcionalidades - Temas de Interés
- [ ] Dashboard muestra enlace a "Temas de Interés"
- [ ] Gestión de Blog funciona: `/admin/blog-posts`
- [ ] Configuración de Blog funciona: `/admin/blog-sections`
- [ ] Página de inicio muestra blog dinámicamente

### Funcionalidades - Footer
- [ ] Dashboard muestra enlace a "Footer"
- [ ] Gestión de Footer funciona: `/admin/footer-links`
- [ ] Configuración de Footer funciona: `/admin/footer-sections`
- [ ] Footer del sitio muestra enlaces dinámicamente
- [ ] Redes sociales se muestran en el footer

### Funcionalidades - Reseteo de Contraseña
- [ ] Reseteo de contraseña funciona: `/forgot-password`
- [ ] Formulario de reseteo tiene nuevo diseño
- [ ] Mensajes de reseteo están en español

### Base de Datos
- [ ] Tabla `store_sections` existe
- [ ] Tabla `stores` existe
- [ ] Tabla `blog_sections` existe
- [ ] Tabla `blog_posts` existe
- [ ] Tabla `footer_sections` existe
- [ ] Tabla `footer_links` existe
- [ ] Datos iniciales están cargados (6 seeders)

### Archivos Críticos
- [ ] `AppServiceProvider` tiene view composer para footer
- [ ] `HomeController` tiene datos de tiendas y blog
- [ ] `routes/web.php` tiene todas las rutas nuevas
- [ ] `public/build/` tiene assets compilados
- [ ] `footer.blade.php` usa variables dinámicas
- [ ] `home.blade.php` usa datos dinámicos

### General
- [ ] Sitio web carga correctamente
- [ ] No hay errores en los logs

## 🆘 Si Algo Falla

1. Revisa logs: `tail -f storage/logs/laravel.log`
2. Verifica permisos: `ls -la storage bootstrap/cache`
3. Limpia todo: `php artisan optimize:clear`
4. Reoptimiza: `php artisan optimize`
5. Verifica migraciones: `php artisan migrate:status`

## 📝 Notas

- Los assets ya están compilados en `public/build/`
- Las migraciones nuevas son 6 (tiendas, blog, footer)
- Los seeders nuevos son 6 (uno por cada tabla)
- Todas las funcionalidades están completamente implementadas
