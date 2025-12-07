# 📄 Páginas Principales del Sitio Web

Este documento describe las páginas principales implementadas en el sitio web.

## 🏠 Páginas Implementadas

### 1. Página de Inicio (`/`)

**Ruta:** `route('home')`  
**Controlador:** `HomeController@index`  
**Vista:** `resources/views/home.blade.php`  
**Layout:** `guest-layout` (pública)

**Características:**
- Hero section con mensaje de bienvenida
- Botones principales:
  - **Cotizar Ahora**: Redirige a `/cotizador`
  - **Ir a Tienda**: Abre [https://flatrateimports.com/](https://flatrateimports.com/) en nueva pestaña
- Sección de servicios con 3 tarjetas destacadas
- Sección CTA (Call to Action) con botones de registro/login
- Diseño responsive mobile-first

**Botones de Acción:**
- Para usuarios **no autenticados**: Muestra botones "Registrarse" e "Iniciar Sesión"
- Para usuarios **autenticados**: Muestra botón "Ir al Dashboard"

### 2. Cotizador (`/cotizador`)

**Ruta:** `route('cotizador')`  
**Controlador:** `CotizadorController@index`  
**Vista:** `resources/views/cotizador.blade.php`  
**Layout:** `app-layout` (requiere autenticación para mejor experiencia)

**Características:**
- Formulario completo de cotización con secciones:
  1. **Información del Producto**
     - Nombre del producto
     - Categoría (Electrónica, Electrodomésticos, Ropa, etc.)
     - Cantidad, Peso (kg), Valor unitario (USD)
  
  2. **Origen y Destino**
     - País de origen (USA, China, Europa, Otros)
     - País de destino (Ecuador por defecto, Colombia, Perú, Otros)
  
  3. **Información de Contacto**
     - Nombre completo
     - Email (prellenado si está autenticado)
     - Teléfono
     - Mensaje adicional (opcional)

- Diseño responsive con grids adaptativos
- Información de ayuda al final del formulario
- Enlace a la tienda [https://flatrateimports.com/](https://flatrateimports.com/)

### 3. Dashboard (`/dashboard`)

**Ruta:** `route('dashboard')`  
**Vista:** `resources/views/dashboard.blade.php`  
**Layout:** `app-layout`  
**Requisito:** Autenticación requerida

**Características:**
- Panel principal para usuarios autenticados
- Grid de estadísticas usando componente `dashboard-stats`
- Diseño responsive

## 🔗 Enlaces a Tienda Externa

El enlace a la tienda [https://flatrateimports.com/](https://flatrateimports.com/) está implementado en:

1. **Sidebar** (Desktop y Móvil)
   - Icono de carrito de compras
   - Se abre en nueva pestaña (`target="_blank"`)

2. **Navegación Superior** (Móvil/Tablet)
   - Enlace visible en la barra de navegación

3. **Página de Inicio**
   - Botón principal "Ir a Tienda" en hero section
   - Se abre en nueva pestaña

4. **Página de Cotizador**
   - Enlace en la sección de ayuda
   - Se abre en nueva pestaña

## 🔐 Botones de Autenticación

### Para Usuarios No Autenticados

**Sidebar (Desktop):**
- Botón "Iniciar Sesión" (azul claro)
- Botón "Registrarse" (azul oscuro)

**Navegación Superior (Móvil):**
- Enlace "Iniciar Sesión" (texto)
- Botón "Registrarse" (azul oscuro)

**Página de Inicio:**
- Sección CTA con botones "Registrarse" e "Iniciar Sesión"

### Para Usuarios Autenticados

**Sidebar:**
- Información del usuario (avatar, nombre, email)
- Enlaces a Perfil y Cerrar Sesión

**Navegación Superior:**
- Dropdown con avatar del usuario
- Opciones: Perfil y Cerrar Sesión

## 📱 Navegación Implementada

### Sidebar (Desktop ≥ 1024px)

Menú lateral con:
- **Inicio** (`/`)
- **Cotizador** (`/cotizador`)
- **Ir a Tienda** (https://flatrateimports.com/)
- **Dashboard** (`/dashboard`) - Solo si está autenticado
- Sección de usuario o botones de login/registro

### Navegación Superior (Móvil/Tablet < 1024px)

Barra superior con:
- Botón hamburguesa (abre sidebar móvil)
- Logo
- Botones de autenticación o menú de usuario

## 🎨 Componentes Utilizados

Todas las páginas utilizan los componentes UI modulares:

- `<x-ui.container>` - Contenedor principal
- `<x-ui.card>` - Tarjetas de contenido
- `<x-ui.button>` - Botones responsivos
- `<x-ui.grid>` - Grids adaptativos (1/2/3 columnas)
- `<x-ui.form-group>` - Grupos de formulario
- `<x-app.dashboard-stats>` - Estadísticas del dashboard

## 📋 Rutas Definidas

```php
// Públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cotizador', [CotizadorController::class, 'index'])->name('cotizador');

// Requieren autenticación
Route::get('/dashboard', ...)->middleware(['auth', 'verified'])->name('dashboard');
```

## ✅ Características Implementadas

- ✅ Página de inicio con hero section y servicios
- ✅ Cotizador completo con formulario responsivo
- ✅ Enlaces a tienda externa (https://flatrateimports.com/)
- ✅ Botones de inicio de sesión y registro en múltiples ubicaciones
- ✅ Navegación adaptativa (sidebar desktop, menú móvil)
- ✅ Diseño mobile-first responsive
- ✅ Integración con sistema de autenticación de Laravel Breeze

## 🚀 Próximos Pasos Sugeridos

1. Implementar lógica de procesamiento del formulario de cotización
2. Agregar validación del formulario de cotización
3. Crear sistema de notificaciones para cotizaciones
4. Implementar panel de administración para gestionar cotizaciones
5. Agregar más páginas según necesidades del negocio





