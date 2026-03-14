# Fase 11 — Embudo automático de leads

Implementación de captura de leads, scoring y estructura para automatización según `guia-mejora-flat-rate.md`.

---

## 11.1 Tabla leads

**Migración:** `2026_03_11_014154_create_leads_table.php`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| email | string (index) | Email del lead |
| producto | string nullable | Nombre del producto cotizado |
| valor | decimal nullable | Valor total de la cotización |
| pais | string nullable | País (ej: Ecuador) |
| score | unsigned int | Puntuación del lead (0-100) |
| quote_count | unsigned int | Número de cotizaciones |
| source | string nullable | Origen (cotizador, cotizador_email) |
| metadata | json nullable | Datos adicionales |

---

## 11.2 Captura automática de leads

**Cuándo se guarda un lead:**

1. **Al calcular cotización** (`CotizadorController@calculate`):
   - Si el usuario está autenticado → se usa su email
   - Si se envía `email` en el request (opcional) → se usa ese email
   - Si no hay email → no se guarda lead

2. **Al enviar cotización por email** (`CotizadorController@sendEmail`):
   - Siempre se guarda/actualiza lead con el email del destinatario

**Request de calculate:** Se aceptan campos opcionales:
- `email`: nullable, email
- `pais`: nullable, string

---

## 11.3 Lead scoring

**Método:** `Lead::calculateScore($valor, $producto, $quoteCount)`

| Criterio | Puntos |
|----------|--------|
| Valor ≥ $1000 | 50 |
| Valor ≥ $500 | 35 |
| Valor ≥ $200 | 20 |
| Valor ≥ $50 | 10 |
| Producto de alto valor (Electronica, Laptops, Celulares, iPhone) | 30 |
| 5+ cotizaciones | 20 |
| 3+ cotizaciones | 10 |
| 2+ cotizaciones | 5 |

**Score máximo:** 100

---

## 11.4 Panel de administración

**Ruta:** `admin/leads`  
**Controlador:** `LeadController@index`

**Vista:** `admin/leads/index.blade.php`
- Listado con email, producto, valor, score, cotizaciones, fecha
- Filtros: búsqueda por email/producto/país, score mínimo
- Colores por score: verde (≥70), amarillo (≥40), gris (<40)

---

## 11.5 Automatización de emails (futuro)

La guía menciona integración con Mailchimp/Brevo. La estructura está lista:
- Tabla `leads` con email y datos de cotización
- Un job o integración externa (n8n, Zapier) puede consumir los leads y enviar secuencias automáticas

**Flujo sugerido:**
```
Usuario calcula cotización → Lead guardado
↓
Email de bienvenida/cotización
↓
3 días después: recordatorio
↓
Oferta de envío + link a ecommerce
```

---

## Notas

- Los leads se actualizan si el mismo email cotiza de nuevo (incrementa `quote_count`, recalcula `score`)
- El campo `source` permite distinguir origen (cotizador vs modal de email)
