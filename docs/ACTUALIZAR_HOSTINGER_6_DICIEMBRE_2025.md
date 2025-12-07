# 🚀 Actualización Hostinger - 6 de Diciembre 2025

## 📋 Resumen de Cambios

Esta actualización incluye:
1. ✅ **Corrección de Colores del Tema** - Ajuste en layouts y CSS para que los colores se apliquen correctamente
2. ✅ **Gestión del Cotizador** - Sistema completo de configuración del cotizador
3. ✅ **Campos de Color en Cotizador** - Personalización de colores para títulos y labels (7 campos)
4. ✅ **Nuevo Tema "Dance Studio"** - Tema adicional con colores vibrantes
5. ✅ **Guía Interactiva del Dashboard** - Sistema de ayuda paso a paso con 20 pasos
6. ✅ **Correcciones en Componentes** - Mejoras en form-group para labels personalizados

---

## 📦 ANTES DE SUBIR

### ✅ Verificaciones Locales

- [x] Assets compilados (`npm run build` ejecutado)
- [x] `public/build/` contiene archivos compilados actualizados
- [x] Verificar que no hay errores locales
- [x] Probar todas las funcionalidades nuevas

---

## 📤 ARCHIVOS A SUBIR

### 🆕 Archivos NUEVOS

#### Modelos y Controladores
- [ ] `app/Models/CotizadorSection.php` - **NUEVO**
- [ ] `app/Http/Controllers/Admin/CotizadorSectionController.php` - **NUEVO**
- [ ] `app/Http/Controllers/Admin/DashboardGuideController.php` - **NUEVO**

#### Migraciones
- [ ] `database/migrations/2025_12_06_210609_create_cotizador_sections_table.php` - **NUEVA**
- [ ] `database/migrations/2025_12_06_211102_add_color_fields_to_cotizador_sections_table.php` - **NUEVA**

#### Seeders
- [ ] `database/seeders/CotizadorSectionSeeder.php` - **NUEVO**

#### Vistas
- [ ] `resources/views/admin/cotizador-sections/edit.blade.php` - **NUEVA**
- [ ] `resources/views/admin/dashboard-guide/index.blade.php` - **NUEVA**

### 📝 Archivos MODIFICADOS

#### Layouts (Corrección de Colores del Tema)
- [ ] `resources/views/layouts/app.blade.php` - Modificado (bloque style antes de @vite)
- [ ] `resources/views/layouts/guest.blade.php` - Modificado (bloque style antes de @vite)

#### Controladores
- [ ] `app/Http/Controllers/CotizadorController.php` - Modificado (agrega $cotizadorSection)
- [ ] `app/Http/Controllers/Admin/ThemeController.php` - Modificado (validación de colores)

#### Vistas
- [ ] `resources/views/cotizador.blade.php` - Modificado (usa colores dinámicos)
- [ ] `resources/views/dashboard.blade.php` - Modificado (botón de guía)
- [ ] `resources/views/components/ui/form-group.blade.php` - Modificado (soporte para labelSlot)

#### Seeders
- [ ] `database/seeders/ThemeSeeder.php` - Modificado (nuevo tema Dance Studio)

#### Rutas
- [ ] `routes/web.php` - Modificado (rutas de cotizador-sections y dashboard-guide)

#### CSS
- [ ] `resources/css/app.css` - Modificado (reglas @layer utilities para colores del tema)
- [ ] `public/build/assets/app-*.css` - **CRÍTICO** - Assets compilados actualizados

---

## 🔄 PASOS EN EL SERVIDOR (SSH)

Después de subir los archivos, conecta por SSH y ejecuta:

```bash
# 1. Ir al directorio del proyecto
cd ~/public_html  # o la ruta donde está tu proyecto

# 2. Ejecutar nuevas migraciones
php artisan migrate --force

# 3. Ejecutar nuevos seeders
php artisan db:seed --class=CotizadorSectionSeeder
php artisan db:seed --class=ThemeSeeder

# 4. Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# 5. Reoptimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 6. Verificar permisos
chmod -R 755 storage bootstrap/cache
chmod 600 .env

# 7. Verificar storage link
php artisan storage:link
```

> 📋 **Nota**: Para una versión más detallada con explicaciones, consulta [COMANDOS_SSH_HOSTINGER_6_DICIEMBRE_2025.md](COMANDOS_SSH_HOSTINGER_6_DICIEMBRE_2025.md)

---

## 📋 Checklist de Archivos por Carpeta

### `app/`
- [ ] `app/Models/CotizadorSection.php` - **NUEVO**
- [ ] `app/Http/Controllers/Admin/CotizadorSectionController.php` - **NUEVO**
- [ ] `app/Http/Controllers/Admin/DashboardGuideController.php` - **NUEVO**
- [ ] `app/Http/Controllers/CotizadorController.php` - **MODIFICADO**
- [ ] `app/Http/Controllers/Admin/ThemeController.php` - **MODIFICADO**

### `database/`
- [ ] `database/migrations/2025_12_06_210609_create_cotizador_sections_table.php` - **NUEVA**
- [ ] `database/migrations/2025_12_06_211102_add_color_fields_to_cotizador_sections_table.php` - **NUEVA**
- [ ] `database/seeders/CotizadorSectionSeeder.php` - **NUEVO**
- [ ] `database/seeders/ThemeSeeder.php` - **MODIFICADO**

### `resources/views/`
- [ ] `resources/views/admin/cotizador-sections/edit.blade.php` - **NUEVA**
- [ ] `resources/views/admin/dashboard-guide/index.blade.php` - **NUEVA**
- [ ] `resources/views/cotizador.blade.php` - **MODIFICADO**
- [ ] `resources/views/dashboard.blade.php` - **MODIFICADO**
- [ ] `resources/views/components/ui/form-group.blade.php` - **MODIFICADO**

### `routes/`
- [ ] `routes/web.php` - **MODIFICADO**

### `resources/css/`
- [ ] `resources/css/app.css` - **MODIFICADO**

### `public/build/` ⚠️ **CRÍTICO**
- [ ] `public/build/manifest.json` - **ACTUALIZADO**
- [ ] `public/build/assets/app-*.css` - **ACTUALIZADO**
- [ ] `public/build/assets/app-*.js` - **ACTUALIZADO**

---

## ❌ NO SUBIR

- [ ] `.env` - NO tocar (ya existe en servidor)
- [ ] `node_modules/` - NO subir
- [ ] `.git/` - NO subir
- [ ] `storage/logs/*.log` - NO subir logs
- [ ] `storage/framework/cache/data/*` - NO subir cache
- [ ] `storage/framework/sessions/*` - NO subir sesiones
- [ ] `storage/framework/views/*` - NO subir vistas compiladas
- [ ] `bootstrap/cache/*.php` - NO subir (excepto estructura)

---

## ✅ VERIFICACIÓN POST-ACTUALIZACIÓN

Después de actualizar, verifica que funcionen:

1. ✅ **Dashboard**
   - [ ] `https://tudominio.com/dashboard` - Debe cargar correctamente
   - [ ] Botón "Guía" visible y funcional
   - [ ] Enlace "Cotizador" en sección de administración

2. ✅ **Guía Interactiva**
   - [ ] `https://tudominio.com/admin/dashboard-guide` - Debe cargar
   - [ ] Tour interactivo funciona
   - [ ] Navegación entre pasos funciona

3. ✅ **Gestión del Cotizador**
   - [ ] `https://tudominio.com/admin/cotizador-sections` - Debe cargar
   - [ ] Formulario de edición funciona
   - [ ] Colores se guardan correctamente

4. ✅ **Cotizador**
   - [ ] `https://tudominio.com/cotizador` - Debe cargar
   - [ ] Títulos y labels usan colores configurados
   - [ ] Funcionalidad del cotizador intacta

5. ✅ **Gestión de Temas**
   - [ ] `https://tudominio.com/admin/themes` - Debe mostrar 4 temas
   - [ ] Tema "Dance Studio" visible
   - [ ] Activación de temas funciona

6. ✅ **Página Principal**
   - [ ] `https://tudominio.com/` - Debe cargar correctamente
   - [ ] Tema activo se aplica correctamente
   - [ ] Sin errores en consola

---

## 🔧 Solución de Problemas

### Si el cotizador no muestra colores:
```bash
php artisan view:clear
php artisan cache:clear
```

### Si la guía no carga:
```bash
php artisan route:clear
php artisan route:cache
```

### Si los temas no aparecen:
```bash
php artisan db:seed --class=ThemeSeeder
php artisan cache:clear
```

### Si hay errores de migración:
```bash
php artisan migrate:status
php artisan migrate --force
```

---

## 📝 Notas Importantes

1. **Assets Compilados**: Es CRÍTICO subir la carpeta `public/build/` completa con los archivos actualizados. Sin esto, los estilos y scripts no funcionarán.

2. **Base de Datos**: Las migraciones crearán la tabla `cotizador_sections` y agregarán los campos de color. Asegúrate de tener un backup antes de ejecutar.

3. **Seeders**: El seeder de `CotizadorSectionSeeder` creará la configuración inicial del cotizador. El `ThemeSeeder` actualizado agregará el nuevo tema "Dance Studio".

4. **Permisos**: Después de subir, verifica que los permisos de `storage/` y `bootstrap/cache/` sean correctos (755).

---

## 🎯 Resumen Rápido

**Archivos Críticos a Subir:**
1. `app/Models/CotizadorSection.php`
2. `app/Http/Controllers/Admin/CotizadorSectionController.php`
3. `app/Http/Controllers/Admin/DashboardGuideController.php`
4. `database/migrations/2025_12_06_*.php` (2 archivos)
5. `database/seeders/CotizadorSectionSeeder.php`
6. `resources/views/admin/cotizador-sections/` (carpeta completa)
7. `resources/views/admin/dashboard-guide/` (carpeta completa)
8. `public/build/` (carpeta completa - **MUY IMPORTANTE**)

**Comandos SSH Esenciales:**
```bash
php artisan migrate --force
php artisan db:seed --class=CotizadorSectionSeeder
php artisan db:seed --class=ThemeSeeder
php artisan cache:clear && php artisan config:clear && php artisan view:clear
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

---

✅ **¡Listo para actualizar!** Sigue este documento paso a paso y todo debería funcionar correctamente.

