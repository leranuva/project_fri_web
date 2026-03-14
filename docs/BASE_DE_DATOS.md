# Base de Datos - Flat Rate Imports

## Esquema de producción

La base de datos de producción (`u199005242_flat_rate`) contiene el esquema y datos de:

| Tabla | Descripción |
|-------|-------------|
| `users` | Usuarios (admin, customer) |
| `products` | Catálogo de productos para cotización |
| `shipping_rates` | Tarifas de envío (marítimo, aéreo, courier4x4) |
| `tax_rates` | Impuestos (Fodinfa, IVA, Seguro CIF) |
| `packages` | Paquetes y tracking |
| `quotes` | Cotizaciones guardadas (se crea con `migrate`) |
| `alert_banners`, `benefits`, `sliders` | Contenido del sitio |
| `blog_posts`, `blog_sections` | Blog |
| `stores`, `store_sections` | Tiendas asociadas |
| `footer_links`, `footer_sections` | Footer |
| `themes` | Temas visuales |
| `cotizador_sections` | Configuración del cotizador |

## Sincronizar proyecto con la base de datos

### Opción 1: Importar dump de producción

1. Guarda el dump SQL en `database/backups/production_2026-03-11.sql`
2. Crea la base de datos e importa:
   ```bash
   mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS u199005242_flat_rate CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   mysql -u root -p u199005242_flat_rate < database/backups/production_2026-03-11.sql
   ```
3. Configura `.env` con las credenciales
4. Ejecuta migraciones pendientes (añade `quotes`):
   ```bash
   php artisan migrate
   ```

### Opción 2: Migraciones desde cero

```bash
php artisan migrate:fresh --seed
```

**Nota:** Esto borra todos los datos. Usa solo en desarrollo.

## Tabla `quotes`

La tabla `quotes` no existe en el dump de producción (se añadió en Fase 7). Se crea automáticamente al ejecutar `php artisan migrate` después de importar el dump.

## Conexión MariaDB/MySQL

El dump fue generado con MariaDB 11.8.3. El proyecto soporta tanto MySQL como MariaDB. En `config/database.php` puedes usar:

- `mysql` para MySQL
- `mariadb` para MariaDB (mismo driver, optimizado)
