# Fase 9 — SEO programático

Implementación de páginas SEO dinámicas según `guia-mejora-flat-rate.md`.

---

## 9.1 Tabla seo_pages

**Migración:** `2026_03_11_014152_create_seo_pages_table.php`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| keyword | string | Palabra clave objetivo |
| slug | string (unique) | URL amigable (ej: `importar-iphone-desde-amazon-a-ecuador`) |
| title | string | Título de la página |
| content | text | Contenido HTML |
| product_id | bigint nullable | Producto asociado (para cotizador pre-seleccionado) |
| store_link | string nullable | Enlace directo a la tienda |
| is_active | boolean | Publicado/oculto |
| meta_description | string nullable | Meta description |
| og_image | string nullable | Imagen Open Graph |

---

## 9.2 Rutas y controlador

**Ruta fallback:** Cualquier path no coincidente con rutas definidas se intenta resolver como página SEO.

**Controlador:** `SeoPageController`
- `showFallback(Request)`: recibe el path y llama a `show($slug)`
- `show(string $slug)`: busca en `seo_pages` por slug y renderiza la vista

**Vista:** `resources/views/seo/show.blade.php`
- Contenido HTML de la página
- Enlace al cotizador (con producto pre-seleccionado si aplica)
- Botón a la tienda (store_link o búsqueda por keyword)

---

## 9.3 Panel de administración

**Rutas:** `admin/seo-pages` (resource)

**Vistas:**
- `admin/seo-pages/index.blade.php` — listado con búsqueda
- `admin/seo-pages/create.blade.php` — crear
- `admin/seo-pages/edit.blade.php` — editar
- `admin/seo-pages/show.blade.php` — ver

---

## 9.4 Seeder

**SeoPageSeeder** crea páginas de ejemplo:
- importar-iphone-desde-amazon-a-ecuador
- importar-laptop-desde-amazon-a-ecuador
- importar-desde-amazon
- importar-desde-aliexpress
- importar-desde-ebay

---

## 9.5 Generación con IA (futuro)

La guía menciona generación automática con OpenAI/Claude. La estructura está lista:
- Tabla `seo_pages` con campos necesarios
- Admin para crear/editar manualmente
- Un comando Artisan o job podría generar contenido vía API de IA en una fase posterior

---

## Ejemplo de URL

`/importar-iphone-desde-amazon-a-ecuador` → página con contenido, cotizador y enlace a tienda.
