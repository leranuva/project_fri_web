# Fase 14 — Autoridad SEO masiva

Implementación de blog automático, widgets embebibles y comparadores según `guia-mejora-flat-rate.md`.

---

## 14.1 Blog automático

**Comando Artisan:** `php artisan blog:generate`

### Uso

```bash
# Generar artículo por tema
php artisan blog:generate --topic=amazon
php artisan blog:generate --topic=alibaba
php artisan blog:generate --topic=aranceles
php artisan blog:generate --topic=courier4x4

# Tema aleatorio
php artisan blog:generate

# Vista previa sin guardar
php artisan blog:generate --topic=aranceles --dry-run
```

### Temas disponibles

| topic | Título |
|-------|--------|
| amazon | Cómo importar desde Amazon a Ecuador |
| alibaba | Cómo importar desde Alibaba a Ecuador |
| aranceles | Aranceles Ecuador 2026 - Guía de importación |
| courier4x4 | Courier 4x4 Ecuador - Envíos hasta 4kg |

### Automatización semanal

Añadir a `app/Console/Kernel.php` o al scheduler en `routes/console.php`:

```php
$schedule->command('blog:generate')->weekly();
```

Para generación con IA (OpenAI/Claude), extender el comando para llamar a la API correspondiente.

---

## 14.2 Widget embebible

**URL:** `/embed/cotizador`

Página minimal para embeber en otras webs mediante iframe. Incluye el cotizador y un enlace a Flat Rate Imports.

### Código para embeber

```html
<iframe 
  src="https://tudominio.com/embed/cotizador" 
  width="100%" 
  height="900" 
  frameborder="0"
  title="Cotizador Flat Rate Imports"
></iframe>
```

**Headers:** Se envían `X-Frame-Options: ALLOWALL` y `Content-Security-Policy: frame-ancestors *` para permitir embedding.

---

## 14.3 Comparadores

Páginas SEO para keywords de comparativa. Añadidas al `SeoPageSeeder`:

| Slug | Keyword |
|------|---------|
| mejor-courier-ecuador | mejor courier ecuador |
| costos-importar-amazon-ecuador | costos importar amazon ecuador |

Gestionables desde `admin/seo-pages`. Incluyen contenido, enlace al cotizador y a la tienda.

---

## Archivos creados

| Archivo | Descripción |
|---------|-------------|
| `app/Console/Commands/GenerateBlogPostCommand.php` | Comando blog:generate |
| `app/Http/Controllers/EmbedController.php` | Widget embebible |
| `resources/views/embed/cotizador.blade.php` | Vista embed |
| `resources/views/components/embed-layout.blade.php` | Layout minimal |
| `database/seeders/SeoPageSeeder.php` | Añadidos comparadores |

---

## Rutas

- `GET /embed/cotizador` — widget embebible
