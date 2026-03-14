# Orden de implementación — Fases 8, 9, 10, 11

Documento que describe el orden lógico de implementación de las fases 8 a 11 según dependencias técnicas.

---

## Orden recomendado

### 1. Fase 8 — Infraestructura SEO profesional

**Por qué primero:** Proporciona la base de analítica, sitemap y meta tags que otras fases pueden usar.

**Componentes:**
- Config `seo.php`
- Componente `analytics.blade.php` (GA4, PostHog)
- `SeoHelper`, `SitemapController`
- Meta tags y Open Graph en layouts
- Blog público
- Eventos de tracking en `analytics.js`

**Dependencias:** Ninguna.

---

### 2. Fase 11 — Embudo de leads

**Por qué segundo:** La tabla `leads` y la captura son independientes del ecommerce y del SEO programático. Permite empezar a capturar datos desde el cotizador de inmediato.

**Componentes:**
- Migración `create_leads_table`
- Modelo `Lead` con `calculateScore()`
- Captura en `CotizadorController` (calculate + sendEmail)
- Panel admin `admin/leads`

**Dependencias:** Ninguna (usa cotizador existente).

---

### 3. Fase 10 — Integración ecommerce

**Por qué tercero:** Usa la config SEO (store_url) y los eventos de analytics ya definidos en Fase 8.

**Componentes:**
- Smart product link en resultados del cotizador
- `storeSearchUrl()` en Alpine
- Evento `store_redirect` en enlaces a tienda
- Config `ECOMMERCE_STORE_URL`

**Dependencias:** Fase 8 (analytics, config seo).

---

### 4. Fase 9 — SEO programático

**Por qué cuarto:** Requiere la infraestructura SEO (meta tags, layouts) y el sitemap para incluir las nuevas URLs.

**Componentes:**
- Migración `create_seo_pages_table`
- Modelo `SeoPage`
- `SeoPageController` (show + showFallback)
- Ruta fallback para slugs dinámicos
- Vista `seo/show.blade.php`
- Panel admin `admin/seo-pages`
- `SeoPageSeeder`

**Dependencias:** Fase 8 (layouts con SEO, sitemap).

---

## Resumen de dependencias

```
Fase 8 (SEO base)
    ├── Fase 10 (usa config, analytics)
    └── Fase 9 (usa layouts, sitemap)

Fase 11 (independiente)
```

---

## Comandos de despliegue

```bash
# Migraciones
php artisan migrate

# Seeders (opcional)
php artisan db:seed --class=SeoPageSeeder

# Variables .env requeridas
# GOOGLE_ANALYTICS_ID, POSTHOG_KEY (opcionales)
# ECOMMERCE_STORE_URL
```

---

## Documentos de referencia

- [FASE_08_IMPLEMENTACION.md](FASE_08_IMPLEMENTACION.md)
- [FASE_09_IMPLEMENTACION.md](FASE_09_IMPLEMENTACION.md)
- [FASE_10_IMPLEMENTACION.md](FASE_10_IMPLEMENTACION.md)
- [FASE_11_IMPLEMENTACION.md](FASE_11_IMPLEMENTACION.md)
