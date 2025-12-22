# Configurar Correo Electrónico en Hostinger

## 📧 Configuración de Correo para Laravel

### Paso 1: Crear/Verificar Cuenta de Correo en Hostinger

1. Ve al **Panel de Hostinger**
2. **Correo electrónico** → **Cuentas de correo**
3. Verifica que existe: `info@flatrateimports.com`
4. Si no existe, créala:
   - Click en **Crear nueva cuenta de correo**
   - Email: `info`
   - Dominio: `flatrateimports.com`
   - Contraseña: (guarda esta contraseña, la necesitarás)

### Paso 2: Configurar .env

Edita el archivo `.env` y actualiza la sección de correo:

```bash
# Editar .env
nano .env
```

Busca la sección de correo y actualiza:

```env
# ============================================
# CONFIGURACIÓN DE CORREO - HOSTINGER SMTP
# ============================================
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=info@flatrateimports.com
MAIL_PASSWORD=tu_contraseña_del_correo_aqui
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@flatrateimports.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Paso 3: Guardar y Regenerar Cachés

```bash
# Guardar .env (si usaste nano: Ctrl+X, luego Y, luego Enter)

# Limpiar y regenerar cachés
php artisan config:clear
php artisan config:cache
```

## 🔧 Comandos Completos (Copia y Pega)

```bash
# 1. Editar .env
nano .env

# 2. Buscar y actualizar estas líneas:
# MAIL_USERNAME=info@flatrateimports.com
# MAIL_PASSWORD=tu_contraseña_real_aqui
# MAIL_FROM_ADDRESS="info@flatrateimports.com"

# 3. Guardar (Ctrl+X, Y, Enter)

# 4. Limpiar y regenerar cachés
php artisan config:clear
php artisan config:cache

# 5. Verificar configuración
php artisan config:show mail.mailers.smtp.host
php artisan config:show mail.from.address
```

## ⚙️ Configuración Completa del .env

Aquí está la sección completa de correo que debes tener:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=info@flatrateimports.com
MAIL_PASSWORD=tu_contraseña_del_correo
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@flatrateimports.com"
MAIL_FROM_NAME="Flat Rate Imports"
```

## 🔍 Verificar Configuración

### Opción 1: Probar desde Tinker

```bash
php artisan tinker
```

Luego en tinker:

```php
Mail::raw('Test de correo', function($msg) {
    $msg->to('tu-email-personal@ejemplo.com')
        ->subject('Test de correo desde Laravel');
});
```

Si no hay errores, el correo se envió correctamente.

### Opción 2: Crear Ruta de Prueba Temporal

Crea una ruta temporal para probar:

```php
// En routes/web.php (temporal, eliminar después)
Route::get('/test-email', function() {
    try {
        Mail::raw('Este es un correo de prueba desde Laravel', function($msg) {
            $msg->to('tu-email-personal@ejemplo.com')
                ->subject('Test de correo - Flat Rate Imports');
        });
        return 'Correo enviado correctamente';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
```

Luego visita: `https://flatrateimports.com/test-email`

**IMPORTANTE:** Elimina esta ruta después de probar.

## ⚠️ Problemas Comunes

### Error: "Connection refused" o "Could not connect"

**Solución:**
1. Verifica que `MAIL_HOST=smtp.hostinger.com`
2. Verifica que `MAIL_PORT=587` (o prueba con `465` y `MAIL_ENCRYPTION=ssl`)
3. Verifica que el correo existe en Hostinger

### Error: "Authentication failed"

**Solución:**
1. Verifica que `MAIL_USERNAME` es el correo completo: `info@flatrateimports.com`
2. Verifica que `MAIL_PASSWORD` es correcta (sin espacios)
3. Prueba cambiar la contraseña del correo en Hostinger

### Error: "Connection timeout"

**Solución:**
1. Verifica que el firewall no bloquea el puerto 587
2. Prueba con puerto 465 y SSL:
   ```env
   MAIL_PORT=465
   MAIL_ENCRYPTION=ssl
   ```

## 📝 Configuración Alternativa (Puerto 465 con SSL)

Si el puerto 587 no funciona, prueba con 465:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info@flatrateimports.com
MAIL_PASSWORD=tu_contraseña
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="info@flatrateimports.com"
MAIL_FROM_NAME="Flat Rate Imports"
```

## ✅ Checklist

- [ ] Correo `info@flatrateimports.com` existe en Hostinger
- [ ] Contraseña del correo está guardada
- [ ] `.env` tiene `MAIL_USERNAME=info@flatrateimports.com`
- [ ] `.env` tiene `MAIL_PASSWORD` con la contraseña correcta
- [ ] `.env` tiene `MAIL_FROM_ADDRESS="info@flatrateimports.com"`
- [ ] Cachés limpiadas y regeneradas
- [ ] Correo de prueba enviado correctamente

## 🔒 Seguridad

**IMPORTANTE:**
- Nunca compartas el contenido del `.env`
- No subas el `.env` a Git (ya está en `.gitignore`)
- Cambia la contraseña si se compromete


