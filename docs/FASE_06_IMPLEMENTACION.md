# Fase 6 — Calidad del software

Implementación de tests automáticos, CI/CD y logging avanzado según `guia-mejora-flat-rate.md`.

---

## 6.1 Tests automáticos

### Archivos creados

| Archivo | Descripción |
|---------|-------------|
| `phpunit.xml` | Configuración PHPUnit con SQLite en memoria |
| `.env.testing` | Variables de entorno para tests |
| `tests/TestCase.php` | Clase base de tests |
| `tests/Unit/TaxCalculatorTest.php` | Tests del calculador de impuestos |
| `tests/Unit/TrackingServiceTest.php` | Tests del servicio de tracking |
| `tests/Unit/CotizadorHelperTest.php` | Tests del helper de formato |
| `tests/Feature/CotizadorTest.php` | Tests de integración del API del cotizador |

### Cobertura

- **Cotizador:** cálculo de cotizaciones, validaciones, productos, métodos de envío
- **API:** endpoints `/api/cotizador/products`, `/api/cotizador/shipping-methods`, `/api/cotizador/calculate`
- **Tracking:** detección de transportistas (USPS, UPS, FedEx, Amazon), fetch sin API (mock)

### Ejecución

```bash
composer test
# o
php artisan test
```

---

## 6.2 CI/CD con GitHub Actions

### Archivo

`.github/workflows/ci.yml`

### Pipeline

1. **Job `test`**
   - Checkout
   - Setup PHP 8.2
   - Cache de Composer
   - `composer install`
   - Copiar `.env.example` → `.env`
   - `php artisan key:generate`
   - `composer test`

2. **Job `pint`**
   - Checkout
   - Setup PHP 8.2
   - `composer install`
   - `./vendor/bin/pint --test` (verifica estilo de código)

### Triggers

- Push y pull requests en ramas `main`, `master`, `develop`

---

## 6.3 Logging avanzado

### TrackingService

- **TrackingMore v2:** log `info` cuando no hay resultados (404), `warning` en errores de API, `error` en excepciones con contexto (tracking_number, carrier, trace)
- **TrackingMore Realtime:** mismo patrón con `warning` y `error` estructurados

### CotizadorController

- **calculate:** log `error` con mensaje, trace e input validado cuando falla el cálculo
- **sendEmail:** log `error` con email, mensaje y trace cuando falla el envío

### SendQuoteEmailJob

- Ya existía: log `error` con email, mensaje y trace cuando falla el envío por Mail

---

## Notas

- Los tests usan base de datos SQLite en memoria (`:memory:`), no requieren MySQL
- Para ejecutar migraciones en producción: `php artisan migrate` (cuando la BD esté disponible)
- El CI usa `.env.example`; asegúrate de que tenga valores por defecto válidos para tests
