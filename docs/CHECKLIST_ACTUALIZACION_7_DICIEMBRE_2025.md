# ✅ Checklist de Actualización - 7 de Diciembre 2025

## 📦 PREPARACIÓN LOCAL

- [ ] Assets compilados (`npm run build` ejecutado)
- [ ] `public/build/` contiene archivos compilados actualizados
- [ ] Verificar que no hay errores locales
- [ ] Probar funcionalidades nuevas localmente:
  - [ ] Presentación de costos del proyecto
  - [ ] Validación dinámica de tarifas de envío

---

## 📤 ARCHIVOS A SUBIR

### 🆕 Archivos NUEVOS

#### Controladores
- [ ] `app/Http/Controllers/Admin/ProjectCostsController.php`

#### Vistas
- [ ] `resources/views/admin/project-costs/index.blade.php`

#### Documentación
- [ ] `docs/ESTIMACION_COSTOS_PROYECTO.md`

### 📝 Archivos MODIFICADOS

#### Modelos
- [ ] `app/Models/ShippingRate.php` (nuevos métodos para rangos de peso)

#### Helpers
- [ ] `app/Helpers/CotizadorHelper.php` (validación dinámica basada en tarifas activas)

#### Controladores
- [ ] `app/Http/Controllers/CotizadorController.php` (validación dinámica y rangos de peso)

#### Vistas
- [ ] `resources/views/cotizador.blade.php` (validación dinámica en JavaScript)
- [ ] `resources/views/dashboard.blade.php` (botón de costos agregado)

#### Rutas
- [ ] `routes/web.php` (ruta project-costs agregada)

#### Assets (después de compilar)
- [ ] `public/build/assets/*` (archivos CSS y JS compilados)

---

## 🗄️ BASE DE DATOS

**No se requieren nuevas migraciones** - Los cambios son solo en lógica de aplicación.

---

## ⚙️ CONFIGURACIÓN

No se requieren cambios en `.env` o archivos de configuración.

---

## 🚀 PASOS DE DESPLIEGUE

### 1. Preparación Local

```bash
# Compilar assets
npm run build

# Verificar que no hay errores
php artisan route:list
php artisan config:clear
php artisan cache:clear
```

### 2. Subir Archivos a Hostinger

Usar FTP/SFTP o el panel de Hostinger para subir los archivos listados arriba.

**Estructura de carpetas:**
```
/
├── app/
│   ├── Http/Controllers/Admin/
│   │   └── ProjectCostsController.php (NUEVO)
│   ├── Models/
│   │   └── ShippingRate.php (MODIFICADO)
│   └── Helpers/
│       └── CotizadorHelper.php (MODIFICADO)
├── resources/
│   └── views/
│       ├── admin/
│       │   └── project-costs/
│       │       └── index.blade.php (NUEVO)
│       ├── cotizador.blade.php (MODIFICADO)
│       └── dashboard.blade.php (MODIFICADO)
├── routes/
│   └── web.php (MODIFICADO)
└── public/
    └── build/ (COMPILAR Y SUBIR)
```

### 3. Comandos SSH en Hostinger

```bash
# Conectar por SSH
ssh usuario@hostinger.com

# Ir al directorio del proyecto
cd public_html

# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimizar (opcional pero recomendado)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Verificación Post-Despliegue

- [ ] Acceder al dashboard y verificar que aparece el botón "Costos"
- [ ] Probar la presentación de costos del proyecto
- [ ] Probar el cotizador con diferentes métodos de envío
- [ ] Desactivar una tarifa de envío y verificar que la validación cambia
- [ ] Verificar que los mensajes de error muestran rangos correctos

---

## 🐛 SOLUCIÓN DE PROBLEMAS

### Error: "Class ProjectCostsController not found"
```bash
php artisan config:clear
composer dump-autoload
```

### Error: "Route [admin.project-costs.index] not defined"
- Verificar que `routes/web.php` contiene la ruta
- Ejecutar: `php artisan route:clear && php artisan route:cache`

### Assets no se cargan
- Verificar que `public/build/` contiene los archivos compilados
- Ejecutar: `npm run build` localmente y subir la carpeta `public/build/`

### Validación no funciona correctamente
- Verificar que las tarifas de envío tienen `is_active = true` en la base de datos
- Limpiar caché: `php artisan cache:clear`

---

## 📋 RESUMEN DE CAMBIOS

### 1. Presentación de Costos del Proyecto
- Nueva sección en el dashboard para mostrar estimación de costos
- Presentación interactiva con 11 secciones
- Accesible desde el botón "Costos" en el dashboard

### 2. Validación Dinámica de Tarifas de Envío
- Validación basada en tarifas activas (no valores hardcodeados)
- Mensajes de error dinámicos según rangos de peso disponibles
- Funciona tanto en frontend como backend
- Los métodos de envío se muestran/ocultan según tarifas activas

---

## ✅ CHECKLIST FINAL

- [ ] Todos los archivos subidos
- [ ] Assets compilados y subidos
- [ ] Caché limpiado en servidor
- [ ] Funcionalidades probadas
- [ ] Sin errores en logs

---

*Última actualización: 7 de Diciembre 2025*




