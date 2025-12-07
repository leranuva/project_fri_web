# 🚀 Flat Rate Imports - Sistema de Cotización de Importaciones

Sistema web completo para la gestión y cotización de importaciones desde Estados Unidos a Ecuador, desarrollado con Laravel 12, Tailwind CSS y Alpine.js.

**Desarrollado por:** Lenin Nunez  
**Período de desarrollo:** Enero 2023 - Diciembre 2024  
**Ritmo de trabajo:** 2-3 horas por noche (desarrollo part-time)

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.1-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3.4-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)

---

## 📋 Tabla de Contenidos

- [Características Principales](#-características-principales)
- [Requisitos del Sistema](#-requisitos-del-sistema)
- [Instalación](#-instalación)
- [Configuración Inicial](#-configuración-inicial)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Funcionalidades Implementadas](#-funcionalidades-implementadas)
- [Tecnologías y Dependencias](#-tecnologías-y-dependencias)
- [Comandos Útiles](#-comandos-útiles)
- [Despliegue](#-despliegue)
- [Documentación Adicional](#-documentación-adicional)

---

## ✨ Características Principales

- 🎨 **Diseño Glassmorphism** - Interfaz moderna con efectos de vidrio esmerilado
- 📱 **Mobile-First** - Diseño responsive optimizado para dispositivos móviles
- 🧮 **Cotizador Inteligente** - Sistema de cotización con cálculos automáticos de impuestos y tarifas
- 👥 **Gestión de Usuarios** - Sistema de autenticación con roles (admin/cliente)
- 🎛️ **Panel de Administración** - Gestión completa de contenido y configuración
- 🎨 **Sistema de Temas** - Personalización de colores y diseño del sitio
- 📊 **Dashboard Interactivo** - Panel de control con estadísticas y guía integrada
- 🚚 **Múltiples Métodos de Envío** - Marítimo, Aéreo, Aéreo Express, Courier 4x4
- 📦 **Tracking de Paquetes** - Sistema de seguimiento de envíos
- 📝 **Gestión de Contenido** - Slider, blog, footer, tiendas, beneficios completamente gestionables

---

## 💻 Requisitos del Sistema

### Servidor Local (Desarrollo)
- **PHP:** >= 8.2
- **Composer:** >= 2.0
- **Node.js:** >= 18.x
- **npm:** >= 9.x
- **MySQL:** >= 8.0 (o MariaDB >= 10.3)
- **XAMPP** (recomendado para Windows) o **Laravel Valet/Homestead**

### Servidor de Producción
- **PHP:** >= 8.2 con extensiones: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- **MySQL:** >= 8.0
- **Apache/Nginx** con mod_rewrite habilitado
- **SSL Certificate** (recomendado)

---

## 🚀 Instalación

### Paso 1: Clonar o Descargar el Proyecto

```bash
# Si tienes Git
git clone https://github.com/tu-usuario/web_fri_pro.git
cd web_fri_pro

# O descarga el ZIP y extrae en tu carpeta de proyectos
```

### Paso 2: Instalar Dependencias PHP

```bash
# Instalar dependencias de Composer
composer install
```

### Paso 3: Instalar Dependencias Node.js

```bash
# Instalar dependencias de npm
npm install
```

### Paso 4: Configurar el Archivo .env

```bash
# Copiar el archivo de ejemplo
cp .env.example .env

# Generar la clave de aplicación
php artisan key:generate
```

### Paso 5: Configurar Base de Datos

Edita el archivo `.env` y configura tu base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_fri_pro
DB_USERNAME=root
DB_PASSWORD=
```

### Paso 6: Ejecutar Migraciones y Seeders

```bash
# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders (datos iniciales)
php artisan db:seed
```

### Paso 7: Compilar Assets

```bash
# Compilar CSS y JavaScript para desarrollo
npm run dev

# O para producción
npm run build
```

### Paso 8: Crear Storage Link

```bash
# Crear enlace simbólico para archivos públicos
php artisan storage:link
```

### Paso 9: Iniciar Servidor de Desarrollo

```bash
# Iniciar servidor Laravel
php artisan serve

# En otra terminal, mantener Vite corriendo (si usas npm run dev)
npm run dev
```

---

## ⚙️ Configuración Inicial

### 1. Crear Usuario Administrador

Después de ejecutar los seeders, puedes crear un usuario administrador manualmente:

```bash
php artisan tinker
```

```php
User::create([
    'name' => 'Administrador',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
    'role' => 'admin',
    'email_verified_at' => now(),
]);
```

### 2. Configurar Permisos de Storage

```bash
# En Linux/Mac
chmod -R 755 storage bootstrap/cache

# En Windows (XAMPP), los permisos generalmente están bien por defecto
```

### 3. Configurar Variables de Entorno Adicionales

Edita `.env` según tus necesidades:

```env
APP_NAME="Flat Rate Imports"
APP_URL=http://localhost:8000
APP_ENV=local
APP_DEBUG=true

# Configuración de correo (opcional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
```

---

## 📁 Estructura del Proyecto

```
web_fri_pro/
├── app/
│   ├── Console/Commands/          # Comandos artisan personalizados
│   ├── Helpers/                    # Helpers de lógica de negocio
│   │   └── CotizadorHelper.php     # Lógica de cálculo de cotizaciones
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/              # Controladores de administración
│   │   │   │   ├── UserController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   ├── ThemeController.php
│   │   │   │   ├── CotizadorSectionController.php
│   │   │   │   ├── DashboardGuideController.php
│   │   │   │   └── ... (18 controladores)
│   │   │   ├── CotizadorController.php
│   │   │   └── HomeController.php
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php # Middleware para proteger rutas admin
│   │   └── Requests/               # Form Requests (validación)
│   ├── Mail/                       # Mailables (emails)
│   ├── Models/                     # Modelos Eloquent (19 modelos)
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Theme.php
│   │   ├── CotizadorSection.php
│   │   └── ... (15 modelos más)
│   └── Providers/
│       └── AppServiceProvider.php  # Service Provider principal
├── config/                         # Archivos de configuración
├── database/
│   ├── migrations/                 # Migraciones (30+ archivos)
│   └── seeders/                    # Seeders (15+ archivos)
├── docs/                           # Documentación completa
├── public/                         # Archivos públicos
│   ├── build/                      # Assets compilados
│   ├── favicon.ico
│   └── index.php
├── resources/
│   ├── css/
│   │   └── app.css                 # Estilos principales
│   ├── js/
│   │   ├── app.js                  # JavaScript principal
│   │   └── cotizador-alpine.js     # Lógica del cotizador
│   └── views/
│       ├── admin/                  # Vistas de administración
│       │   ├── themes/
│       │   ├── cotizador-sections/
│       │   ├── dashboard-guide/
│       │   └── ... (15 carpetas)
│       ├── components/              # Componentes Blade
│       │   ├── ui/                  # Componentes UI genéricos
│       │   └── app/                 # Componentes de aplicación
│       ├── layouts/                 # Layouts principales
│       ├── home.blade.php
│       ├── cotizador.blade.php
│       └── dashboard.blade.php
├── routes/
│   ├── web.php                     # Rutas web
│   └── auth.php                    # Rutas de autenticación
├── storage/                        # Almacenamiento
└── vendor/                         # Dependencias de Composer
```

---

## 🎯 Funcionalidades Implementadas

### 1. Sistema de Autenticación ✅

- Registro de usuarios
- Inicio de sesión
- Recuperación de contraseña
- Verificación de email
- Roles: Admin y Cliente
- Middleware de protección de rutas

**Archivos:**
- `app/Http/Controllers/Auth/`
- `resources/views/auth/`
- `routes/auth.php`

---

### 2. Cotizador de Importaciones ✅

**Características:**
- Selección de productos con códigos arancelarios
- Cálculo automático de impuestos (Ad-Valorem, FODINFA, IVA)
- Múltiples métodos de envío (Marítimo, Aéreo, Aéreo Express, Courier 4x4)
- Cálculo de tarifas por peso
- Régimen especial Courier 4x4 (arancel fijo $20)
- Sugerencias inteligentes de métodos de envío
- Exportación de cotización a PDF

**Archivos principales:**
- `app/Helpers/CotizadorHelper.php` - Lógica de cálculo
- `app/Http/Controllers/CotizadorController.php`
- `resources/views/cotizador.blade.php`
- `resources/js/cotizador-alpine.js`

**Modelos relacionados:**
- `Product` - Productos con códigos arancelarios
- `ShippingRate` - Tarifas de envío
- `TaxRate` - Tasas impositivas

---

### 3. Panel de Administración ✅

**Secciones implementadas:**

#### 3.1 Gestión de Usuarios
- CRUD completo de usuarios
- Asignación de roles
- Verificación de emails

#### 3.2 Gestión de Productos
- CRUD completo
- Códigos arancelarios (8 y 10 dígitos)
- Impuestos por producto (Ad-Valorem, Arancel Específico)
- Activación/desactivación
- Ordenamiento personalizado

#### 3.3 Tarifas de Envío
- Configuración por método y peso
- Rangos de peso personalizables
- Precio por libra
- Activación/desactivación de métodos

#### 3.4 Impuestos y Tasas
- Configuración global de impuestos
- Ad-Valorem, FODINFA, IVA
- Actualización de tasas (IVA 15% desde abril 2024)

#### 3.5 Slider Principal
- Gestión de slides del homepage
- Imágenes, títulos, subtítulos
- Enlaces y botones de acción
- Ordenamiento y activación

#### 3.6 Pasos del Proceso
- Explicación del proceso de importación
- Iconos SVG personalizados
- Descripciones detalladas

#### 3.7 Banner de Alerta
- Mensajes importantes en el sitio
- Tipos: Info, Advertencia, Error, Éxito
- Fechas de activación

#### 3.8 Beneficios
- Destacar ventajas del servicio
- Iconos y descripciones
- Ordenamiento personalizado

#### 3.9 Paquetes / Tracking
- Gestión de paquetes en tránsito
- Números de tracking
- Estados de envío
- Asociación con usuarios

**Archivos:**
- `app/Http/Controllers/Admin/` (18 controladores)
- `resources/views/admin/` (15+ carpetas de vistas)

---

### 4. Sistema de Temas ✅

**Características:**
- Múltiples temas predefinidos
- Personalización de colores:
  - Color principal
  - Color secundario
  - Color de acento
  - Gradientes de fondo (inicio, medio, fin)
  - Color de texto principal
  - Color de texto secundario
  - Color de botones
- Activación de temas (solo uno activo)
- Aplicación global mediante CSS variables

**Temas incluidos:**
1. Tema Púrpura (Por Defecto)
2. Tema Azul
3. Tema Verde
4. Tema Dance Studio

**Archivos:**
- `app/Models/Theme.php`
- `app/Http/Controllers/Admin/ThemeController.php`
- `resources/views/admin/themes/`
- `resources/css/app.css` (variables CSS)
- `resources/views/layouts/app.blade.php` (definición de variables)

---

### 5. Gestión de Contenido Dinámico ✅

#### 5.1 Gestión de Tiendas
- Logos SVG de tiendas asociadas
- Enlaces a tiendas
- Ordenamiento
- Configuración de sección (título, subtítulo, colores)

#### 5.2 Temas de Interés (Blog)
- Sistema de blog completo
- Artículos con título, contenido, imágenes
- Fechas de publicación
- Configuración de sección (título, colores, botón)

#### 5.3 Footer (Pie de Página)
- Enlaces de navegación
- Redes sociales con iconos SVG
- Configuración de marca y copyright
- Gestión completa desde dashboard

**Archivos:**
- `app/Models/Store.php`, `StoreSection.php`
- `app/Models/BlogPost.php`, `BlogSection.php`
- `app/Models/FooterLink.php`, `FooterSection.php`
- Controladores y vistas correspondientes

---

### 6. Gestión del Cotizador ✅

**Características:**
- Configuración de título y descripción
- Personalización de colores:
  - Color del título principal
  - Color de títulos de sección
  - Color de labels (7 campos):
    - Seleccionar Producto
    - Cantidad
    - Peso Unitario
    - Valor Unitario
    - Seleccionar Método de Envío
- Activación/desactivación

**Archivos:**
- `app/Models/CotizadorSection.php`
- `app/Http/Controllers/Admin/CotizadorSectionController.php`
- `database/migrations/2025_12_06_*.php` (2 migraciones)
- `resources/views/admin/cotizador-sections/edit.blade.php`
- `resources/views/cotizador.blade.php` (modificado)

---

### 7. Guía Interactiva del Dashboard ✅

**Características:**
- Sistema de ayuda paso a paso
- 20 pasos guiados cubriendo todas las funcionalidades
- Tour automático (cada 10 segundos)
- Navegación manual entre pasos
- Barra de progreso visual
- Menú lateral con todas las secciones
- Transiciones animadas

**Archivos:**
- `app/Http/Controllers/Admin/DashboardGuideController.php`
- `resources/views/admin/dashboard-guide/index.blade.php`
- `resources/views/dashboard.blade.php` (botón agregado)

---

### 8. Sistema de Navegación Avanzada ✅

**Características:**
- Navbar responsive con menú móvil
- Sidebar para administración
- Navegación sticky
- Efectos glassmorphism
- Animaciones suaves

**Archivos:**
- `resources/views/components/advanced-navbar.blade.php`
- `resources/css/app.css` (estilos de navegación)

---

### 9. Componentes UI Reutilizables ✅

**Componentes implementados:**
- `x-ui.card` - Tarjetas con glassmorphism
- `x-ui.button` - Botones estilizados
- `x-ui.form-group` - Grupos de formulario
- `x-ui.container` - Contenedores responsive
- `x-ui.grid` - Sistema de grillas
- `x-app.dashboard-stats` - Estadísticas del dashboard
- `x-app.hero-slider` - Slider principal
- Y más...

**Archivos:**
- `resources/views/components/ui/`
- `resources/views/components/app/`

---

## 🛠️ Tecnologías y Dependencias

### Backend
- **Laravel 12.x** - Framework PHP
- **PHP 8.2+** - Lenguaje de programación
- **MySQL 8.0+** - Base de datos
- **Composer** - Gestor de dependencias PHP

### Frontend
- **Tailwind CSS 3.1** - Framework CSS utility-first
- **Alpine.js 3.4** - Framework JavaScript ligero
- **Vite 7.0** - Build tool y dev server
- **PostCSS** - Procesador CSS
- **Autoprefixer** - Prefijos CSS automáticos

### Dependencias NPM
```json
{
  "devDependencies": {
    "@tailwindcss/forms": "^0.5.2",
    "@tailwindcss/vite": "^4.0.0",
    "alpinejs": "^3.4.2",
    "autoprefixer": "^10.4.2",
    "axios": "^1.11.0",
    "vite": "^7.0.7",
    "tailwindcss": "^3.1.0"
  },
  "dependencies": {
    "html2canvas": "^1.4.1",
    "jspdf": "^3.0.4",
    "select2": "^4.1.0-rc.0"
  }
}
```

### Dependencias Composer
- **laravel/framework:** ^12.0
- **laravel/breeze:** ^2.3 (Autenticación)
- **laravel/tinker:** ^2.10.1

---

## 📊 Estadísticas del Proyecto

### Código
- **Modelos:** 19 modelos Eloquent
- **Controladores:** 20 controladores (18 admin + 2 públicos)
- **Migraciones:** 30+ migraciones
- **Seeders:** 15+ seeders
- **Vistas:** 80+ vistas Blade
- **Componentes:** 25+ componentes reutilizables
- **Rutas:** 50+ rutas definidas

### Base de Datos
- **Tablas:** 20+ tablas
- **Relaciones:** Múltiples relaciones Eloquent
- **Índices:** Optimizados para rendimiento

### Funcionalidades
- ✅ **Autenticación:** 100% completo
- ✅ **Panel Admin:** 100% completo
- ✅ **Cotizador:** 100% completo
- ✅ **Gestión de Contenido:** 100% completo
- ✅ **Sistema de Temas:** 100% completo
- ✅ **UI/UX:** 100% completo

---

## 🎨 Diseño y UX

### Principios de Diseño
1. **Glassmorphism** - Efectos de vidrio esmerilado
2. **Mobile-First** - Diseño responsive priorizando móviles
3. **Consistencia Visual** - Mismo estilo en toda la aplicación
4. **Accesibilidad** - Contraste y legibilidad optimizados

### Paleta de Colores
- Colores dinámicos mediante sistema de temas
- Variables CSS para fácil personalización
- Gradientes personalizables por tema

---

## 📝 Comandos Útiles

### Desarrollo
```bash
# Iniciar servidor de desarrollo
php artisan serve

# Compilar assets en modo desarrollo
npm run dev

# Compilar assets para producción
npm run build

# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders
php artisan db:seed

# Ejecutar seeder específico
php artisan db:seed --class=NombreSeeder
```

### Base de Datos
```bash
# Crear nueva migración
php artisan make:migration nombre_migracion

# Crear nuevo seeder
php artisan make:seeder NombreSeeder

# Ver estado de migraciones
php artisan migrate:status

# Rollback última migración
php artisan migrate:rollback
```

### Caché
```bash
# Limpiar todas las cachés
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Tinker (Consola Interactiva)
```bash
php artisan tinker

# Ejemplos de uso:
User::count()
Product::all()
Theme::getActive()
```

---

## 🚀 Despliegue

### Hostinger (Producción)

Para desplegar en Hostinger, consulta la documentación completa:

- [Guía Completa de Despliegue](docs/DEPLOY_HOSTINGER.md)
- [Actualización 6 Diciembre 2024](docs/ACTUALIZAR_HOSTINGER_6_DICIEMBRE_2025.md)
- [Comandos SSH](docs/COMANDOS_SSH_HOSTINGER_6_DICIEMBRE_2025.md)

### Pasos Rápidos

1. Compilar assets: `npm run build`
2. Subir archivos (excepto `node_modules/`, `.git/`, `.env`)
3. Configurar `.env` en el servidor
4. Ejecutar migraciones: `php artisan migrate --force`
5. Ejecutar seeders: `php artisan db:seed`
6. Optimizar: `php artisan config:cache && php artisan route:cache`

---

## 📚 Documentación Adicional

Toda la documentación detallada está en la carpeta `docs/`:

- [Documentación Completa del Proyecto](docs/PROYECTO_COMPLETO.md)
- [Implementación del Cotizador](docs/COTIZADOR_IMPLEMENTATION.md)
- [Componentes UI](docs/COMPONENTES_UI.md)
- [Estrategia Modular](docs/ESTRATEGIA_MODULAR.md)
- [Resumen de Actualizaciones 2025](docs/RESUMEN_ACTUALIZACIONES_2025.md)
- [Índice Completo de Documentación](docs/README.md)

---

## 👥 Roles y Permisos

### Administrador (`admin`)
- Acceso completo al panel de administración
- Gestión de usuarios, productos, tarifas
- Configuración de contenido y temas
- Acceso a todas las funcionalidades

### Cliente (`customer`)
- Acceso al cotizador
- Ver su perfil
- Tracking de paquetes asignados
- Sin acceso al panel de administración

---

## 🔒 Seguridad

- Autenticación con Laravel Breeze
- Middleware de protección de rutas
- Validación de datos en servidor
- Protección CSRF
- Sanitización de inputs
- Permisos basados en roles

---

## 🐛 Solución de Problemas

### Error: "Class not found"
```bash
composer dump-autoload
php artisan clear-compiled
```

### Error: "Storage link not found"
```bash
php artisan storage:link
```

### Error: "Migration already exists"
```bash
php artisan migrate:status
# Si la migración ya está ejecutada, está bien
```

### Assets no se compilan
```bash
rm -rf node_modules package-lock.json
npm install
npm run build
```

---

## 📞 Soporte

Para más información o soporte, consulta la documentación en `docs/` o revisa los archivos de código comentados.

---

## 📄 Licencia

Este proyecto es privado y de uso exclusivo para Flat Rate Imports.

---

## 🎯 Próximas Mejoras

- [ ] Sistema de cotizaciones guardadas
- [ ] Notificaciones en tiempo real
- [ ] Reportes y estadísticas avanzadas
- [ ] Integración con APIs de tracking
- [ ] Sistema de órdenes completo

---

**Desarrollado y Diseñado por Lenin Nunez usando Laravel, Tailwind CSS y Alpine.js**

---

*Última actualización: 6 de Diciembre 2025*  
*Proyecto desarrollado desde Enero 2023 trabajando 2-3 horas por noche durante 24 meses*

