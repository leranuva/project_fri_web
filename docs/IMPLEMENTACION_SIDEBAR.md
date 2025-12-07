# 📱 Implementación de Sidebar/Menú Móvil

Esta guía documenta la implementación del sistema de navegación con sidebar que se adapta según el tamaño de pantalla.

## 🎯 Comportamiento por Pantalla

| Pantalla | Comportamiento | Implementación |
| :--- | :--- | :--- |
| **Móvil/Tablet (< 1024px)** | Oculto. Se muestra como Modal superpuesto al hacer clic | Alpine.js (`x-data`, `x-show`) y Clase CSS (`lg:hidden`) |
| **Tablet Grande/Desktop (≥ 1024px)** | Visible siempre. Flota al lado del contenido | Clase CSS (`hidden lg:block`) |

## 🏗️ Esquema de Layout

El layout principal (`resources/views/layouts/app.blade.php`) utiliza un esquema flex:

```html
<div class="min-h-screen flex">
    <aside class="hidden lg:block w-64 flex-shrink-0">
        <!-- Sidebar Desktop -->
    </aside>
    
    <div class="flex-grow">
        <!-- Contenido Principal -->
    </div>
</div>
```

## 📐 Estructura Implementada

### 1. Layout Principal (`app.blade.php`)

```blade
<div class="min-h-screen flex bg-gray-100" x-data="{ sidebarOpen: false }">
    {{-- Sidebar Desktop - Oculto en móvil, visible en desktop --}}
    <aside class="hidden lg:block w-64 flex-shrink-0 bg-white border-r border-gray-200">
        @include('layouts.sidebar')
    </aside>

    {{-- Contenido Principal --}}
    <div class="flex-grow flex flex-col min-w-0">
        {{-- Barra de Navegación Superior (solo móvil) --}}
        @include('layouts.navigation')

        {{-- Page Heading --}}
        @isset($header)
            <header class="bg-white shadow">
                <x-ui.container>
                    {{ $header }}
                </x-ui.container>
            </header>
        @endisset

        {{-- Page Content --}}
        <main class="flex-grow py-4 sm:py-6 lg:py-8">
            <x-ui.container>
                {{ $slot }}
            </x-ui.container>
        </main>
    </div>

    {{-- Sidebar Móvil - Modal Superpuesto --}}
    <div 
        x-show="sidebarOpen" 
        x-cloak
        class="lg:hidden fixed inset-0 z-50"
        @click="sidebarOpen = false"
    >
        {{-- Overlay --}}
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        
        {{-- Sidebar Móvil --}}
        <aside 
            class="absolute left-0 top-0 bottom-0 w-64 bg-white shadow-lg overflow-y-auto"
            @click.stop
        >
            @include('layouts.sidebar')
        </aside>
    </div>
</div>
```

### 2. Sidebar (`layouts/sidebar.blade.php`)

Componente reutilizable que se muestra tanto en desktop como en móvil:

```blade
<div class="h-full flex flex-col">
    {{-- Logo --}}
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="block h-8 w-auto fill-current text-gray-800" />
        </a>
    </div>

    {{-- Navigation Links --}}
    <nav class="flex-1 px-4 py-4 space-y-1">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-nav-link>
    </nav>

    {{-- User Section --}}
    <div class="px-4 py-4 border-t border-gray-200">
        <!-- Información del usuario y acciones -->
    </div>
</div>
```

### 3. Navegación Superior (`layouts/navigation.blade.php`)

Barra de navegación que solo se muestra en móvil/tablet (oculta en desktop con sidebar):

```blade
<nav class="lg:hidden bg-white border-b border-gray-100">
    <x-ui.container>
        <div class="flex justify-between items-center h-14 sm:h-16">
            {{-- Botón Toggle Sidebar --}}
            <button @click="sidebarOpen = !sidebarOpen">
                <svg><!-- Icono hamburguesa --></svg>
            </button>
            
            {{-- Logo --}}
            <a href="{{ route('dashboard') }}">
                <x-application-logo />
            </a>

            {{-- User Menu --}}
            <x-dropdown>
                <!-- Menú de usuario -->
            </x-dropdown>
        </div>
    </x-ui.container>
</nav>
```

## 🔧 Características Técnicas

### Alpine.js

- **x-data**: Define el estado `sidebarOpen` para controlar la visibilidad
- **x-show**: Muestra/oculta el sidebar móvil según el estado
- **x-cloak**: Oculta el elemento hasta que Alpine.js se inicialice
- **@click**: Maneja los eventos de clic para abrir/cerrar

### Clases CSS Responsivas

- **`hidden lg:block`**: Oculta en móvil, muestra en desktop (≥1024px)
- **`lg:hidden`**: Muestra en móvil, oculta en desktop
- **`w-64`**: Ancho fijo de 16rem (256px) usando clases de Tailwind
- **`flex-shrink-0`**: Evita que el sidebar se encoja
- **`flex-grow`**: Permite que el contenido principal ocupe el espacio restante

### Evitar Anchos Fijos en Píxeles

✅ **Correcto:**
- `w-64` (clase Tailwind = 16rem)
- `w-full` (100% del ancho)
- `w-1/2` (50% del ancho)
- `max-w-7xl` (ancho máximo)

❌ **Incorrecto:**
- `width: 256px`
- `w-[256px]` (a menos que sea absolutamente necesario)
- Valores fijos en píxeles

## ✅ Checklist de Implementación

- [x] Crear un componente `x-ui.container` para todos los views principales
- [x] Asegurar que todos los listados de tarjetas/datos usen el patrón de `grid-cols-1 sm:grid-cols-2 md:grid-cols-3`
- [x] Implementar el toggle del menú móvil/Sidebar usando Alpine.js y las clases `hidden lg:block` en el layout principal
- [x] Evitar el uso de anchos fijos de pixel, prefiriendo % o clases de Tailwind (`w-full`, `w-1/2`, etc.)

## 🎨 Uso en Vistas

Todas las vistas que usan `<x-app-layout>` automáticamente tienen acceso al sidebar:

```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl">Título</h2>
    </x-slot>

    <x-ui.container>
        <x-ui.grid :cols="1" :cols-sm="2" :cols-md="3" gap="default">
            <x-ui.card>Contenido 1</x-ui.card>
            <x-ui.card>Contenido 2</x-ui.card>
            <x-ui.card>Contenido 3</x-ui.card>
        </x-ui.grid>
    </x-ui.container>
</x-app-layout>
```

## 📱 Experiencia de Usuario

### Móvil/Tablet (< 1024px)
1. El usuario ve una barra de navegación superior con botón hamburguesa
2. Al hacer clic en el botón, se abre un modal superpuesto con el sidebar
3. El overlay oscuro permite cerrar el sidebar al hacer clic fuera
4. El sidebar se desliza desde la izquierda

### Desktop (≥ 1024px)
1. El sidebar está siempre visible a la izquierda
2. El contenido principal se ajusta automáticamente
3. No hay barra de navegación superior (se usa el sidebar)

## 🔍 Notas Importantes

1. **x-cloak**: Se requiere el estilo CSS para ocultar elementos antes de que Alpine.js se inicialice
2. **z-index**: El sidebar móvil usa `z-50` para estar por encima del contenido
3. **Overlay**: El fondo oscuro ayuda a enfocar la atención en el sidebar móvil
4. **@click.stop**: Previene que el clic en el sidebar cierre el modal
5. **flex-grow**: Permite que el contenido principal ocupe todo el espacio disponible




