# 📍 Dónde Crear el Archivo .env en Hostinger

## 🎯 RESPUESTA RÁPIDA

El archivo `.env` se crea en la **RAÍZ del proyecto Laravel**, al mismo nivel que:
- `artisan`
- `composer.json`
- `app/`
- `config/`
- `vendor/`
- `public/`

**NO** va dentro de `public/` ni de `public_html/` directamente.

## 📁 Estructura Correcta en Hostinger

### Opción 1: Document Root apunta a `public_html/public` (Recomendado)

```
public_html/                    ← Raíz del proyecto Laravel
├── .env                        ← ✅ AQUÍ se crea el .env
├── artisan
├── app/
├── bootstrap/
├── config/
├── database/
├── public/                     ← Document Root apunta aquí
│   ├── index.php
│   ├── .htaccess
│   └── build/
├── resources/
├── routes/
├── storage/
├── vendor/
├── composer.json
└── composer.lock
```

**Ubicación del .env:** `public_html/.env`

---

### Opción 2: Document Root apunta a `public_html` (Requiere redirección)

Si no puedes cambiar el Document Root, necesitas crear un `index.php` en la raíz:

```
public_html/                    ← Document Root aquí
├── .env                        ← ✅ AQUÍ se crea el .env
├── index.php                   ← Redirige a public/index.php
├── .htaccess                   ← Redirige a public/
├── artisan
├── app/
├── bootstrap/
├── config/
├── database/
├── public/                     ← Carpeta pública real
│   ├── index.php
│   ├── .htaccess
│   └── build/
├── resources/
├── routes/
├── storage/
├── vendor/
├── composer.json
└── composer.lock
```

**Ubicación del .env:** `public_html/.env`

---

## ✅ PASOS PARA CREAR EL .env

### Método 1: Desde File Manager de Hostinger

1. Accede al **File Manager** en el panel de Hostinger
2. Navega a `public_html/` (o donde esté tu proyecto)
3. Busca el archivo `.env.example`
4. Haz clic derecho → **Renombrar** o **Copiar**
5. Renombra a `.env`
6. Edita el archivo `.env` y configura tus valores

### Método 2: Desde SSH

```bash
# Navegar al directorio del proyecto
cd ~/domains/tudominio.com/public_html

# Copiar .env.example a .env
cp .env.example .env

# Editar el archivo (usa nano, vi, o tu editor preferido)
nano .env
```

### Método 3: Crear manualmente

1. En File Manager, crea un nuevo archivo llamado `.env`
2. Copia el contenido de `.env.example`
3. Edita los valores necesarios

## 🔍 CÓMO VERIFICAR QUE ESTÁ EN EL LUGAR CORRECTO

El archivo `.env` debe estar al mismo nivel que estos archivos:

```
✅ Debe estar junto a:
   - artisan
   - composer.json
   - app/ (carpeta)
   - config/ (carpeta)
   - public/ (carpeta)
   - vendor/ (carpeta)

❌ NO debe estar:
   - Dentro de public/
   - Dentro de app/
   - Dentro de config/
   - En public_html/ si public_html ES el Document Root
```

## 📝 EJEMPLO DE UBICACIÓN CORRECTA

Si tu estructura es:

```
public_html/
├── .env              ← ✅ CORRECTO
├── artisan
├── app/
├── config/
└── public/
    └── index.php
```

Entonces el `.env` está en el lugar correcto.

## ⚠️ ERRORES COMUNES

### ❌ Error: Poner .env en public/

```
public_html/
└── public/
    ├── .env          ← ❌ INCORRECTO (nunca aquí)
    └── index.php
```

**Problema:** El `.env` en `public/` sería accesible públicamente (riesgo de seguridad).

### ❌ Error: Poner .env en public_html/ cuando public_html ES el Document Root

Si `public_html/` es el Document Root y no tienes redirección:

```
public_html/          ← Document Root
├── .env              ← ⚠️ Puede ser accesible públicamente
└── index.php
```

**Solución:** Usa la Opción 2 con redirección, o cambia el Document Root a `public_html/public`.

## 🔒 SEGURIDAD

Después de crear el `.env`, configura los permisos:

```bash
chmod 600 .env
```

Esto asegura que solo el propietario puede leer/escribir el archivo.

## ✅ VERIFICACIÓN FINAL

Para verificar que Laravel encuentra el `.env`:

```bash
php artisan config:show app.name
```

Si muestra el nombre de tu aplicación, el `.env` está en el lugar correcto.

