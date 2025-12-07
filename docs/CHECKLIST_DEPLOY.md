# ✅ Checklist de Despliegue en Hostinger

## 📦 Preparación Local

- [ ] Ejecutar `npm run build` para compilar assets
- [ ] Ejecutar `composer install --optimize-autoloader --no-dev`
- [ ] Verificar que `.env.example` existe y está actualizado
- [ ] Verificar que `public/.htaccess` está configurado
- [ ] Verificar que `storage/app/public` tiene contenido (si aplica)
- [ ] Revisar que no hay archivos sensibles en el repositorio

## 📤 Subida de Archivos

- [ ] Subir todos los archivos EXCEPTO:
  - [ ] `node_modules/` (no subir)
  - [ ] `.git/` (no subir)
  - [ ] `.env` (no subir)
  - [ ] `storage/logs/*.log` (no subir logs)
  - [ ] `tests/` (opcional)
  - [ ] Archivos de backup (`.backup`, `.old`)

## ⚙️ Configuración en el Servidor

- [ ] Crear archivo `.env` basado en `.env.example`
- [ ] Configurar `APP_ENV=production`
- [ ] Configurar `APP_DEBUG=false`
- [ ] Configurar `APP_URL` con tu dominio (HTTPS)
- [ ] Configurar credenciales de base de datos
- [ ] Generar `APP_KEY` con `php artisan key:generate`

## 🗄️ Base de Datos

- [ ] Crear base de datos MySQL en Hostinger
- [ ] Ejecutar `php artisan migrate --force`
- [ ] (Opcional) Ejecutar seeders:
  - [ ] `php artisan db:seed --class=SliderSeeder`
  - [ ] `php artisan db:seed --class=ProcessStepSeeder`
  - [ ] `php artisan db:seed --class=ProcessSectionSeeder`
  - [ ] `php artisan db:seed --class=AlertBannerSeeder`

## 📁 Archivos y Permisos

- [ ] Ejecutar `php artisan storage:link`
- [ ] Configurar permisos: `chmod -R 755 storage bootstrap/cache`
- [ ] Verificar que `public/storage` existe y funciona
- [ ] Verificar que las imágenes se cargan correctamente

## ⚡ Optimización

- [ ] Ejecutar `php artisan config:cache`
- [ ] Ejecutar `php artisan route:cache`
- [ ] Ejecutar `php artisan view:cache`
- [ ] Ejecutar `php artisan event:cache`

## 🌐 Configuración Web

- [ ] Document Root apunta a `public/` (o configurar redirección)
- [ ] Verificar que `.htaccess` funciona
- [ ] Verificar que HTTPS está activo
- [ ] Configurar redirección HTTP → HTTPS (si aplica)

## ✅ Verificación Final

- [ ] Página de inicio carga correctamente
- [ ] Login/Registro funciona
- [ ] Dashboard carga correctamente
- [ ] Imágenes se cargan (storage link)
- [ ] CSS/JS se cargan correctamente
- [ ] Formularios funcionan
- [ ] Base de datos conecta correctamente
- [ ] No hay errores en los logs

## 🔒 Seguridad

- [ ] `APP_DEBUG=false` en producción
- [ ] `.env` tiene permisos 600
- [ ] No hay archivos sensibles accesibles públicamente
- [ ] HTTPS configurado correctamente
- [ ] Backups de base de datos configurados

## 📝 Post-Despliegue

- [ ] Monitorear logs: `storage/logs/laravel.log`
- [ ] Verificar rendimiento
- [ ] Configurar backups automáticos
- [ ] Documentar credenciales de forma segura

---

**¿Todo listo?** ✅ Tu aplicación debería estar funcionando en producción.





