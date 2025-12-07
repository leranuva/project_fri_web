# 📚 Documentación Completa del Proyecto

## 🎯 Información General

**Nombre del Proyecto:** Sistema de Cotización de Importaciones  
**Framework:** Laravel 11.x  
**Base de Datos:** MySQL (XAMPP)  
**Frontend:** Blade Templates + Alpine.js + Tailwind CSS  
**Diseño:** Glassmorphism (Mobile-First)  
**Fecha de Inicio:** Noviembre 2023 
**Estado:** En Desarrollo Activo

---

## 📋 Tabla de Contenidos

1. [Arquitectura y Diseño](#arquitectura-y-diseño)
2. [Funcionalidades Implementadas](#funcionalidades-implementadas)
3. [Organización del Código](#organización-del-código)
4. [Base de Datos](#base-de-datos)
5. [Sistema de Autenticación](#sistema-de-autenticación)
6. [Panel de Administración](#panel-de-administración)
7. [Cotizador de Importaciones](#cotizador-de-importaciones)
8. [Componentes UI](#componentes-ui)
9. [Pendientes por Implementar](#pendientes-por-implementar)
10. [Tecnologías y Dependencias](#tecnologías-y-dependencias)
11. [Estructura de Archivos](#estructura-de-archivos)

---

## 🏗️ Arquitectura y Diseño

### Principios de Diseño

1. **Mobile-First Approach**
   - Diseño responsive que prioriza dispositivos móviles
   - Breakpoints de Tailwind: `sm:`, `md:`, `lg:`, `xl:`
   - Navegación adaptativa (menú móvil y sidebar desktop)

2. **Glassmorphism Design System**
   - Efectos de vidrio esmerilado (`backdrop-blur`)
   - Transparencias y bordes sutiles
   - Fondos con gradientes y elementos flotantes
   - Consistencia visual en toda la aplicación

3. **Arquitectura Modular**
   - Componentes Blade reutilizables
   - Separación de componentes UI genéricos y específicos de aplicación
   - Helpers para lógica de negocio
   - Controladores organizados por funcionalidad

4. **Backend-First**
   - Toda la lógica de negocio en PHP/Laravel
   - Frontend solo para presentación e interactividad
   - API RESTful para comunicación frontend-backend
   - Validaciones en servidor

### Estructura de Capas

```
┌─────────────────────────────────────┐
│         Frontend (Blade)            │
│  - Alpine.js (Interactividad)       │
│  - Tailwind CSS (Estilos)          │
│  - Componentes UI Modulares        │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│      Controladores (Laravel)        │
│  - Validación de Request            │
│  - Lógica de Negocio                │
│  - Respuestas JSON/Views            │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│      Helpers & Models               │
│  - CotizadorHelper (Cálculos)       │
│  - Models (Eloquent ORM)            │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│         Base de Datos               │
│  - MySQL (XAMPP)                    │
│  - Migraciones y Seeders            │
└─────────────────────────────────────┘
```

---

## ✅ Funcionalidades Implementadas

### 1. Sistema de Autenticación ✅

**Implementado con Laravel Breeze**

- ✅ Registro de usuarios
- ✅ Inicio de sesión
- ✅ Recuperación de contraseña
- ✅ Verificación de email
- ✅ Gestión de perfil de usuario
- ✅ Logout
- ✅ Middleware de autenticación
- ✅ Middleware de verificación de email
- ✅ Middleware de rol admin (`EnsureUserIsAdmin`)

**Archivos:**
- `app/Http/Controllers/Auth/*` - Controladores de autenticación
- `resources/views/auth/*` - Vistas de autenticación
- `routes/auth.php` - Rutas de autenticación
- `app/Http/Middleware/EnsureUserIsAdmin.php` - Middleware de admin

### 2. Panel de Administración ✅

**Dashboard Principal:**
- ✅ Estadísticas generales (usuarios, productos)
- ✅ Accesos rápidos a módulos de administración
- ✅ Diseño glassmorphism consistente
- ✅ Responsive design

**Módulos de Administración:**

#### 2.1. Gestión de Usuarios ✅
- ✅ Listado de usuarios (tabla responsive)
- ✅ Crear nuevo usuario
- ✅ Ver detalles de usuario
- ✅ Editar usuario
- ✅ Eliminar usuario (con confirmación)
- ✅ Búsqueda y filtros
- ✅ Paginación
- ✅ Roles: Admin y Customer

**Archivos:**
- `app/Http/Controllers/Admin/UserController.php`
- `resources/views/admin/users/*`

#### 2.2. Gestión de Productos ✅
- ✅ Listado de productos (grid de tarjetas responsive)
- ✅ Crear nuevo producto
- ✅ Ver detalles de producto
- ✅ Editar producto
- ✅ Eliminar producto
- ✅ Búsqueda por SKU, código arancelario o nombre
- ✅ Filtros por estado (activo/inactivo)
- ✅ Campos: key, name, arancel_code, arancel_subpartida, ad_valorem, arancel_especifico, etc.

**Archivos:**
- `app/Http/Controllers/Admin/ProductController.php`
- `resources/views/admin/products/*`

#### 2.3. Gestión de Tarifas de Envío ✅
- ✅ Listado de tarifas (grid de tarjetas responsive)
- ✅ Crear nueva tarifa
- ✅ Ver detalles de tarifa
- ✅ Editar tarifa
- ✅ Eliminar tarifa (requiere contraseña de admin)
- ✅ Búsqueda por método o notas
- ✅ Filtros por método y estado
- ✅ Soporte para Courier 4x4 con rangos de peso específicos
- ✅ Validación: max_weight > min_weight

**Archivos:**
- `app/Http/Controllers/Admin/ShippingRateController.php`
- `resources/views/admin/shipping-rates/*`

#### 2.4. Gestión de Impuestos ✅
- ✅ Listado de impuestos (tabla responsive)
- ✅ Crear nuevo impuesto
- ✅ Ver detalles de impuesto
- ✅ Editar impuesto
- ✅ Eliminar impuesto (requiere contraseña de admin)
- ✅ Impuestos: Fodinfa, IVA, Seguro CIF
- ✅ Mensajes de éxito/error

**Archivos:**
- `app/Http/Controllers/Admin/TaxRateController.php`
- `resources/views/admin/tax-rates/*`

#### 2.5. Gestión de Slider Principal ⚠️
- ✅ Vista de listado creada
- ⚠️ CRUD pendiente de implementar

**Archivos:**
- `app/Http/Controllers/Admin/SliderController.php`
- `resources/views/admin/sliders/index.blade.php`

### 3. Cotizador de Importaciones ✅

**Funcionalidades Principales:**

- ✅ Formulario completo de cotización
- ✅ Selección de producto (búsqueda y filtrado)
- ✅ Métodos de envío: Marítimo, Aéreo, Aéreo Express, Courier 4x4
- ✅ Cálculo automático de costos
- ✅ Validaciones en frontend y backend
- ✅ Desglose detallado de costos:
  - Costo del producto
  - Costo de envío
  - Impuestos (Ad-Valorem, Fodinfa, IVA)
  - Arancel específico
  - Seguro CIF
  - Arancel fijo Courier 4x4 ($20)
- ✅ Generación de PDF con diseño glassmorphism
- ✅ Resultados visuales profesionales
- ✅ Modales de validación con estilo glassmorphism
- ✅ Integración completa con base de datos

**Lógica de Negocio:**

- ✅ Cálculo de tarifas de envío por peso y método
- ✅ Lógica especial Courier 4x4:
  - Validación de peso (≤ 8.82 lbs) y valor FOB (≤ $400)
  - Si cumple: solo costo de envío + arancel fijo $20 (sin impuestos)
  - Si no cumple: cálculo normal con todos los impuestos
- ✅ Lógica especial Aéreo:
  - Peso 1-8 lbs: sin impuestos
  - Valor FOB ≤ $400: impuestos reducidos
- ✅ Cálculo de impuestos desde base de datos
- ✅ Validaciones de negocio (pesos mínimos/máximos)

**Archivos:**
- `app/Http/Controllers/CotizadorController.php`
- `app/Helpers/CotizadorHelper.php`
- `resources/views/cotizador.blade.php`
- `resources/js/cotizador-alpine.js`

### 4. Páginas Principales ✅

#### 4.1. Página de Inicio (`/`) ✅
- ✅ Hero section con slider de imágenes
- ✅ 4 imágenes con títulos y subtítulos informativos
- ✅ Botones de acción (Cotizar, Ir a Tienda)
- ✅ Sección de servicios
- ✅ Diseño responsive
- ✅ Navegación avanzada con glassmorphism

**Archivos:**
- `app/Http/Controllers/HomeController.php`
- `resources/views/home.blade.php`
- `resources/views/components/hero-slider.blade.php`

#### 4.2. Página de Cotizador (`/cotizador`) ✅
- ✅ Formulario completo
- ✅ Resultados visuales
- ✅ Generación de PDF

#### 4.3. Dashboard (`/dashboard`) ✅
- ✅ Estadísticas
- ✅ Accesos rápidos
- ✅ Diseño glassmorphism

#### 4.4. Perfil de Usuario (`/profile`) ✅
- ✅ Editar información personal
- ✅ Cambiar contraseña
- ✅ Eliminar cuenta
- ✅ Diseño glassmorphism

### 5. Componentes UI Modulares ✅

**Componentes Genéricos (`resources/views/components/ui/`):**

- ✅ `container.blade.php` - Contenedor principal responsive
- ✅ `card.blade.php` - Tarjetas con glassmorphism
- ✅ `button.blade.php` - Botones con variantes
- ✅ `form-group.blade.php` - Grupos de formulario
- ✅ `grid.blade.php` - Grids adaptativos
- ✅ `sidebar.blade.php` - Sidebar responsive

**Componentes de Aplicación (`resources/views/components/app/`):**

- ✅ `dashboard-stats.blade.php` - Estadísticas del dashboard

**Componentes Generales:**

- ✅ `advanced-navbar.blade.php` - Navegación avanzada con glassmorphism
- ✅ `hero-slider.blade.php` - Slider de imágenes
- ✅ `modal.blade.php` - Modales reutilizables
- ✅ `footer.blade.php` - Pie de página

### 6. Navegación y Layouts ✅

- ✅ Layout principal (`app.blade.php`)
- ✅ Layout de invitado (`guest.blade.php`)
- ✅ Navegación avanzada con glassmorphism
- ✅ Menú móvil con overlay
- ✅ Sidebar desktop (removido según requerimiento)
- ✅ Footer responsive

**Archivos:**
- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/guest.blade.php`
- `resources/views/components/advanced-navbar.blade.php`

### 7. Base de Datos ✅

**Tablas Implementadas:**

1. **users** ✅
   - id, name, email, password, role, email_verified_at, timestamps
   - Roles: 'admin', 'customer'

2. **products** ✅
   - id, key, name, arancel_code, arancel_subpartida, ad_valorem, arancel_especifico, new_percent, description, category, is_active, sort_order, timestamps

3. **shipping_rates** ✅
   - id, method, min_weight, max_weight, max_value_fob, cost_per_pound, fixed_cost, is_special_case, notes, sort_order, is_active, timestamps

4. **tax_rates** ✅
   - id, name, label, rate, description, is_active, timestamps

**Seeders Implementados:**

- ✅ `UserSeeder` - 2 admins, 2 customers
- ✅ `ProductSeeder` - 110+ productos
- ✅ `ShippingRateSeeder` - Tarifas de envío
- ✅ `TaxRateSeeder` - Impuestos (Fodinfa, IVA, Seguro CIF)
- ✅ `AssignArancelCodesSeeder` - Códigos arancelarios

**Migraciones:**

- ✅ Todas las tablas creadas
- ✅ Índices y relaciones configuradas
- ✅ Courier 4x4 con rangos específicos

### 8. Seguridad ✅

- ✅ Middleware de autenticación
- ✅ Middleware de verificación de email
- ✅ Middleware de rol admin
- ✅ Validación de contraseña para eliminaciones críticas
- ✅ CSRF protection
- ✅ Sanitización de inputs
- ✅ Hash de contraseñas

---

## 📁 Organización del Código

### Estructura de Controladores

```
app/Http/Controllers/
├── Admin/
│   ├── UserController.php          ✅ CRUD completo
│   ├── ProductController.php       ✅ CRUD completo
│   ├── ShippingRateController.php  ✅ CRUD completo
│   ├── TaxRateController.php       ✅ CRUD completo
│   └── SliderController.php         ⚠️ Pendiente
├── Auth/                            ✅ Laravel Breeze
├── CotizadorController.php          ✅ Completo
├── HomeController.php               ✅ Completo
└── ProfileController.php            ✅ Completo
```

### Estructura de Vistas

```
resources/views/
├── admin/
│   ├── users/                       ✅ CRUD completo
│   ├── products/                    ✅ CRUD completo
│   ├── shipping-rates/             ✅ CRUD completo
│   ├── tax-rates/                  ✅ CRUD completo
│   └── sliders/                    ⚠️ Solo index
├── auth/                            ✅ Laravel Breeze
├── components/
│   ├── ui/                          ✅ Componentes genéricos
│   └── app/                         ✅ Componentes específicos
├── layouts/                         ✅ Layouts principales
├── profile/                         ✅ Gestión de perfil
├── cotizador.blade.php              ✅ Completo
├── dashboard.blade.php              ✅ Completo
└── home.blade.php                   ✅ Completo
```

### Helpers y Lógica de Negocio

```
app/
├── Helpers/
│   └── CotizadorHelper.php          ✅ Lógica de cotización
├── Models/
│   ├── User.php                     ✅
│   ├── Product.php                  ✅
│   ├── ShippingRate.php             ✅
│   └── TaxRate.php                  ✅
└── Mail/
    └── QuoteEmail.php               ✅ Email de cotización
```

---

## 🗄️ Base de Datos

### Modelos y Relaciones

**User Model:**
- Roles: 'admin', 'customer'
- Relaciones: Ninguna directa (sistema simple)

**Product Model:**
- Scope: `active()`, `ordered()`
- Método: `findByKey($key)`

**ShippingRate Model:**
- Scope: `active()`, `forMethod($method)`, `ordered()`
- Método: `findRate($method, $weight)`

**TaxRate Model:**
- Scope: `active()`
- Método: `findByName($name)`

### Datos Semilla

- **Usuarios:** 2 admins, 2 customers
- **Productos:** 110+ productos con códigos arancelarios
- **Tarifas de Envío:** Marítimo, Aéreo, Aéreo Express, Courier 4x4
- **Impuestos:** Fodinfa (0.5%), IVA (15%), Seguro CIF (2.5%)

---

## 🎨 Sistema de Diseño

### Glassmorphism

**Características:**
- `backdrop-blur-xl` - Efecto de desenfoque
- `bg-white/10` - Fondos semitransparentes
- `border border-white/20` - Bordes sutiles
- `shadow-2xl` - Sombras profundas
- Gradientes de fondo

**Aplicado en:**
- ✅ Tarjetas (cards)
- ✅ Formularios
- ✅ Botones
- ✅ Modales
- ✅ Navegación
- ✅ Alertas
- ✅ Tablas

### Colores y Tipografía

- **Fondo:** Gradientes oscuros con elementos flotantes
- **Texto:** Blanco con opacidades variables
- **Acentos:** Colores semitransparentes para estados
- **Tipografía:** Sistema de fuentes de Tailwind

### Responsive Design

**Breakpoints:**
- `sm:` - 640px (móvil grande)
- `md:` - 768px (tablet)
- `lg:` - 1024px (desktop)
- `xl:` - 1280px (desktop grande)

**Estrategia:**
- Mobile-first
- Grids adaptativos (1/2/3 columnas)
- Navegación adaptativa
- Formularios responsive

---

## ⚠️ Pendientes por Implementar

### 1. Gestión de Slider Principal ⚠️

**Estado:** Vista de listado creada, CRUD pendiente

**Pendiente:**
- [ ] Crear nuevo slide
- [ ] Editar slide
- [ ] Eliminar slide
- [ ] Reordenar slides
- [ ] Subir imágenes
- [ ] Gestión de títulos y subtítulos

**Archivos a crear:**
- `resources/views/admin/sliders/create.blade.php`
- `resources/views/admin/sliders/edit.blade.php`
- Métodos en `SliderController.php`

### 2. Sistema de Cotizaciones Guardadas ⚠️

**Pendiente:**
- [ ] Modelo `Quote` o `Cotization`
- [ ] Tabla para guardar cotizaciones
- [ ] Historial de cotizaciones por usuario
- [ ] Re-cotizar desde historial
- [ ] Exportar cotizaciones
- [ ] Compartir cotizaciones

### 3. Notificaciones ⚠️

**Pendiente:**
- [ ] Sistema de notificaciones en tiempo real
- [ ] Notificaciones por email
- [ ] Notificaciones en dashboard
- [ ] Notificaciones de nuevas cotizaciones

### 4. Reportes y Estadísticas ⚠️

**Pendiente:**
- [ ] Reportes de cotizaciones
- [ ] Estadísticas de productos más cotizados
- [ ] Estadísticas de métodos de envío
- [ ] Gráficos y visualizaciones
- [ ] Exportación de reportes (PDF, Excel)

### 5. Gestión de Clientes ⚠️

**Pendiente:**
- [ ] CRUD de clientes (separado de usuarios)
- [ ] Historial de importaciones por cliente
- [ ] Contactos y direcciones
- [ ] Documentos por cliente

### 6. Sistema de Órdenes ⚠️

**Pendiente:**
- [ ] Modelo `Order`
- [ ] Proceso de creación de orden desde cotización
- [ ] Seguimiento de órdenes
- [ ] Estados de orden (pendiente, en tránsito, entregado)
- [ ] Notificaciones de estado

### 7. Integración con Tienda Externa ⚠️

**Pendiente:**
- [ ] API para sincronizar productos
- [ ] Sincronización de precios
- [ ] Webhooks para actualizaciones

### 8. Mejoras de UX/UI ⚠️

**Pendiente:**
- [ ] Animaciones y transiciones
- [ ] Loading states mejorados
- [ ] Skeleton loaders
- [ ] Mejora de accesibilidad (ARIA labels)
- [ ] Modo oscuro/claro (opcional)

### 9. Testing ⚠️

**Pendiente:**
- [ ] Tests unitarios para `CotizadorHelper`
- [ ] Tests de integración para API
- [ ] Tests de feature para CRUDs
- [ ] Tests de validaciones

### 10. Documentación de API ⚠️

**Pendiente:**
- [ ] Documentación de endpoints API
- [ ] Ejemplos de uso
- [ ] Postman collection

### 11. Optimizaciones ⚠️

**Pendiente:**
- [ ] Caché de productos y tarifas
- [ ] Optimización de consultas (eager loading)
- [ ] Compresión de imágenes
- [ ] Lazy loading de componentes
- [ ] Code splitting en JavaScript

### 12. Internacionalización ⚠️

**Pendiente:**
- [ ] Sistema de traducciones (i18n)
- [ ] Soporte multi-idioma
- [ ] Formato de moneda por región

### 13. Seguridad Adicional ⚠️

**Pendiente:**
- [ ] Rate limiting en API
- [ ] Logs de auditoría
- [ ] 2FA (autenticación de dos factores)
- [ ] Políticas de contraseñas más estrictas

---

## 🛠️ Tecnologías y Dependencias

### Backend

- **Laravel 11.x** - Framework PHP
- **PHP 8.2+** - Lenguaje de programación
- **MySQL** - Base de datos (XAMPP)
- **Composer** - Gestor de dependencias PHP

### Frontend

- **Blade Templates** - Motor de plantillas
- **Alpine.js 3.4.2** - Framework JavaScript ligero
- **Tailwind CSS 3.x** - Framework CSS utility-first
- **Vite** - Build tool y bundler

### Librerías JavaScript

- **jsPDF** - Generación de PDFs
- **html2canvas** - Captura de pantalla para PDFs

### Desarrollo

- **Laravel Breeze** - Scaffolding de autenticación
- **Laravel Mix/Vite** - Compilación de assets

### Dependencias Principales

```json
{
  "laravel/framework": "^11.0",
  "laravel/breeze": "^2.0",
  "alpinejs": "^3.4.2",
  "tailwindcss": "^3.x",
  "jspdf": "^2.x",
  "html2canvas": "^1.x"
}
```

---

## 📂 Estructura de Archivos

### Archivos Principales

```
web_fri_pro/
├── app/
│   ├── Console/Commands/          # Comandos artisan personalizados
│   ├── Helpers/                   # Helpers de lógica de negocio
│   ├── Http/
│   │   ├── Controllers/          # Controladores
│   │   ├── Middleware/           # Middleware personalizado
│   │   └── Requests/             # Form Requests
│   ├── Mail/                     # Mailables
│   ├── Models/                   # Modelos Eloquent
│   └── View/Components/          # Componentes Blade
├── config/                       # Archivos de configuración
├── database/
│   ├── migrations/               # Migraciones
│   └── seeders/                  # Seeders
├── docs/                         # Documentación
├── public/                       # Archivos públicos
├── resources/
│   ├── css/                      # Estilos CSS
│   ├── js/                       # JavaScript
│   └── views/                    # Vistas Blade
├── routes/                       # Rutas
└── storage/                      # Almacenamiento
```

### Documentación Existente

- `docs/COTIZADOR_IMPLEMENTATION.md` - Documentación del cotizador
- `docs/COTIZADOR_MIGRATION.md` - Migración a base de datos
- `docs/GUIA_VERIFICACION_ARANCELES.md` - Guía de códigos arancelarios
- `docs/RESUMEN_ACTUALIZACIONES_2025.md` - Actualizaciones 2025
- `docs/VERIFICACION_SENAE.md` - Verificación SENAE
- `COMPONENTES_UI.md` - Componentes UI
- `ESTRATEGIA_MODULAR.md` - Estrategia modular
- `NAVEGACION_AVANZADA.md` - Navegación avanzada
- `PAGINAS_PRINCIPALES.md` - Páginas principales

---

## 🚀 Comandos Útiles

### Desarrollo

```bash
# Iniciar servidor de desarrollo
php artisan serve

# Compilar assets
npm run dev          # Modo desarrollo
npm run build        # Producción

# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders
php artisan db:seed

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Base de Datos

```bash
# Crear migración
php artisan make:migration nombre_migracion

# Crear seeder
php artisan make:seeder NombreSeeder

# Verificar códigos arancelarios
php artisan arancel:verify

# Importar códigos arancelarios
php artisan arancel:import
```

### Testing

```bash
# Ejecutar tests
php artisan test
```

---

## 📊 Estadísticas del Proyecto

### Código Implementado

- **Controladores:** 18 archivos
- **Modelos:** 4 modelos principales
- **Vistas:** 50+ vistas Blade
- **Componentes:** 15+ componentes reutilizables
- **Helpers:** 1 helper principal
- **Migraciones:** 7 migraciones
- **Seeders:** 6 seeders

### Funcionalidades

- ✅ **Autenticación:** 100% completo
- ✅ **Panel Admin:** 80% completo (falta slider CRUD)
- ✅ **Cotizador:** 100% completo
- ✅ **Base de Datos:** 100% completo
- ✅ **UI/UX:** 100% completo
- ⚠️ **Funcionalidades Adicionales:** 0% (pendientes)

---

## 🎯 Próximos Pasos Recomendados

### Prioridad Alta

1. **Completar CRUD de Slider** - Necesario para gestión de contenido
2. **Sistema de Cotizaciones Guardadas** - Funcionalidad core del negocio
3. **Sistema de Notificaciones** - Mejora la experiencia de usuario

### Prioridad Media

4. **Reportes y Estadísticas** - Valor agregado para administradores
5. **Sistema de Órdenes** - Flujo completo de negocio
6. **Testing** - Asegurar calidad del código

### Prioridad Baja

7. **Optimizaciones** - Mejoras de rendimiento
8. **Internacionalización** - Expansión futura
9. **Integración con Tienda Externa** - Automatización

---

## 📝 Notas Finales

### Logros Principales

✅ Sistema completo de cotización con lógica compleja  
✅ Panel de administración funcional y completo  
✅ Diseño glassmorphism consistente y profesional  
✅ Arquitectura modular y escalable  
✅ Base de datos bien estructurada  
✅ Migración completa de config a base de datos  

### Consideraciones

- El proyecto está en un estado funcional y estable
- La arquitectura permite fácil expansión
- El diseño es moderno y responsive
- El código sigue buenas prácticas de Laravel

### Mantenimiento

- Revisar y actualizar dependencias regularmente
- Mantener documentación actualizada
- Realizar backups de base de datos
- Monitorear logs de errores

---

**Última Actualización:** Diciembre 2025  
**Versión del Documento:** 1.0  
**Autor:** Lenin Ramiro Nunez Valverde





