# API para Mobile App (React Native / Flutter)

Documentación de endpoints para consumir desde una aplicación móvil.

---

## Base URL

```
{APP_URL}/api
```

Ejemplo: `https://flatrateimports.com/api`

---

## Autenticación

Los endpoints del cotizador son **públicos** (rate limited). Para endpoints de usuario (cotizaciones, paquetes) se requiere autenticación Laravel Sanctum o sesión.

### Opción 1: Laravel Sanctum (recomendado para móvil)

1. Instalar Sanctum: `composer require laravel/sanctum`
2. Publicar config: `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`
3. En requests, enviar header: `Authorization: Bearer {token}`

### Opción 2: API Token

Crear token para el usuario y enviarlo en cada request.

---

## Endpoints del Cotizador (públicos)

### GET /api/cotizador/products

Lista de productos activos con impuestos.

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "key": "Celulares_NuevosSolamente",
      "name": "Celulares Nuevos",
      "adValorem": 0.15,
      "arancelEspecifico": 0
    }
  ]
}
```

### GET /api/cotizador/shipping-methods

Métodos de envío disponibles.

**Response:**
```json
{
  "success": true,
  "data": ["maritimo", "aereo", "courier4x4"]
}
```

### POST /api/cotizador/calculate

Calcular cotización.

**Body:**
```json
{
  "product": "Celulares_NuevosSolamente",
  "quantity": 1,
  "weight": 15,
  "unitValue": 200,
  "shippingMethod": "maritimo"
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "productCost": 200,
    "shippingCost": 60,
    "totalImpuestos": 45.2,
    "totalCotizacion": 305.2,
    "weight": 15,
    "productName": "Celulares Nuevos"
  }
}
```

### POST /api/cotizador/send-email

Enviar cotización por email (requiere PDF en base64).

**Body:**
```json
{
  "email": "cliente@ejemplo.com",
  "subject": "Cotización de Importación",
  "message": "Adjunto cotización",
  "pdf": "base64_encoded_pdf_string",
  "quoteData": { ... }
}
```

---

## Endpoints de Usuario (autenticados)

### GET /mis-cotizaciones

Historial de cotizaciones del usuario (HTML). Para API, crear endpoint dedicado.

### GET /mis-paquetes

Lista de paquetes del usuario (HTML). Para API, crear endpoint dedicado.

---

## Extensión recomendada para Mobile

Para una app móvil nativa, crear controladores API adicionales:

```
GET  /api/user/quotes      - Lista cotizaciones (JSON)
GET  /api/user/quotes/:id - Detalle cotización
GET  /api/user/packages   - Lista paquetes (JSON)
GET  /api/user/packages/:tracking - Detalle paquete
POST /api/user/packages   - Agregar paquete por tracking
```

---

## Rate Limits

- `cotizador-api`: 60 req/min
- `calculate-quotes`: 20 req/min
- `send-email`: 5 req/min

---

## Ejemplo Flutter (Dart)

```dart
final response = await http.get(
  Uri.parse('$baseUrl/api/cotizador/products'),
);
final data = jsonDecode(response.body);
```

## Ejemplo React Native (JavaScript)

```javascript
const response = await fetch(`${baseUrl}/api/cotizador/products`);
const data = await response.json();
```
