# 📤 Archivos y Carpetas para Subir a Hostinger

## ✅ CARPETAS Y ARCHIVOS A SUBIR

### Carpetas principales (SÍ subir):
```
✅ app/                    - Código de la aplicación
✅ bootstrap/              - Archivos de arranque
✅ config/                 - Configuraciones
✅ database/               - Migraciones y seeders
✅ public/                 - Archivos públicos (IMPORTANTE)
✅ resources/             - Vistas y assets fuente
✅ routes/                 - Rutas de la aplicación
✅ storage/                - Almacenamiento (SIN los logs)
✅ vendor/                 - Dependencias de Composer
```

### Archivos en la raíz (SÍ subir):
```
✅ artisan                 - CLI de Laravel
✅ composer.json           - Dependencias PHP
✅ composer.lock           - Versiones exactas
✅ package.json            - Dependencias Node
✅ package-lock.json       - Versiones exactas Node
✅ tailwind.config.js      - Configuración Tailwind
✅ vite.config.js          - Configuración Vite
✅ postcss.config.js       - Configuración PostCSS
✅ phpunit.xml             - Configuración tests (opcional)
✅ .htaccess               - Si está en la raíz
```

### Archivos de documentación (opcional):
```
📄 README.md
📄 DEPLOY_HOSTINGER.md
📄 QUICK_DEPLOY.md
📄 HOSTINGER_SPECIFIC.md
📄 CHECKLIST_DEPLOY.md
```

## ❌ CARPETAS Y ARCHIVOS QUE NO SUBIR

### Carpetas (NO subir):
```
❌ node_modules/           - Muy pesado, se instala en servidor si es necesario
❌ .git/                   - Control de versiones (no necesario en producción)
❌ tests/                  - Tests (opcional, no necesario)
❌ docs/                   - Documentación (opcional)
```

### Archivos (NO subir):
```
❌ .env                    - Crear uno nuevo en el servidor
❌ .env.backup             - Backup local
❌ .env.production         - Si existe
❌ *.log                   - Cualquier archivo .log
❌ .gitignore              - No necesario en producción
❌ .gitattributes          - No necesario en producción
❌ favicon.ico.backup      - Archivos de backup
❌ *.backup                - Cualquier archivo de backup
```

### Dentro de storage/ (NO subir):
```
❌ storage/logs/*.log      - Los logs NO se suben
❌ storage/framework/cache/data/*  - Cache local (se regenera)
❌ storage/framework/sessions/*    - Sesiones locales (se regenera)
❌ storage/framework/views/*       - Vistas compiladas (se regeneran)
```

## 📋 RESUMEN VISUAL

### Estructura a subir:
```
public_html/
├── app/                    ✅ SUBIR
├── bootstrap/              ✅ SUBIR
├── config/                 ✅ SUBIR
├── database/               ✅ SUBIR
├── public/                 ✅ SUBIR (MUY IMPORTANTE)
│   ├── index.php
│   ├── .htaccess
│   ├── favicon.ico
│   ├── favicon.svg
│   └── build/              ✅ SUBIR (assets compilados)
├── resources/              ✅ SUBIR
├── routes/                 ✅ SUBIR
├── storage/                ✅ SUBIR (SIN logs)
│   ├── app/
│   │   └── public/        ✅ SUBIR (carpeta vacía está bien)
│   └── framework/
│       ├── cache/
│       ├── sessions/
│       └── views/
│   └── logs/               ⚠️ Crear carpeta vacía (permisos 755)
├── vendor/                 ✅ SUBIR
├── artisan                 ✅ SUBIR
├── composer.json           ✅ SUBIR
├── composer.lock           ✅ SUBIR
├── package.json            ✅ SUBIR
├── package-lock.json       ✅ SUBIR
├── tailwind.config.js      ✅ SUBIR
├── vite.config.js          ✅ SUBIR
├── postcss.config.js       ✅ SUBIR
└── .env.example            ✅ SUBIR (para referencia)
```

## 🎯 PASOS ESPECÍFICOS

### 1. Preparar antes de subir:

```bash
# Asegúrate de que los assets están compilados
npm run build

# Limpia logs locales (opcional)
# No subir storage/logs/*.log
```

### 2. Carpetas a crear en el servidor (si no existen):

```
storage/logs/              - Crear vacía con permisos 755
storage/framework/cache/   - Crear con permisos 755
storage/framework/sessions/ - Crear con permisos 755
storage/framework/views/    - Crear con permisos 755
bootstrap/cache/           - Crear con permisos 755
```

### 3. Archivos a crear en el servidor:

```
.env                       - Crear basado en .env.example
```

## ⚠️ IMPORTANTE

1. **public/build/** - DEBE estar incluido (assets compilados)
2. **storage/** - Subir la estructura pero SIN los archivos de cache/logs
3. **vendor/** - DEBE estar incluido (dependencias PHP)
4. **.env** - NO subir, crear uno nuevo en el servidor

## 📊 TAMAÑO APROXIMADO

- **Con vendor/**: ~50-100 MB
- **Sin vendor/**: ~5-10 MB (pero necesitarás ejecutar `composer install` en el servidor)

**Recomendación:** Sube `vendor/` si tienes buen ancho de banda, o instálalo en el servidor con `composer install --no-dev`

## ✅ CHECKLIST RÁPIDO

Antes de subir, verifica:

- [ ] `public/build/` existe y tiene archivos
- [ ] No hay archivos `.log` en `storage/logs/`
- [ ] No hay archivos `.env` en la lista
- [ ] No incluyes `node_modules/`
- [ ] No incluyes `.git/`
- [ ] `vendor/` está incluido (o planeas instalarlo en servidor)

