# 📝 Comandos para Crear Archivos de Redirección

## ✅ Ya estás en public_html

Según tu prompt `[u671466050@us-bos-web1847 public_html]$`, ya estás en el directorio correcto.

## 📋 Comandos (Sin el cd)

Ejecuta estos comandos directamente:

### 1. Crear index.php:

```bash
cat > index.php << 'EOF'
<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}
require_once __DIR__.'/public/index.php';
EOF
```

### 2. Crear .htaccess:

```bash
cat > .htaccess << 'EOF'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
EOF
```

### 3. Configurar permisos:

```bash
chmod 644 index.php
chmod 644 .htaccess
```

### 4. Verificar que se crearon:

```bash
ls -la index.php
ls -la .htaccess
```

## 🔍 Verificar Ubicación Actual

Si no estás seguro, verifica dónde estás:

```bash
pwd
# Debe mostrar: /home/u671466050/public_html

ls -la | grep -E "app|config|public|vendor"
# Debe mostrar estas carpetas
```

## ✅ Después de Crear los Archivos

1. Prueba: `https://midominio` (debe funcionar)
2. Prueba: `https://midominio/login` (debe funcionar)
3. Limpia la caché del navegador si es necesario





