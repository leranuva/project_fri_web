# Compilar Estilos y JavaScript para Producción

## 🔴 Problema

Los estilos CSS y JavaScript no están compilados, por lo que el sitio no muestra los estilos correctamente.

## ✅ Solución: Compilar Assets

### Paso 1: Verificar Node.js y npm

```bash
# Verificar versión de Node.js
node --version

# Verificar versión de npm
npm --version

# Si no están instalados, necesitas instalarlos o compilar localmente
```

### Paso 2: Instalar Dependencias (si es necesario)

```bash
# Instalar dependencias de npm
npm install

# Esto instalará todas las dependencias necesarias (Vite, Tailwind, Alpine.js, etc.)
```

### Paso 3: Compilar Assets para Producción

```bash
# Compilar CSS y JavaScript para producción
npm run build

# Esto generará los archivos en public/build/
```

### Paso 4: Verificar Archivos Compilados

```bash
# Verificar que se crearon los archivos
ls -la public/build/

# Debe mostrar:
# - assets/app-*.js
# - assets/app-*.css
# - manifest.json
```

## 🔧 Comandos Completos (Copia y Pega)

```bash
# 1. Verificar Node.js y npm
node --version
npm --version

# 2. Instalar dependencias (si no están instaladas)
npm install

# 3. Compilar assets para producción
npm run build

# 4. Verificar que se compilaron
ls -la public/build/
ls -la public/build/assets/

# 5. Verificar permisos
chmod -R 755 public/build
```

## ⚠️ Si Node.js No Está Disponible en el Servidor

Si el servidor de Hostinger no tiene Node.js instalado, tienes dos opciones:

### Opción 1: Compilar Localmente y Subir

1. **En tu máquina local:**
   ```bash
   # Compilar assets
   npm run build
   
   # Verificar que se crearon
   ls -la public/build/
   ```

2. **Subir la carpeta `public/build/` al servidor:**
   - Usa FTP/SFTP o File Manager
   - Sube toda la carpeta `public/build/` a `public_html/public/build/`

### Opción 2: Usar Node.js en el Servidor (si está disponible)

Algunos servidores de Hostinger tienen Node.js disponible. Verifica:

```bash
# Verificar si Node.js está disponible
which node
which npm

# Si están disponibles, ejecuta:
npm install
npm run build
```

## 📋 Verificación Final

Después de compilar:

```bash
# 1. Verificar estructura
ls -la public/build/
ls -la public/build/assets/

# 2. Verificar que los archivos tienen contenido
head -5 public/build/manifest.json

# 3. Verificar permisos
ls -la public/build/assets/
```

## 🆘 Si `npm run build` Falla

### Error: "Cannot find module"

```bash
# Reinstalar dependencias
rm -rf node_modules
rm -rf package-lock.json
npm install
npm run build
```

### Error: "Permission denied"

```bash
# Dar permisos a npm
chmod -R 755 node_modules
chmod -R 755 public/build
```

### Error: "Command not found: npm"

Node.js no está instalado. Usa la **Opción 1** (compilar localmente).

## 📝 Notas Importantes

1. **Los archivos compilados están en `public/build/`** - Esta carpeta DEBE estar en el servidor.

2. **No subas `node_modules/`** - Solo sube `public/build/` después de compilar.

3. **Después de compilar**, recarga la página con `Ctrl+F5` para limpiar la caché del navegador.

4. **Si cambias estilos**, debes recompilar con `npm run build`.


