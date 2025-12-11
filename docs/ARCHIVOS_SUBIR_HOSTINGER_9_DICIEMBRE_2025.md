# 📤 Archivos a Subir a Hostinger - 9 de Diciembre 2025

## 📋 Lista de Archivos

### 📝 Archivos Modificados

#### Vistas
```
resources/views/admin/project-costs/index.blade.php
resources/views/home.blade.php
```

#### Seeders
```
database/seeders/StoreSeeder.php
```

---

## 📦 Estructura de Carpetas

### En Hostinger, subir a:

```
public_html/
├── resources/
│   └── views/
│       ├── admin/
│       │   └── project-costs/
│       │       └── index.blade.php          ← MODIFICADO
│       └── home.blade.php                  ← MODIFICADO
└── database/
    └── seeders/
        └── StoreSeeder.php                 ← MODIFICADO
```

---

## ⚠️ Importante

### Assets Compilados
Si modificaste archivos CSS/JS en `resources/css/` o `resources/js/`, debes:

1. **Compilar localmente:**
   ```bash
   npm run build
   ```

2. **Subir la carpeta completa:**
   ```
   public/build/
   ```

### Si NO modificaste CSS/JS
No es necesario subir `public/build/` si solo cambiaste vistas Blade.

---

## 🔍 Verificación Pre-Subida

Antes de subir, verifica:

- [ ] Los archivos se guardaron correctamente
- [ ] No hay errores de sintaxis
- [ ] Los cambios funcionan en localhost
- [ ] Assets compilados (si aplica)

---

## 📤 Método de Subida

### Opción 1: FTP/SFTP (FileZilla, WinSCP, etc.)
1. Conectarse al servidor
2. Navegar a `public_html/`
3. Subir los archivos manteniendo la estructura de carpetas

### Opción 2: SSH + SCP
```bash
# Desde tu máquina local
scp resources/views/admin/project-costs/index.blade.php u671466050@us-bos-web1847.ssh.hostinger.com:~/domains/leranuva.com/public_html/resources/views/admin/project-costs/

scp resources/views/home.blade.php u671466050@us-bos-web1847.ssh.hostinger.com:~/domains/leranuva.com/public_html/resources/views/

scp database/seeders/StoreSeeder.php u671466050@us-bos-web1847.ssh.hostinger.com:~/domains/leranuva.com/public_html/database/seeders/
```

---

## ✅ Checklist de Subida

- [ ] `resources/views/admin/project-costs/index.blade.php` subido
- [ ] `resources/views/home.blade.php` subido
- [ ] `database/seeders/StoreSeeder.php` subido
- [ ] `public/build/` subido (si se compilaron assets)
- [ ] Estructura de carpetas preservada
- [ ] Permisos correctos (644 para archivos, 755 para carpetas)

---

## 🔄 Después de Subir

1. **Limpiar caché** (ver `COMANDOS_SSH_HOSTINGER_9_DICIEMBRE_2025.md`)
2. **Verificar funcionamiento**
3. **Probar en diferentes dispositivos**

---

## 📝 Notas

- Los logos de tiendas NO se suben, se agregan desde el panel de administración
- El seeder está limpio para no sobrescribir logos existentes
- Los estilos CSS están embebidos en las vistas, no requieren archivos adicionales

