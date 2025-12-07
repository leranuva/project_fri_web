# ⚡ Despliegue Rápido en Hostinger

## 🎯 Pasos Rápidos

### 1. Preparar Localmente
```bash
# Windows
deploy.bat

# Linux/Mac
bash deploy.sh
```

### 2. Subir Archivos
**Sube TODO excepto:**
- ❌ `node_modules/`
- ❌ `.git/`
- ❌ `.env`
- ❌ `storage/logs/*.log`
- ❌ `tests/`

### 3. En el Servidor (SSH)

```bash
# 1. Crear .env
cp .env.example .env
nano .env  # Editar con tus datos

# 2. Generar clave
php artisan key:generate

# 3. Instalar dependencias
composer install --optimize-autoloader --no-dev

# 4. Migrar base de datos
php artisan migrate --force

# 5. Crear storage link
php artisan storage:link

# 6. Optimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Permisos
chmod -R 755 storage bootstrap/cache
```

### 4. Configurar .env

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tudominio.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=tu_base_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 5. Document Root
Apunta a: `/public_html/public`

## ✅ Listo!





