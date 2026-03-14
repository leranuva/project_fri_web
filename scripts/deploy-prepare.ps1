# Script de preparación para despliegue en Hostinger (Windows PowerShell)
# Ejecutar en la carpeta raíz del proyecto antes de subir

Write-Host "=== Preparando Flat Rate Imports para Hostinger ===" -ForegroundColor Cyan

# Composer
Write-Host "`nInstalando dependencias Composer (producción)..." -ForegroundColor Yellow
composer install --optimize-autoloader --no-dev --no-interaction

# NPM
Write-Host "`nCompilando assets..." -ForegroundColor Yellow
npm ci
npm run build

# Optimizar Laravel (NO cachear config/route/view si vas a subir - genera archivos que pueden causar "PailServiceProvider not found" en prod)
# En su lugar, excluye bootstrap/cache/*.php del ZIP o bórralos en el servidor antes de ejecutar artisan
Write-Host "`nCompilando assets completado. NOTA: No ejecutes config:cache antes de subir." -ForegroundColor Yellow
Write-Host "En el servidor, borra bootstrap/cache/*.php antes de los comandos artisan." -ForegroundColor Yellow

Write-Host "`n=== Listo para subir ===" -ForegroundColor Green
Write-Host "Excluye: .env, .git, node_modules"
Write-Host "En el servidor ejecuta:"
Write-Host "  chmod -R 775 storage bootstrap/cache"
Write-Host "  php artisan key:generate"
Write-Host "  php artisan storage:link"
Write-Host "  php artisan migrate --force"
