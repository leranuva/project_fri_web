# 📤 Archivos a Subir a Hostinger - 7 de Diciembre 2025

## 📋 Lista Completa de Archivos

### 🆕 Archivos NUEVOS (Subir estos)

#### Controladores
```
app/Http/Controllers/Admin/ProjectCostsController.php
```

#### Vistas
```
resources/views/admin/project-costs/index.blade.php
resources/views/components/whatsapp-float.blade.php          ← NUEVO - Botón flotante WhatsApp
```

#### Documentación (opcional, pero recomendado)
```
docs/ESTIMACION_COSTOS_PROYECTO.md
docs/CHECKLIST_ACTUALIZACION_7_DICIEMBRE_2025.md
docs/ARCHIVOS_CAMBIADOS_7_DICIEMBRE_2025.md
docs/COMANDOS_SSH_HOSTINGER_7_DICIEMBRE_2025.md
docs/RESUMEN_ACTUALIZACION_7_DICIEMBRE_2025.md
docs/ARCHIVOS_SUBIR_HOSTINGER_7_DICIEMBRE_2025.md
```

---

### 📝 Archivos MODIFICADOS (Reemplazar estos)

#### Modelos
```
app/Models/ShippingRate.php
```

#### Helpers
```
app/Helpers/CotizadorHelper.php
```

#### Controladores
```
app/Http/Controllers/CotizadorController.php
```

#### Vistas
```
resources/views/cotizador.blade.php
resources/views/dashboard.blade.php
resources/views/layouts/app.blade.php                        ← MODIFICADO - Incluye WhatsApp
resources/views/layouts/guest.blade.php                      ← MODIFICADO - Incluye WhatsApp
```

#### Rutas
```
routes/web.php
```

#### Configuración
```
config/app.php                                                ← MODIFICADO - Configuración WhatsApp
```

---

### 📦 Assets Compilados (OBLIGATORIO - Subir carpeta completa)

```
public/build/
├── manifest.json
├── assets/
│   ├── app-*.css
│   ├── app-*.js
│   ├── cotizador-alpine-*.js
│   ├── index.es-*.js
│   └── purify.es-*.js
```

**⚠️ IMPORTANTE:** Los archivos dentro de `public/build/assets/` tienen nombres con hash (ej: `app-DtEWhnu1.css`). 
Sube TODA la carpeta `public/build/` completa.

---

## 📁 Estructura de Carpetas en Hostinger

```
public_html/
├── app/
│   ├── Http/Controllers/Admin/
│   │   └── ProjectCostsController.php          ← NUEVO
│   ├── Models/
│   │   └── ShippingRate.php                   ← MODIFICADO
│   └── Helpers/
│       └── CotizadorHelper.php                 ← MODIFICADO
├── resources/
│   └── views/
│       ├── admin/
│       │   └── project-costs/
│       │       └── index.blade.php             ← NUEVO
│       ├── components/
│       │   └── whatsapp-float.blade.php         ← NUEVO - Botón WhatsApp
│       ├── layouts/
│       │   ├── app.blade.php                    ← MODIFICADO - Incluye WhatsApp
│       │   └── guest.blade.php                  ← MODIFICADO - Incluye WhatsApp
│       ├── cotizador.blade.php                 ← MODIFICADO
│       └── dashboard.blade.php                 ← MODIFICADO
├── routes/
│   └── web.php                                 ← MODIFICADO
├── config/
│   └── app.php                                 ← MODIFICADO - Config WhatsApp
└── public/
    └── build/                                   ← COMPILAR Y SUBIR TODO
        ├── manifest.json
        └── assets/
            └── (todos los archivos)
```

---

## 🚀 Orden Recomendado de Subida

### Paso 1: Archivos Nuevos
1. `app/Http/Controllers/Admin/ProjectCostsController.php`
2. `resources/views/admin/project-costs/index.blade.php` (crear carpeta si no existe)
3. `resources/views/components/whatsapp-float.blade.php` (crear carpeta `components/` si no existe)

### Paso 2: Archivos Modificados
1. `app/Models/ShippingRate.php`
2. `app/Helpers/CotizadorHelper.php`
3. `app/Http/Controllers/CotizadorController.php`
4. `resources/views/cotizador.blade.php`
5. `resources/views/dashboard.blade.php`
6. `resources/views/layouts/app.blade.php`
7. `resources/views/layouts/guest.blade.php`
8. `routes/web.php`
9. `config/app.php`

### Paso 3: Assets Compilados
1. Eliminar carpeta `public/build/` antigua (si existe)
2. Subir carpeta `public/build/` completa nueva

### Paso 4: Documentación (opcional)
- Subir archivos de `docs/` si quieres mantener documentación en servidor

---

## ✅ Verificación Post-Subida

Después de subir todos los archivos, ejecutar en SSH:

```bash
# Verificar que los archivos están en su lugar
ls -la app/Http/Controllers/Admin/ProjectCostsController.php
ls -la resources/views/admin/project-costs/index.blade.php
ls -la resources/views/components/whatsapp-float.blade.php

# Verificar assets
ls -la public/build/assets/

# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Configurar WhatsApp en .env (agregar manualmente)
# IMPORTANTE: El mensaje debe estar entre comillas dobles
# WHATSAPP_NUMBER=593999999999
# WHATSAPP_MESSAGE="Hola, me interesa conocer más sobre sus servicios de importación."
```

---

## 📊 Resumen de Archivos

- **Archivos nuevos:** 4 (1 controlador, 2 vistas, 1 doc)
- **Archivos modificados:** 9
- **Carpetas nuevas:** 2 (`resources/views/admin/project-costs/`, `resources/views/components/`)
- **Assets compilados:** 1 carpeta completa (`public/build/`)

**Total:** ~14 archivos/carpetas a subir

---

## ⚠️ IMPORTANTE

1. **Assets DEBEN compilarse:** Ya compilados con `npm run build`
2. **Subir carpeta completa:** `public/build/` con todos sus contenidos
3. **Permisos:** Asegurar que `storage/` y `bootstrap/cache/` tienen permisos correctos
4. **Caché:** Limpiar caché después de subir archivos
5. **WhatsApp:** Agregar variables `WHATSAPP_NUMBER` y `WHATSAPP_MESSAGE` al `.env` en el servidor

---

## 📱 Configuración de WhatsApp

Después de subir los archivos, agregar al archivo `.env` en el servidor:

```env
WHATSAPP_NUMBER=593999999999
WHATSAPP_MESSAGE="Hola, me interesa conocer más sobre sus servicios de importación."
```

**⚠️ IMPORTANTE:** El mensaje DEBE estar entre comillas dobles (`"`) porque contiene comas y espacios. Sin las comillas, el archivo `.env` dará error de parseo.

**Formato del número:** Código de país + número sin espacios (ejemplo: `593999999999` para Ecuador)

---

*Última actualización: 7 de Diciembre 2025 - Incluye implementación de WhatsApp flotante*

