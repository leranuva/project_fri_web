#!/bin/bash
# Script de preparación para despliegue en Hostinger
# Ejecutar en local antes de subir los archivos

set -e

echo "=== Preparando Flat Rate Imports para Hostinger ==="

# Instalar dependencias de producción
echo "Instalando dependencias Composer (producción)..."
composer install --optimize-autoloader --no-dev --no-interaction

# Compilar assets
echo "Compilando assets..."
npm ci
npm run build

# NO cachear config/route/view antes de subir - los archivos en bootstrap/cache
# pueden causar "PailServiceProvider not found" en producción (Pail es solo dev)
echo "NOTA: No ejecutes config:cache antes de subir."
echo "En el servidor, borra bootstrap/cache/*.php antes de los comandos artisan."

echo ""
echo "=== Listo para subir ==="
echo "Excluye de la subida: .env, .git, node_modules, .env.example"
echo "Incluye: app, bootstrap, config, database, public, resources, routes, storage, vendor, composer.json, composer.lock, package.json, package-lock.json, vite.config.js, tailwind.config.js, postcss.config.js, y archivos en public/"
echo ""
echo "En el servidor ejecuta:"
echo "  chmod -R 775 storage bootstrap/cache"
echo "  php artisan key:generate"
echo "  php artisan storage:link"
echo "  php artisan migrate --force"
