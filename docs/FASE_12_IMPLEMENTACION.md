# Fase 12 — Automatización total del marketing

Implementación de webhooks y puntos de integración para n8n, Zapier y CRMs según `guia-mejora-flat-rate.md`.

---

## 12.1 Webhook de leads

Cuando se crea un **nuevo lead** (no al actualizar uno existente), se dispara el evento `LeadCreated` y el listener `SendLeadToWebhook` envía un POST al URL configurado.

### Configuración

En `.env`:
```
WEBHOOK_LEADS_URL=https://tu-n8n.com/webhook/lead
```

### Payload enviado

```json
{
  "event": "lead.created",
  "timestamp": "2026-03-11T12:00:00.000000Z",
  "data": {
    "id": 1,
    "email": "usuario@ejemplo.com",
    "producto": "Electrónica",
    "valor": 250.50,
    "pais": "Ecuador",
    "score": 45,
    "quote_count": 1,
    "source": "cotizador",
    "created_at": "2026-03-11T12:00:00.000000Z"
  }
}
```

### Flujo n8n/Zapier

1. Crear webhook en n8n que reciba el POST
2. Configurar `WEBHOOK_LEADS_URL` con la URL del webhook
3. Conectar a: CRM, email (Mailchimp/Brevo), audiencias de ads, notificación a ventas

---

## 12.2 Archivos creados

| Archivo | Descripción |
|---------|-------------|
| `app/Events/LeadCreated.php` | Evento al crear lead |
| `app/Listeners/SendLeadToWebhook.php` | Envía POST al webhook configurado |
| `config/seo.php` | Añadido `webhook_leads_url`, `webhook_quotes_url` |

### Registro del listener

En `AppServiceProvider::boot()`:
```php
Event::listen(LeadCreated::class, SendLeadToWebhook::class);
```

---

## 12.3 Cuándo se dispara

- **saveLead** (CotizadorController): al crear lead nuevo (no al actualizar)
- **saveLeadFromEmail**: al crear lead nuevo desde el modal de email

---

## Notas

- Si `WEBHOOK_LEADS_URL` está vacío, no se envía nada
- Timeout de 10 segundos
- Errores se registran en log sin afectar el flujo principal
- `WEBHOOK_QUOTES_URL` está preparado para futura integración con cotizaciones
