# Fase 13 — Growth loops

Implementación de calculadoras virales y compartir cotización según `guia-mejora-flat-rate.md`.

---

## 13.1 Calculadoras virales

Páginas SEO con cotizador embebido para keywords de alto tráfico.

| Ruta | Título | Descripción |
|------|--------|-------------|
| `/calculadora-aranceles` | Calculadora de Aranceles Ecuador 2026 | Aranceles e impuestos |
| `/calculadora-courier-4x4` | Calculadora Courier 4x4 Ecuador | Envíos hasta 4kg, $400 FOB |
| `/calculadora-amazon-ecuador` | Calculadora Amazon a Ecuador | Costo de importación |

**Implementación:** Cada calculadora es una página con contenido SEO único y un iframe que carga el cotizador (con `?shipping=courier4x4` para la de Courier 4x4).

**Archivos:**
- `CalculatorController` — aranceles(), courier4x4(), amazonEcuador()
- `resources/views/calculators/show.blade.php`

---

## 13.2 Compartir cotización

**Botón "Compartir cotización"** en los resultados del cotizador.

### Flujo

1. Usuario calcula cotización
2. Clic en "Compartir cotización"
3. POST a `/api/cotizador/share` con `quoteData`
4. Se crea `QuoteShare` con token único
5. Se devuelve URL `/quote/{token}`
6. Se copia al portapapeles

### Tabla quote_shares

| Campo | Tipo | Descripción |
|-------|------|-------------|
| token | string (unique) | Identificador público |
| quote_data | json | Datos de la cotización |
| views | int | Contador de visitas |
| expires_at | timestamp | Expira en 30 días |

### Rutas

- `POST /api/cotizador/share` — crear enlace
- `GET /quote/{token}` — ver cotización compartida

### Vista compartida

`resources/views/quote/share.blade.php` — muestra resumen de la cotización, botones "Crear mi cotización" y "Visitar tienda". Contenido indexable por buscadores.

---

## Archivos creados

| Archivo | Descripción |
|---------|-------------|
| `database/migrations/..._create_quote_shares_table.php` | Tabla quote_shares |
| `app/Models/QuoteShare.php` | Modelo con generateToken(), isExpired() |
| `app/Http/Controllers/QuoteShareController.php` | store(), show() |
| `app/Http/Controllers/CalculatorController.php` | Calculadoras |
| `resources/views/quote/share.blade.php` | Vista cotización compartida |
| `resources/views/calculators/show.blade.php` | Vista calculadoras |

---

## Sitemap

Las calculadoras están incluidas en `/sitemap.xml` con prioridad 0.8.
