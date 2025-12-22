# 📦 Actualización 21 de Diciembre 2025

## 🎯 Cambios Realizados

### 1. ✅ Sección "Temas de Interés" Mejorada
- **Archivos modificados:**
  - `database/migrations/2025_12_21_211710_add_subtitle_and_footer_text_to_blog_sections_table.php` (NUEVO)
  - `app/Models/BlogSection.php`
  - `app/Http/Controllers/Admin/BlogSectionController.php`
  - `resources/views/admin/blog-sections/edit.blade.php`
  - `resources/views/home.blade.php`
  - `database/seeders/BlogSectionSeeder.php`

- **Cambios:**
  - Agregados campos `subtitle` y `footer_text` a la sección de blog
  - Ahora funciona igual que la sección "Flat Rate Imports"
  - Permite configurar subtítulo y texto del footer

### 2. ✅ Subida de Imágenes PNG para Logos de Tiendas
- **Archivos modificados:**
  - `database/migrations/2025_12_21_215041_add_logo_image_to_stores_table.php` (NUEVO)
  - `app/Models/Store.php`
  - `app/Http/Controllers/Admin/StoreController.php`
  - `resources/views/admin/stores/edit.blade.php`
  - `resources/views/admin/stores/create.blade.php`
  - `resources/views/home.blade.php`

- **Cambios:**
  - Agregado campo `logo_image` para subir archivos PNG
  - Selector entre "Código SVG" y "Subir PNG"
  - Las imágenes PNG se guardan en `storage/app/public/stores/`
  - Prioridad: PNG > SVG > Nombre de tienda

### 3. ✅ Subida de Imágenes para Artículos del Blog
- **Archivos modificados:**
  - `app/Http/Controllers/Admin/BlogPostController.php`
  - `resources/views/admin/blog-posts/edit.blade.php`
  - `resources/views/admin/blog-posts/create.blade.php`

- **Cambios:**
  - Agregada funcionalidad de subida de archivos para imágenes destacadas
  - Selector entre "Usar URL" y "Subir desde PC"
  - Las imágenes se guardan en `storage/app/public/blog-posts/`

### 4. ✅ Mejoras CSS en Sección de Blog Posts
- **Archivos modificados:**
  - `resources/css/app.css`
  - `resources/views/home.blade.php`
  - `resources/views/admin/blog-posts/show.blade.php`

- **Cambios:**
  - Cambio de `object-cover` a `object-contain` para evitar cortes
  - Altura aumentada de `h-48` a `h-56 sm:h-64`
  - Mejoras en layout con flexbox
  - Utilidades `line-clamp` para truncar texto

### 5. ✅ Actualización de URL de Tienda
- **Archivos modificados:**
  - `app/Http/Controllers/Admin/StoreSectionController.php`
  - `resources/views/cotizador.blade.php`
  - `resources/views/components/footer.blade.php`
  - `resources/views/components/advanced-navbar.blade.php`
  - `database/seeders/StoreSectionSeeder.php`
  - `database/seeders/FooterLinkSeeder.php`
  - `resources/views/admin/store-sections/edit.blade.php`

- **Cambios:**
  - Todas las referencias de `https://flatrateimports.com/` actualizadas a `https://flatrateimports.store/`

### 6. ✅ Configuración de Favicon (SVG e ICO)
- **Archivos modificados:**
  - `resources/views/layouts/app.blade.php`
  - `resources/views/layouts/guest.blade.php`

- **Cambios:**
  - Referencias actualizadas para soportar ambos formatos (SVG e ICO)
  - SVG como formato principal, ICO como fallback

---

## 📤 Archivos a Subir a Hostinger

### 🗄️ Base de Datos
1. **Ejecutar migraciones:**
   ```bash
   php artisan migrate --force
   ```

### 📁 Carpetas Completas
1. **`database/migrations/`** - Nueva migración:
   - `2025_12_21_211710_add_subtitle_and_footer_text_to_blog_sections_table.php`
   - `2025_12_21_215041_add_logo_image_to_stores_table.php`

2. **`app/`** - Controladores y modelos actualizados:
   - `app/Models/BlogSection.php`
   - `app/Models/Store.php`
   - `app/Http/Controllers/Admin/BlogSectionController.php`
   - `app/Http/Controllers/Admin/StoreController.php`
   - `app/Http/Controllers/Admin/BlogPostController.php`
   - `app/Http/Controllers/Admin/StoreSectionController.php`

3. **`resources/views/`** - Vistas actualizadas:
   - `resources/views/admin/blog-sections/edit.blade.php`
   - `resources/views/admin/stores/edit.blade.php`
   - `resources/views/admin/stores/create.blade.php`
   - `resources/views/admin/blog-posts/edit.blade.php`
   - `resources/views/admin/blog-posts/create.blade.php`
   - `resources/views/home.blade.php`
   - `resources/views/cotizador.blade.php`
   - `resources/views/layouts/app.blade.php`
   - `resources/views/layouts/guest.blade.php`
   - `resources/views/components/footer.blade.php`
   - `resources/views/components/advanced-navbar.blade.php`
   - `resources/views/admin/store-sections/edit.blade.php`

4. **`resources/css/app.css`** - Estilos actualizados

5. **`public/build/`** - Assets compilados (COMPLETO):
   - `public/build/manifest.json`
   - `public/build/assets/app-Bc3eJvHA.css`
   - `public/build/assets/app-DY2QFhI9.js`
   - `public/build/assets/index.es-B1c1Hnjq.js`
   - `public/build/assets/cotizador-alpine-DOJwrLTm.js`
   - `public/build/assets/purify.es-C65SP4u9.js`

6. **`database/seeders/`** - Seeders actualizados:
   - `database/seeders/BlogSectionSeeder.php`
   - `database/seeders/StoreSectionSeeder.php`
   - `database/seeders/FooterLinkSeeder.php`

---

## 🔧 Comandos SSH en Hostinger

### Paso 1: Ejecutar Migraciones
```bash
cd ~/domains/flatrateimports.com/public_html
php artisan migrate --force
```

### Paso 2: Crear Carpetas de Storage (si no existen)
```bash
mkdir -p storage/app/public/stores
mkdir -p storage/app/public/blog-posts
chmod -R 775 storage/app/public
chmod 775 storage/app/public/stores
chmod 775 storage/app/public/blog-posts
```

### Paso 3: Verificar Enlace Simbólico
```bash
# Verificar que existe
ls -la public/storage

# Si no existe o está roto, crear:
rm -f public/storage
ln -s ../storage/app/public public/storage
```

### Paso 4: Limpiar y Regenerar Cachés
```bash
php artisan optimize:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear

php artisan config:cache
php artisan view:cache
php artisan route:cache
php artisan optimize
```

### Paso 5: Actualizar URL de Tienda en Base de Datos (si es necesario)
```bash
php artisan tinker
```
Luego ejecutar:
```php
\App\Models\StoreSection::where('footer_link', 'https://flatrateimports.com/')->update(['footer_link' => 'https://flatrateimports.store/']);
\App\Models\FooterLink::where('url', 'https://flatrateimports.com/')->update(['url' => 'https://flatrateimports.store/']);
exit
```

---

## ✅ Verificación Post-Despliegue

1. **Verificar migraciones:**
   ```bash
   php artisan migrate:status
   ```

2. **Verificar carpetas de storage:**
   ```bash
   ls -la storage/app/public/stores
   ls -la storage/app/public/blog-posts
   ```

3. **Verificar enlace simbólico:**
   ```bash
   ls -la public/storage
   ```

4. **Probar funcionalidades:**
   - ✅ Editar sección "Temas de Interés" y verificar campos subtitle y footer_text
   - ✅ Editar tienda y subir logo PNG
   - ✅ Editar artículo y subir imagen desde PC
   - ✅ Verificar que los logos PNG se muestran en la página de inicio
   - ✅ Verificar que las imágenes de blog posts no se cortan
   - ✅ Verificar que los enlaces de tienda apuntan a flatrateimports.store

---

## 📝 Notas Importantes

1. **Permisos de Storage:**
   - Asegúrate de que `storage/app/public/stores` y `storage/app/public/blog-posts` tengan permisos 775

2. **Enlace Simbólico:**
   - Si `php artisan storage:link` falla (función exec() deshabilitada), crear manualmente:
     ```bash
     ln -s ../storage/app/public public/storage
     ```

3. **Base de Datos:**
   - Las migraciones agregan nuevos campos, no eliminan datos existentes
   - Los campos nuevos son opcionales (nullable)

4. **Assets Compilados:**
   - Los archivos en `public/build/` deben subirse completos
   - No olvides el `manifest.json` que es crucial para Laravel

---

## 🚀 Checklist de Despliegue

- [ ] Subir carpeta `database/migrations/` completa
- [ ] Subir carpeta `app/` completa
- [ ] Subir carpeta `resources/views/` completa
- [ ] Subir `resources/css/app.css`
- [ ] Subir carpeta `public/build/` completa
- [ ] Subir carpeta `database/seeders/` completa
- [ ] Ejecutar migraciones: `php artisan migrate --force`
- [ ] Crear carpetas de storage si no existen
- [ ] Verificar/crear enlace simbólico de storage
- [ ] Limpiar y regenerar cachés
- [ ] Actualizar URLs de tienda en BD (si es necesario)
- [ ] Verificar funcionalidades

---

## 📞 Soporte

Si encuentras algún problema durante el despliegue, revisa:
- Logs de Laravel: `tail -n 50 storage/logs/laravel.log`
- Permisos de archivos: `ls -la storage/app/public/`
- Enlace simbólico: `ls -la public/storage`

