# Fase 10 — Integración con el ecommerce

Implementación de enlaces inteligentes, recomendaciones y tracking de conversiones según `guia-mejora-flat-rate.md`.

---

## 10.1 Smart product links

**Ubicación:** Resultados del cotizador (`resources/views/cotizador.blade.php`)

Tras calcular una cotización, se muestra:

**"Comprar este producto en la tienda"**

- **URL dinámica:** `https://flatrateimports.store/search?q={producto}`
- El término de búsqueda se toma del nombre del producto o de la key
- Configurable vía `config/seo.php`: `store_url`, `store_search_path`

---

## 10.2 Enlace "Visitar Tienda"

El bloque informativo del cotizador incluye un enlace a la tienda configurado con `config('seo.store_url')` en lugar de URL fija.

---

## 10.3 Tracking de conversiones

**Eventos enviados a GA4 y PostHog:**

| Evento | Cuándo |
|--------|--------|
| `quote_calculated` | Al calcular cotización exitosamente |
| `quote_saved` | Al enviar cotización por email |
| `store_redirect` | Al hacer clic en "Comprar este producto" o "Visitar Tienda" |

**Payload de store_redirect:**
- `url`: URL de destino
- `product`, `productName`, `total`: datos de la cotización (si aplica)

**Flujo de conversión:**
```
Usuario cotiza → quote_calculated
Usuario envía email → quote_saved
Usuario hace clic en tienda → store_redirect
```

Para medir compras en la tienda se requiere configurar conversiones en GA4/PostHog con el ecommerce (pixel, GTM, etc.).

---

## 10.4 Recomendación automática de productos

La guía sugiere "Productos recomendados disponibles para importar" obtenidos del ecommerce vía API/RSS. No implementado en esta fase; el enlace de búsqueda actúa como recomendación básica (el usuario ve resultados en la tienda para el producto cotizado).

---

## Configuración

En `.env`:
```
ECOMMERCE_STORE_URL=https://flatrateimports.store
```

En `config/seo.php`:
- `store_url`: URL base de la tienda
- `store_search_path`: ruta de búsqueda (por defecto `/search`)
