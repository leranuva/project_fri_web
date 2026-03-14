# Backups de Base de Datos

## Base de datos de producción (u199005242_flat_rate)

La base de datos de producción incluye las siguientes tablas:

- `alert_banners`, `benefits`, `benefit_sections`
- `blog_posts`, `blog_sections`
- `cache`, `cache_locks`
- `cotizador_sections`
- `failed_jobs`, `jobs`, `job_batches`
- `footer_links`, `footer_sections`
- `logos`
- `migrations`
- `packages`
- `password_reset_tokens`
- `process_sections`, `process_steps`
- `products`, `shipping_rates`, `tax_rates`
- `sessions`
- `sliders`
- `stores`, `store_sections`
- `themes`
- `users`

**Nota:** La tabla `quotes` no existe en producción. Se creará al ejecutar `php artisan migrate` después de importar el dump.

## Importar el dump de producción

1. Guarda tu dump SQL completo como `production_2026-03-11.sql` en esta carpeta.

2. Crea la base de datos (si no existe):
   ```sql
   CREATE DATABASE IF NOT EXISTS u199005242_flat_rate 
   CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. Importa el dump:
   ```bash
   mysql -u usuario -p u199005242_flat_rate < database/backups/production_2026-03-11.sql
   ```
   
   O desde phpMyAdmin: Importar → Seleccionar archivo → Ejecutar

4. Ejecuta las migraciones pendientes (añade la tabla `quotes`):
   ```bash
   php artisan migrate
   ```

## Configuración .env para producción

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u199005242_flat_rate
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```
