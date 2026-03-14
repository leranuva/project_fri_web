# Fase 8 — Infraestructura SEO profesional

Implementación de analítica avanzada, sitemap dinámico, meta tags y Open Graph según `guia-mejora-flat-rate.md`.

---

## 8.1 Analítica avanzada

### Archivos creados

| Archivo | Descripción |
|---------|-------------|
| `config/seo.php` | Configuración SEO, GA4, PostHog, URL tienda |
| `resources/views/components/analytics.blade.php` | Scripts GA4 y PostHog (condicionales) |
| `resources/js/analytics.js` | Funciones de tracking: `trackQuoteCalculated`, `trackQuoteSaved`, `trackTrackingSearch`, `trackCheckoutClick`, `trackStoreRedirect` |
| `app/Helpers/SeoHelper.php` | Helper para título, descripción, imagen y URL de búsqueda en tienda |

### Eventos implementados

- **quote_calculated**: al calcular cotización (producto, total, método envío)
- **quote_saved**: al enviar cotización por email
- **tracking_search**: (estructura lista; falta formulario de tracking público)
- **checkout_click**: (estructura lista)
- **store_redirect**: al hacer clic en enlaces a la tienda

### Variables de entorno (.env)

```
GOOGLE_ANALYTICS_ID=
POSTHOG_KEY=
POSTHOG_HOST=https://us.i.posthog.com
SEO_DEFAULT_TITLE="Flat Rate Imports - Importa desde USA a Ecuador"
SEO_DEFAULT_DESCRIPTION="Cotiza tu envío desde USA a Ecuador..."
ECOMMERCE_STORE_URL=https://flatrateimports.store
```

---

## 8.2 SEO técnico automático

### Sitemap dinámico

**Ruta:** `/sitemap.xml`  
**Controlador:** `SitemapController@index`

Incluye:
- `/` (home)
- `/cotizador`
- `/tracking`
- `/importar-desde-amazon`, `/importar-desde-aliexpress`, `/importar-desde-ebay`
- Páginas SEO dinámicas (`seo_pages`)
- `/blog` y posts individuales

### Meta tags dinámicos

En `layouts/app.blade.php` y `layouts/guest.blade.php`:

- `<title>{{ $seoTitle ?? config('app.name') }}</title>`
- `<meta name="description" content="{{ $seoDescription }}">`

Las vistas pueden pasar `seoTitle`, `seoDescription`, `seoImage` como props al layout.

### Open Graph

- `og:title`
- `og:description`
- `og:image`
- `og:type`
- `og:url`

---

## 8.3 Blog público

**Rutas:**
- `GET /blog` — listado de artículos
- `GET /blog/{id}-{slug}` — artículo individual

**Controlador:** `BlogController`

---

## Notas

- Google Search Console: verificar el sitio y enviar el sitemap manualmente
- PostHog: opcional; configurar `POSTHOG_KEY` para activar
- Los eventos se envían a GA4 y PostHog cuando están configurados
