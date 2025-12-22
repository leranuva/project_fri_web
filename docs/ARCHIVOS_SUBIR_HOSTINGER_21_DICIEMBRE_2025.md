# 📤 Archivos a Subir a Hostinger - 21 de Diciembre 2025

## 🎯 Resumen de Cambios

1. ✅ Sección "Temas de Interés" mejorada (subtitle y footer_text)
2. ✅ Subida de logos PNG para tiendas
3. ✅ Subida de imágenes para artículos del blog
4. ✅ Mejoras CSS en sección de blog posts
5. ✅ URL de tienda actualizada a flatrateimports.store
6. ✅ Favicon.ico generado correctamente desde SVG (30,950 bytes)
7. ✅ Referencias de favicon mejoradas con parámetro de versión (?v=2)

---

## 📁 Archivos y Carpetas a Subir

### 1. Base de Datos (Migraciones)
```
database/migrations/
├── 2025_12_21_211710_add_subtitle_and_footer_text_to_blog_sections_table.php (NUEVO)
└── 2025_12_21_215041_add_logo_image_to_stores_table.php (NUEVO)
```

### 2. Aplicación (Controladores y Modelos)
```
app/
├── Models/
│   ├── BlogSection.php
│   └── Store.php
└── Http/Controllers/Admin/
    ├── BlogSectionController.php
    ├── BlogPostController.php
    ├── StoreController.php
    └── StoreSectionController.php
```

### 3. Vistas (Blade Templates)
```
resources/views/
├── admin/
│   ├── blog-sections/
│   │   └── edit.blade.php
│   ├── blog-posts/
│   │   ├── edit.blade.php
│   │   └── create.blade.php
│   ├── stores/
│   │   ├── edit.blade.php
│   │   └── create.blade.php
│   └── store-sections/
│       └── edit.blade.php
├── components/
│   ├── footer.blade.php
│   └── advanced-navbar.blade.php
├── layouts/
│   ├── app.blade.php (ACTUALIZADO - referencias favicon mejoradas)
│   └── guest.blade.php (ACTUALIZADO - referencias favicon mejoradas)
├── home.blade.php
└── cotizador.blade.php
```

### 4. Estilos CSS
```
resources/css/app.css
```

### 5. Assets Compilados (COMPLETO - MUY IMPORTANTE)
```
public/build/
├── manifest.json
└── assets/
    ├── app-Bc3eJvHA.css
    ├── app-DY2QFhI9.js
    ├── cotizador-alpine-DOJwrLTm.js
    ├── index.es-B1c1Hnjq.js
    └── purify.es-C65SP4u9.js
```

### 6. Archivos Públicos Estáticos
```
public/
├── favicon.ico (ACTUALIZADO - 30,950 bytes)
└── favicon.svg
```

### 7. Seeders
```
database/seeders/
├── BlogSectionSeeder.php
├── StoreSectionSeeder.php
└── FooterLinkSeeder.php
```

---

## ⚠️ IMPORTANTE: Orden de Subida

1. **PRIMERO:** Subir migraciones y ejecutarlas
2. **SEGUNDO:** Subir código de aplicación (app/, resources/)
3. **TERCERO:** Subir assets compilados (public/build/)
4. **CUARTO:** Ejecutar comandos SSH para limpiar cachés

---

## 🔧 Comandos SSH (Ejecutar DESPUÉS de subir archivos)

```bash
# 1. Navegar al directorio
cd ~/domains/flatrateimports.com/public_html

# 2. Ejecutar migraciones
php artisan migrate --force

# 3. Crear carpetas de storage (si no existen)
mkdir -p storage/app/public/stores
mkdir -p storage/app/public/blog-posts
chmod -R 775 storage/app/public
chmod 775 storage/app/public/stores
chmod 775 storage/app/public/blog-posts

# 4. Verificar/crear enlace simbólico
ls -la public/storage
# Si no existe o está roto:
rm -f public/storage
ln -s ../storage/app/public public/storage

# 5. Limpiar TODAS las cachés
php artisan optimize:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear

# 6. Regenerar cachés
php artisan config:cache
php artisan view:cache
php artisan route:cache
php artisan optimize

# 7. (Opcional) Actualizar URLs de tienda en BD
php artisan tinker
# Luego ejecutar:
# \App\Models\StoreSection::where('footer_link', 'https://flatrateimports.com/')->update(['footer_link' => 'https://flatrateimports.store/']);
# \App\Models\FooterLink::where('url', 'https://flatrateimports.com/')->update(['url' => 'https://flatrateimports.store/']);
# exit
```

---

## ✅ Verificación Post-Despliegue

```bash
# 1. Verificar migraciones
php artisan migrate:status

# 2. Verificar carpetas de storage
ls -la storage/app/public/stores
ls -la storage/app/public/blog-posts

# 3. Verificar enlace simbólico
ls -la public/storage

# 4. Verificar assets compilados
ls -la public/build/assets/

# 5. Verificar favicon (IMPORTANTE después de subir favicon.ico)
ls -lh public/favicon.*
file public/favicon.ico
# Debe mostrar tamaño ~30KB (NO 0 bytes)
chmod 644 public/favicon.ico
chmod 644 public/favicon.svg
```

---

## 🧪 Pruebas Funcionales

Después del despliegue, verificar:

1. ✅ **Sección "Temas de Interés":**
   - Ir a: Dashboard → Configurar Sección de Blog
   - Verificar que aparecen campos "Subtítulo" y "Texto Debajo de los Cards"

2. ✅ **Logos de Tiendas:**
   - Ir a: Dashboard → Tiendas → Editar Tienda
   - Verificar selector "Código SVG" / "Subir PNG"
   - Probar subir un logo PNG

3. ✅ **Imágenes de Artículos:**
   - Ir a: Dashboard → Temas de Interés → Editar Artículo
   - Verificar selector "Usar URL" / "Subir desde PC"
   - Probar subir una imagen

4. ✅ **Enlaces de Tienda:**
   - Verificar que los enlaces apuntan a `https://flatrateimports.store/`

5. ✅ **Imágenes de Blog:**
   - Verificar que las imágenes no se cortan en la página de inicio

6. ✅ **Favicon:**
   - Verificar acceso directo: `https://flatrateimports.com/favicon.ico`
   - Verificar que aparece en la pestaña del navegador
   - Limpiar caché del navegador (`Ctrl+F5`) si no aparece

---

## 📝 Notas Finales

- ⚠️ **NO olvides subir la carpeta `public/build/` completa** - Es crucial para que los estilos funcionen
- ⚠️ **Ejecutar las migraciones** antes de usar las nuevas funcionalidades
- ⚠️ **Verificar permisos de storage** para que las subidas de archivos funcionen
- ⚠️ **Limpiar cachés** después de subir los archivos

