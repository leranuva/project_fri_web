# 🚀 Guía para Actualizar el Proyecto en Hostinger - Diciembre 2025

Esta guía te ayudará a actualizar tu proyecto en Hostinger con los cambios recientes.

## 📋 Cambios Recientes Incluidos

### ✅ Nuevas Funcionalidades

1. **Sistema de Gestión de Tiendas**
   - Gestión completa de tiendas (CRUD)
   - Configuración de sección de tiendas (título, subtítulo, colores, footer)
   - Ordenamiento de tiendas
   - Logos y enlaces configurables

2. **Sistema de Gestión de Temas de Interés (Blog)**
   - Gestión completa de artículos/blog posts (CRUD)
   - Configuración de sección de blog (título, subtítulo, colores)
   - Imágenes destacadas
   - Enlaces externos configurables

3. **Sistema de Gestión del Footer**
   - Gestión completa de enlaces del footer
   - Gestión de redes sociales con iconos SVG personalizados
   - Configuración de nombre de marca y copyright
   - Ordenamiento de enlaces

4. **Mejoras en Reseteo de Contraseña**
   - Vistas actualizadas con diseño moderno
   - Mensajes en español
   - Mejor experiencia de usuario

## 📦 Archivos Nuevos

### Modelos
- `app/Models/StoreSection.php`
- `app/Models/Store.php`
- `app/Models/BlogSection.php`
- `app/Models/BlogPost.php`
- `app/Models/FooterSection.php`
- `app/Models/FooterLink.php`

### Controladores
- `app/Http/Controllers/Admin/StoreSectionController.php`
- `app/Http/Controllers/Admin/StoreController.php`
- `app/Http/Controllers/Admin/BlogSectionController.php`
- `app/Http/Controllers/Admin/BlogPostController.php`
- `app/Http/Controllers/Admin/FooterSectionController.php`
- `app/Http/Controllers/Admin/FooterLinkController.php`

### Vistas Administrativas - Tiendas
- `resources/views/admin/store-sections/edit.blade.php`
- `resources/views/admin/stores/index.blade.php`
- `resources/views/admin/stores/create.blade.php`
- `resources/views/admin/stores/edit.blade.php`
- `resources/views/admin/stores/show.blade.php`

### Vistas Administrativas - Temas de Interés
- `resources/views/admin/blog-sections/edit.blade.php`
- `resources/views/admin/blog-posts/index.blade.php`
- `resources/views/admin/blog-posts/create.blade.php`
- `resources/views/admin/blog-posts/edit.blade.php`
- `resources/views/admin/blog-posts/show.blade.php`

### Vistas Administrativas - Footer
- `resources/views/admin/footer-sections/edit.blade.php`
- `resources/views/admin/footer-links/index.blade.php`
- `resources/views/admin/footer-links/create.blade.php`
- `resources/views/admin/footer-links/edit.blade.php`
- `resources/views/admin/footer-links/show.blade.php`

### Migraciones
- `database/migrations/2025_12_04_010017_create_store_sections_table.php`
- `database/migrations/2025_12_04_010019_create_stores_table.php`
- `database/migrations/2025_12_04_011455_create_blog_sections_table.php`
- `database/migrations/2025_12_04_011457_create_blog_posts_table.php`
- `database/migrations/2025_12_04_012429_create_footer_sections_table.php`
- `database/migrations/2025_12_04_012538_create_footer_links_table.php`

### Seeders
- `database/seeders/StoreSectionSeeder.php`
- `database/seeders/StoreSeeder.php`
- `database/seeders/BlogSectionSeeder.php`
- `database/seeders/BlogPostSeeder.php`
- `database/seeders/FooterSectionSeeder.php`
- `database/seeders/FooterLinkSeeder.php`

## 🔄 Archivos Modificados

### Controladores
- `app/Http/Controllers/Auth/PasswordResetLinkController.php` - Mensajes en español
- `app/Http/Controllers/Auth/NewPasswordController.php` - Mensajes en español
- `app/Http/Controllers/HomeController.php` - Agregado datos de tiendas, blog y footer

### Providers
- `app/Providers/AppServiceProvider.php` - Agregado view composer para footer

### Vistas
- `resources/views/auth/forgot-password.blade.php` - Diseño actualizado
- `resources/views/auth/reset-password.blade.php` - Diseño actualizado
- `resources/views/components/footer.blade.php` - Datos dinámicos
- `resources/views/home.blade.php` - Secciones de tiendas y blog dinámicas
- `resources/views/dashboard.blade.php` - Enlaces a Tiendas, Temas de Interés y Footer

### Rutas
- `routes/web.php` - Agregadas rutas de tiendas, blog y footer

## 🔧 Paso 1: Preparar el Proyecto Localmente

### 1.1 Compilar Assets para Producción

```bash
npm run build
```

✅ **Ya ejecutado** - Los assets están compilados en `public/build/`

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

### ✅ CARPETAS Y ARCHIVOS CRÍTICOS A SUBIR:

```
public_html/
├── app/                              ✅ SUBIR (nuevos modelos y controladores)
│   ├── Models/
│   │   ├── StoreSection.php         ✅ NUEVO
│   │   ├── Store.php                ✅ NUEVO
│   │   ├── BlogSection.php          ✅ NUEVO
│   │   ├── BlogPost.php             ✅ NUEVO
│   │   ├── FooterSection.php        ✅ NUEVO
│   │   └── FooterLink.php           ✅ NUEVO
│   ├── Http/Controllers/
│   │   ├── Admin/
│   │   │   ├── StoreSectionController.php    ✅ NUEVO
│   │   │   ├── StoreController.php           ✅ NUEVO
│   │   │   ├── BlogSectionController.php     ✅ NUEVO
│   │   │   ├── BlogPostController.php        ✅ NUEVO
│   │   │   ├── FooterSectionController.php    ✅ NUEVO
│   │   │   └── FooterLinkController.php      ✅ NUEVO
│   │   └── Auth/
│   │       ├── PasswordResetLinkController.php  ✅ MODIFICADO
│   │       └── NewPasswordController.php        ✅ MODIFICADO
│   ├── Http/Controllers/
│   │   └── HomeController.php       ✅ MODIFICADO
│   └── Providers/
│       └── AppServiceProvider.php    ✅ MODIFICADO
├── database/
│   ├── migrations/
│   │   ├── 2025_12_04_010017_create_store_sections_table.php      ✅ NUEVO
│   │   ├── 2025_12_04_010019_create_stores_table.php               ✅ NUEVO
│   │   ├── 2025_12_04_011455_create_blog_sections_table.php        ✅ NUEVO
│   │   ├── 2025_12_04_011457_create_blog_posts_table.php            ✅ NUEVO
│   │   ├── 2025_12_04_012429_create_footer_sections_table.php       ✅ NUEVO
│   │   └── 2025_12_04_012538_create_footer_links_table.php          ✅ NUEVO
│   └── seeders/
│       ├── StoreSectionSeeder.php    ✅ NUEVO
│       ├── StoreSeeder.php           ✅ NUEVO
│       ├── BlogSectionSeeder.php    ✅ NUEVO
│       ├── BlogPostSeeder.php        ✅ NUEVO
│       ├── FooterSectionSeeder.php   ✅ NUEVO
│       └── FooterLinkSeeder.php      ✅ NUEVO
├── resources/views/
│   ├── admin/
│   │   ├── store-sections/          ✅ NUEVO - Carpeta completa
│   │   │   └── edit.blade.php
│   │   ├── stores/                   ✅ NUEVO - Carpeta completa
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   └── show.blade.php
│   │   ├── blog-sections/            ✅ NUEVO - Carpeta completa
│   │   │   └── edit.blade.php
│   │   ├── blog-posts/               ✅ NUEVO - Carpeta completa
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   └── show.blade.php
│   │   ├── footer-sections/          ✅ NUEVO - Carpeta completa
│   │   │   └── edit.blade.php
│   │   └── footer-links/             ✅ NUEVO - Carpeta completa
│   │       ├── index.blade.php
│   │       ├── create.blade.php
│   │       ├── edit.blade.php
│   │       └── show.blade.php
│   ├── auth/
│   │   ├── forgot-password.blade.php ✅ MODIFICADO
│   │   └── reset-password.blade.php  ✅ MODIFICADO
│   ├── components/
│   │   └── footer.blade.php          ✅ MODIFICADO
│   ├── home.blade.php                ✅ MODIFICADO
│   └── dashboard.blade.php           ✅ MODIFICADO
├── routes/
│   └── web.php                       ✅ MODIFICADO
└── public/
    └── build/                        ✅ CRÍTICO - Assets compilados
```

## 🔄 Paso 3: Proceso de Actualización en Hostinger

### 3.1 Hacer Backup

1. **Backup de la base de datos** (desde el panel de Hostinger)
2. **Backup de archivos críticos** (opcional pero recomendado)

### 3.2 Subir Archivos

Sube todos los archivos nuevos y modificados vía FTP/SFTP o File Manager de Hostinger.

### 3.3 Conectar por SSH y Ejecutar Comandos

```bash
# 1. Ir al directorio del proyecto
cd ~/public_html

# 2. Ejecutar nuevas migraciones
php artisan migrate --force

# 3. Ejecutar nuevos seeders
php artisan db:seed --class=StoreSectionSeeder
php artisan db:seed --class=StoreSeeder
php artisan db:seed --class=BlogSectionSeeder
php artisan db:seed --class=BlogPostSeeder
php artisan db:seed --class=FooterSectionSeeder
php artisan db:seed --class=FooterLinkSeeder

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

# 6. Verificar storage link (si no existe)
php artisan storage:link

# 7. Verificar permisos
chmod -R 755 storage bootstrap/cache
chmod 600 .env
```

## ✅ Paso 4: Verificación

Después de actualizar, verifica:

1. ✅ **Dashboard** - Debe tener enlaces a "Tiendas", "Temas de Interés" y "Footer"
2. ✅ **Gestión de Tiendas** - `/admin/stores` debe funcionar
3. ✅ **Configuración de Tiendas** - `/admin/store-sections` debe funcionar
4. ✅ **Gestión de Blog** - `/admin/blog-posts` debe funcionar
5. ✅ **Configuración de Blog** - `/admin/blog-sections` debe funcionar
6. ✅ **Gestión de Footer** - `/admin/footer-links` debe funcionar
7. ✅ **Configuración de Footer** - `/admin/footer-sections` debe funcionar
8. ✅ **Página de inicio** - Debe mostrar tiendas y blog dinámicamente
9. ✅ **Footer del sitio** - Debe mostrar enlaces y redes sociales dinámicamente
10. ✅ **Reseteo de contraseña** - `/forgot-password` debe tener el nuevo diseño

## 🔍 Verificación de Archivos Críticos

Asegúrate de que estos archivos estén actualizados:

- [ ] `app/Providers/AppServiceProvider.php` - Tiene view composer para footer
- [ ] `app/Http/Controllers/HomeController.php` - Tiene datos de tiendas y blog
- [ ] `routes/web.php` - Tiene todas las rutas nuevas (tiendas, blog, footer)
- [ ] `public/build/` - Tiene los assets compilados más recientes
- [ ] `resources/views/components/footer.blade.php` - Usa `$footerLinksForFooter` y `$footerSocials`
- [ ] `resources/views/home.blade.php` - Usa datos dinámicos de tiendas y blog
- [ ] `resources/views/dashboard.blade.php` - Tiene enlaces a todas las nuevas secciones

## 🚨 IMPORTANTE

1. **NO sobrescribas el `.env`** - Mantén el que ya tienes en el servidor
2. **Haz backup de la BD** antes de ejecutar migraciones
3. **Verifica permisos** después de subir archivos
4. **Limpia la caché** después de subir cambios
5. **Verifica que el storage link existe** (`php artisan storage:link`)

## 📝 Checklist Rápido

### Antes de Subir
- [x] `npm run build` ejecutado localmente
- [x] `public/build/` tiene archivos compilados
- [ ] Backup de base de datos realizado

### Archivos a Subir
- [ ] Modelos nuevos (StoreSection, Store, BlogSection, BlogPost, FooterSection, FooterLink)
- [ ] Controladores nuevos (6 controladores)
- [ ] Vistas nuevas (15+ vistas administrativas)
- [ ] Migraciones nuevas (6 migraciones)
- [ ] Seeders nuevos (6 seeders)
- [ ] Archivos modificados (HomeController, AppServiceProvider, rutas, vistas)

### En el Servidor
- [ ] Archivos subidos correctamente
- [ ] Migraciones ejecutadas: `php artisan migrate --force`
- [ ] Seeders ejecutados (6 seeders)
- [ ] Caché limpiada
- [ ] Caché reoptimizada
- [ ] Permisos verificados
- [ ] Storage link verificado

### Verificación Final
- [ ] Sitio web carga correctamente
- [ ] Dashboard muestra todos los enlaces nuevos
- [ ] Gestión de Tiendas funciona
- [ ] Gestión de Blog funciona
- [ ] Gestión de Footer funciona
- [ ] Página de inicio muestra tiendas y blog
- [ ] Footer muestra enlaces dinámicamente
- [ ] Reseteo de contraseña funciona

## 🆘 Solución de Problemas

### Error: "Class not found"
- Verifica que todos los modelos estén subidos
- Ejecuta: `php artisan config:clear`

### Error: "Route not defined"
- Verifica que `routes/web.php` tenga todas las rutas
- Ejecuta: `php artisan route:clear && php artisan route:cache`

### Secciones no muestran datos
- Verifica que los seeders se ejecutaron
- Verifica que `HomeController` tenga los datos
- Ejecuta: `php artisan view:clear && php artisan view:cache`

### Assets no cargan
- Verifica que `public/build/` esté subido completamente
- Verifica permisos: `chmod -R 755 public/build`

## 📞 Soporte

Si encuentras problemas:
1. Revisa los logs: `storage/logs/laravel.log`
2. Verifica permisos de archivos
3. Limpia toda la caché y reoptimiza
4. Verifica que todas las migraciones se ejecutaron correctamente
