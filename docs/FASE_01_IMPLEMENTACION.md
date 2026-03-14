# Fase 1 — Implementación: Hardening y estabilidad

**Fecha:** 10 de marzo de 2025  
**Estado:** ✅ Completada

---

## Resumen

Se implementaron las mejoras de seguridad y estabilidad definidas en la guía de mejora para proteger las APIs del cotizador, mejorar la validación y optimizar el envío de emails.

---

## Cambios realizados

### 1.1 Protección de APIs del cotizador (Rate Limiting)

**Archivos modificados:**
- `app/Providers/AppServiceProvider.php`
- `routes/web.php`

**Implementación:**

Se configuraron tres rate limiters en `AppServiceProvider`:

| Limiter | Límite | Uso |
|---------|--------|-----|
| `calculate-quotes` | 30/min por IP | Endpoint POST `/api/cotizador/calculate` |
| `send-email` | 5/min por IP | Endpoint POST `/api/cotizador/send-email` |
| `cotizador-api` | 60/min por IP | Endpoints GET `/api/cotizador/products` y `/shipping-methods` |

Las rutas del cotizador ahora aplican estos middlewares de throttling para evitar abuso.

---

### 1.2 Archivo .env.example

**Archivo creado:** `.env.example`

**Contenido:** Plantilla con todas las variables de entorno necesarias para el proyecto, sin valores sensibles. Incluye:

- Configuración de aplicación (APP_NAME, APP_ENV, etc.)
- Base de datos
- Sesión y caché
- Cola (QUEUE_CONNECTION)
- Mail
- TRACKINGMORE_API_KEY
- WHATSAPP_NUMBER, RED_MOVIL_NUMBER
- CHAT_PROVIDER, TIDIO_PUBLIC_KEY, CRISP_WEBSITE_ID

**Uso en deploy:** Copiar a `.env` y completar los valores reales.

```bash
cp .env.example .env
php artisan key:generate
```

---

### 1.3 Validación fuerte con Form Requests

**Archivos creados:**
- `app/Http/Requests/CalculateQuoteRequest.php`
- `app/Http/Requests/SendQuoteEmailRequest.php`

**CalculateQuoteRequest:**
- Valida: product, quantity, weight, unitValue, shippingMethod
- Obtiene métodos de envío activos dinámicamente de la BD
- Mensajes de error en español

**SendQuoteEmailRequest:**
- Valida: email, subject, message, pdf (base64), quoteData
- Incluye validación custom del PDF (ver 1.4)

**Archivo modificado:** `app/Http/Controllers/CotizadorController.php`
- `calculate()` ahora usa `CalculateQuoteRequest` en lugar de `$request->validate()`
- `sendEmail()` ahora usa `SendQuoteEmailRequest`

---

### 1.4 Límite de tamaño del PDF

**Implementación:** Dentro de `SendQuoteEmailRequest`, regla custom para el campo `pdf`:

- Valida que sea base64 válido
- Decodifica y verifica tamaño máximo: **2000 KB**
- Mensaje de error si excede el límite

---

### 1.5 Envío de emails con Jobs

**Archivo creado:** `app/Jobs/SendQuoteEmailJob.php`

**Implementación:**
- Job que recibe: email, subject, message, pdfBase64, quoteData
- Envía el `QuoteEmail` de forma asíncrona
- Log de errores si falla el envío

**Archivo modificado:** `app/Http/Controllers/CotizadorController.php`
- `sendEmail()` ahora despacha `SendQuoteEmailJob::dispatch()` en lugar de `Mail::send()`
- La respuesta al usuario es inmediata; el email se envía en segundo plano

**⚠️ Importante:** Para que los emails se envíen, debe ejecutarse el queue worker:

```bash
php artisan queue:work
```

En producción (Hostinger, etc.) configurar un proceso supervisor o cron para mantener el worker activo.

Para desarrollo con envío inmediato (sin cola), usar en `.env`:

```
QUEUE_CONNECTION=sync
```

---

## Verificación

1. **Rate limiting:** Hacer más de 30 requests POST a `/api/cotizador/calculate` en 1 minuto → debe retornar 429 Too Many Requests.

2. **Form Request:** Enviar datos inválidos a calculate o send-email → debe retornar 422 con errores de validación.

3. **PDF grande:** Enviar base64 de PDF > 2000 KB a send-email → debe fallar validación.

4. **Email Job:** Con `QUEUE_CONNECTION=database` y `php artisan queue:work` corriendo, el email debe enviarse en segundo plano.

---

## Archivos creados/modificados

| Acción | Archivo |
|--------|---------|
| Creado | `.env.example` |
| Creado | `app/Http/Requests/CalculateQuoteRequest.php` |
| Creado | `app/Http/Requests/SendQuoteEmailRequest.php` |
| Creado | `app/Jobs/SendQuoteEmailJob.php` |
| Modificado | `app/Providers/AppServiceProvider.php` |
| Modificado | `app/Http/Controllers/CotizadorController.php` |
| Modificado | `routes/web.php` |
