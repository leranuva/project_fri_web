# Fase 7 — Producto premium

Implementación de PWA, sistema de clientes y documentación para app móvil según `guia-mejora-flat-rate.md`.

---

## 7.1 PWA — Cotizador offline

### Configuración

- **vite-plugin-pwa** instalado y configurado en `vite.config.js`
- **Manifest:** nombre "Flat Rate Imports - Cotizador", `start_url: /cotizador`, `display: standalone`
- **Service Worker:** autoUpdate, cache de assets (JS, CSS, HTML, imágenes)
- **Runtime caching:** productos y métodos de envío (CacheFirst, 24h) para uso offline parcial

### Comportamiento

- La app se puede instalar como PWA desde el navegador
- El cotizador carga offline (assets cacheados)
- Productos y métodos de envío se cachean tras la primera visita online
- El cálculo de cotización requiere conexión (backend)

### Archivos generados

- `public/build/sw.js` — Service Worker
- `public/build/manifest.webmanifest` — Manifest PWA
- `public/build/registerSW.js` — Registro del SW

---

## 7.2 Sistema de clientes

### Mis Paquetes

| Ruta | Descripción |
|------|-------------|
| `GET /mis-paquetes` | Lista de paquetes del usuario |
| `POST /mis-paquetes` | Agregar paquete por número de tracking |
| `GET /mis-paquetes/{trackingNumber}` | Detalle del paquete |
| `POST /mis-paquetes/{trackingNumber}/refresh` | Actualizar info desde API |

- **Controlador:** `PackageHistoryController`
- **Vistas:** `packages/index.blade.php`, `packages/show.blade.php`
- Enlaces en dashboard y menú de usuario

### Mis Cotizaciones

- Ya existía en Fase 5
- Añadido enlace "Pagar" en cada fila

### Pagar envíos

| Ruta | Descripción |
|------|-------------|
| `GET /pagar/{quote}` | Página de pago (estructura preparada) |
| `POST /pagar/{quote}` | Procesar pago (placeholder) |

- **Controlador:** `PaymentController`
- **Policy:** `QuotePolicy` (solo el dueño puede ver/pagar)
- **Vista:** `payments/show.blade.php`
- Integración con Stripe/PayPal pendiente de configurar

---

## 7.3 Documentación API para Mobile App

### Archivo

`docs/API_MOBILE.md`

### Contenido

- Endpoints del cotizador (products, shipping-methods, calculate, send-email)
- Rate limits
- Sugerencia de extensión para endpoints de usuario (quotes, packages)
- Ejemplos en Flutter y React Native

### Próximos pasos para app móvil

1. Instalar Laravel Sanctum para autenticación API
2. Crear endpoints JSON para `/api/user/quotes` y `/api/user/packages`
3. Desarrollar app en React Native o Flutter consumiendo la API
