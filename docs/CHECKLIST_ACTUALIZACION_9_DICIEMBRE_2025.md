# ✅ Checklist de Actualización - 9 de Diciembre 2025

## 📦 PREPARACIÓN LOCAL

- [ ] Assets compilados (`npm run build` ejecutado)
- [ ] `public/build/` contiene archivos compilados actualizados
- [ ] Verificar que no hay errores locales
- [ ] Probar funcionalidades actualizadas localmente:
  - [ ] Sección de costos responsive en pantallas pequeñas
  - [ ] Logos de tiendas con colores originales preservados

---

## 📤 ARCHIVOS A SUBIR

### 📝 Archivos MODIFICADOS

#### Vistas
- [ ] `resources/views/admin/project-costs/index.blade.php` (estilos responsive mejorados)
- [ ] `resources/views/home.blade.php` (estilos CSS para logos de tiendas)

#### Seeders
- [ ] `database/seeders/StoreSeeder.php` (limpiado para preservar logos existentes)

#### Assets (después de compilar)
- [ ] `public/build/assets/*` (archivos CSS y JS compilados)

---

## 🗄️ BASE DE DATOS

- [ ] **NO se requieren migraciones nuevas**
- [ ] **NO se requieren seeders nuevos** (el seeder está limpio, los logos se agregan desde el panel admin)

---

## 🚀 DESPLIEGUE EN HOSTINGER

### 1. Subir Archivos
- [ ] Subir todos los archivos modificados vía FTP/SFTP
- [ ] Asegurarse de mantener permisos correctos

### 2. Compilar Assets en Servidor
```bash
cd public_html
npm install
npm run build
```

### 3. Limpiar Caché
```bash
php artisan config:clear
php artisan config:cache
php artisan view:clear
php artisan view:cache
php artisan route:clear
php artisan route:cache
```

### 4. Verificar
- [ ] Probar sección de costos en móvil/tablet
- [ ] Verificar que los logos de tiendas se muestran correctamente
- [ ] Verificar que los colores de los logos se preservan

---

## ✅ VERIFICACIÓN POST-DESPLIEGUE

- [ ] La sección de costos es responsive en pantallas pequeñas
- [ ] Las tablas en la sección de costos tienen scroll horizontal en móviles
- [ ] Los botones se adaptan correctamente en móviles
- [ ] Los logos de tiendas mantienen sus colores originales
- [ ] Los logos se ajustan correctamente al contenedor
- [ ] El efecto hover funciona correctamente

---

## 📝 NOTAS IMPORTANTES

1. **Logos de Tiendas**: Los logos deben agregarse desde el panel de administración. Los SVG de worldvectorlogo.com se preservarán con sus colores originales gracias a los estilos CSS actualizados.

2. **Responsive Design**: La sección de costos ahora incluye:
   - Tablas con scroll horizontal en móviles
   - Textos adaptativos según tamaño de pantalla
   - Botones apilados en móviles
   - Panel de navegación con scroll vertical cuando es necesario

3. **Estilos CSS**: Los estilos para logos NO interfieren con los colores originales de los SVG, solo controlan tamaño y posicionamiento.

---

## 🔄 ROLLBACK (si es necesario)

Si algo falla, restaurar:
- `resources/views/admin/project-costs/index.blade.php`
- `resources/views/home.blade.php`
- `database/seeders/StoreSeeder.php`



