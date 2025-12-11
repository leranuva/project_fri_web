# 📤 Qué Subir a Hostinger - 7 de Diciembre 2025

## ⚠️ IMPORTANTE: NO subas todo el proyecto

Solo debes subir los **archivos nuevos y modificados**. NO subas carpetas completas como `vendor/`, `node_modules/`, etc.

---

## 📁 CARPETAS/ARCHIVOS A SUBIR

### 1. 🆕 Archivos NUEVOS (Subir estos archivos individuales)

#### Controlador
```
app/Http/Controllers/Admin/ProjectCostsController.php
```
**Acción:** Subir este archivo a `app/Http/Controllers/Admin/` en Hostinger

#### Vista (crear carpeta si no existe)
```
resources/views/admin/project-costs/index.blade.php
```
**Acción:** 
- Crear carpeta `project-costs/` dentro de `resources/views/admin/` si no existe
- Subir el archivo `index.blade.php` dentro de esa carpeta

---

### 2. 📝 Archivos MODIFICADOS (Reemplazar estos archivos)

#### Modelo
```
app/Models/ShippingRate.php
```
**Acción:** Reemplazar el archivo existente en Hostinger

#### Helper
```
app/Helpers/CotizadorHelper.php
```
**Acción:** Reemplazar el archivo existente en Hostinger

#### Controlador
```
app/Http/Controllers/CotizadorController.php
```
**Acción:** Reemplazar el archivo existente en Hostinger

#### Vistas
```
resources/views/cotizador.blade.php
resources/views/dashboard.blade.php
```
**Acción:** Reemplazar estos archivos en Hostinger

#### Rutas
```
routes/web.php
```
**Acción:** Reemplazar el archivo existente en Hostinger

---

### 3. 📦 Assets Compilados (OBLIGATORIO - Subir carpeta completa)

```
public/build/
```
**Acción:** Subir TODA la carpeta `public/build/` completa

**Contenido de la carpeta:**
```
public/build/
├── manifest.json
└── assets/
    ├── app-DtEWhnu1.css
    ├── app-DY2QFhI9.js
    ├── cotizador-alpine-DOJwrLTm.js
    ├── index.es-B1c1Hnjq.js
    └── purify.es-B1c1Hnjq.js
```

**⚠️ IMPORTANTE:** 
- Elimina la carpeta `public/build/` antigua en Hostinger (si existe)
- Sube la carpeta `public/build/` completa nueva

---

## 🚫 NO SUBIR (Estas carpetas NO se suben)

```
❌ vendor/              (dependencias PHP - se instalan con composer)
❌ node_modules/        (dependencias Node - se instalan con npm)
❌ .git/                (control de versiones)
❌ storage/logs/*.log    (logs locales)
❌ .env                  (configuración local)
❌ tests/                (tests - no necesario en producción)
```

---

## 📋 RESUMEN - Lista de Archivos a Subir

### Archivos Individuales (9 archivos):

1. ✅ `app/Http/Controllers/Admin/ProjectCostsController.php` (NUEVO)
2. ✅ `resources/views/admin/project-costs/index.blade.php` (NUEVO)
3. ✅ `app/Models/ShippingRate.php` (MODIFICADO)
4. ✅ `app/Helpers/CotizadorHelper.php` (MODIFICADO)
5. ✅ `app/Http/Controllers/CotizadorController.php` (MODIFICADO)
6. ✅ `resources/views/cotizador.blade.php` (MODIFICADO)
7. ✅ `resources/views/dashboard.blade.php` (MODIFICADO)
8. ✅ `routes/web.php` (MODIFICADO)

### Carpetas Completas (1 carpeta):

9. ✅ `public/build/` (carpeta completa con todos sus archivos)

---

## 🗂️ Estructura en Hostinger

Después de subir, la estructura debe quedar así:

```
public_html/
├── app/
│   ├── Http/Controllers/Admin/
│   │   ├── ProjectCostsController.php          ← NUEVO (subir)
│   │   └── (otros controladores existentes)
│   ├── Models/
│   │   └── ShippingRate.php                   ← REEMPLAZAR
│   └── Helpers/
│       └── CotizadorHelper.php                ← REEMPLAZAR
├── resources/
│   └── views/
│       ├── admin/
│       │   └── project-costs/                  ← CREAR CARPETA
│       │       └── index.blade.php              ← NUEVO (subir)
│       ├── cotizador.blade.php                 ← REEMPLAZAR
│       └── dashboard.blade.php                 ← REEMPLAZAR
├── routes/
│   └── web.php                                 ← REEMPLAZAR
└── public/
    └── build/                                   ← REEMPLAZAR CARPETA COMPLETA
        ├── manifest.json
        └── assets/
            └── (todos los archivos)
```

---

## 🎯 Pasos Recomendados

### Opción 1: Subir Archivos Individuales (Recomendado)

1. **Archivos nuevos:**
   - Subir `ProjectCostsController.php` a `app/Http/Controllers/Admin/`
   - Crear carpeta `project-costs/` en `resources/views/admin/`
   - Subir `index.blade.php` a esa carpeta

2. **Archivos modificados:**
   - Reemplazar los 6 archivos modificados uno por uno

3. **Assets:**
   - Eliminar `public/build/` antigua
   - Subir `public/build/` nueva completa

### Opción 2: Subir Carpetas Completas (Más rápido)

Si prefieres subir carpetas completas:

1. **Subir carpeta completa:**
   - `app/Http/Controllers/Admin/` (sobrescribe, pero mantiene otros archivos)
   - `app/Models/` (solo sube ShippingRate.php)
   - `app/Helpers/` (solo sube CotizadorHelper.php)
   - `resources/views/admin/project-costs/` (carpeta nueva completa)
   - `resources/views/` (solo los 2 archivos modificados)
   - `routes/` (solo web.php)
   - `public/build/` (carpeta completa)

---

## ✅ Verificación Post-Subida

Después de subir, verificar en SSH:

```bash
cd public_html

# Verificar archivos nuevos
ls -la app/Http/Controllers/Admin/ProjectCostsController.php
ls -la resources/views/admin/project-costs/index.blade.php

# Verificar assets
ls -la public/build/assets/

# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## 📊 Resumen Ejecutivo

**Total a subir:**
- **8 archivos individuales** (nuevos y modificados)
- **1 carpeta completa** (`public/build/`)

**NO subir:**
- `vendor/`
- `node_modules/`
- `.git/`
- `.env`
- `storage/logs/`

---

*Última actualización: 7 de Diciembre 2025*


