# 🚀 Guía de Componentes UI - Estrategia Mobile-First

Esta guía documenta los componentes UI modulares implementados siguiendo la filosofía **mobile-first** con Tailwind CSS y Alpine.js.

## 📱 Filosofía Mobile-First

Todos los estilos se definen primero para móviles (0px+) y luego se sobrescriben para pantallas más grandes usando prefijos de breakpoint:

- **Base (0px+)**: Estilos para móviles pequeños
- **sm: (640px+)**: Celulares grandes / Tablets pequeñas
- **md: (768px+)**: Tablets estándar (vertical)
- **lg: (1024px+)**: Tablets grandes / Desktop

## 🧩 Componentes Disponibles

### 1. Container (`<x-ui.container>`)

Componente contenedor principal con márgenes y anchos máximos consistentes.

**Implementación:**
```blade
<div class="mx-auto max-w-7xl p-4 sm:px-6 lg:px-8">
    {{ $slot }}
</div>
```

**Características:**
- `mx-auto`: Centra el contenedor horizontalmente
- `max-w-7xl`: Ancho máximo de 80rem (1280px)
- `p-4`: Padding base en móvil (1rem)
- `sm:px-6`: Padding horizontal en pantallas pequeñas (1.5rem)
- `lg:px-8`: Padding horizontal en pantallas grandes (2rem)

**Ejemplo:**
```blade
<x-ui.container>
    Contenido aquí
</x-ui.container>
```

### 2. Card (`<x-ui.card>`)

Tarjeta con sombra, bordes redondeados y padding configurables.

**Props:**
- `shadow`: Mostrar sombra (default: `true`)
- `rounded`: Bordes redondeados (default: `true`)
- `padding`: Padding interno (`'none'`, `'sm'`, `'default'`, `'lg'`)
- `bgColor`: Color de fondo (`'white'`, `'gray'`, `'gray-100'`)

**Ejemplo:**
```blade
<x-ui.card padding="default" class="shadow-lg">
    Contenido de la tarjeta
</x-ui.card>
```

### 3. Button (`<x-ui.button>`)

Botón responsivo con variantes y tamaños configurables.

**Props:**
- `variant`: Estilo del botón (`'primary'`, `'secondary'`, `'danger'`, `'success'`, `'outline'`)
- `size`: Tamaño (`'sm'`, `'default'`, `'lg'`)
- `fullWidth`: Ancho completo en móvil, auto en desktop (default: `false`)
- `type`: Tipo de botón (default: `'button'`)

**Ejemplo:**
```blade
<x-ui.button variant="primary" size="default" full-width>
    Enviar
</x-ui.button>
```

### 4. Grid (`<x-ui.grid>`)

Sistema de grilla responsivo mobile-first siguiendo el patrón: **1 columna → 2 columnas → 3 columnas**.

**Patrón de Rejilla:**
```blade
<div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
    <!-- Items -->
</div>
```

**Props:**
- `cols`: Columnas en móvil (base) (default: `1`)
- `colsSm`: Columnas en sm (640px+) (default: `2`)
- `colsMd`: Columnas en md (768px+) (default: `3`)
- `gap`: Espaciado entre elementos (`'none'`, `'sm'`, `'default'`, `'lg'`)

**Ejemplo:**
```blade
<x-ui.grid :cols="1" :cols-sm="2" :cols-md="3" gap="default">
    <x-ui.card>Item 1</x-ui.card>
    <x-ui.card>Item 2</x-ui.card>
    <x-ui.card>Item 3</x-ui.card>
</x-ui.grid>
```

**Breakpoints:**
- **Base (0px+)**: `grid-cols-1` - 1 columna en móvil
- **sm: (640px+)**: `sm:grid-cols-2` - 2 columnas en tablets pequeñas
- **md: (768px+)**: `md:grid-cols-3` - 3 columnas en tablets grandes/desktop

### 5. Sidebar (`<x-ui.sidebar>`)

Sidebar oculto en móvil, visible en desktop (lg+).

**Props:**
- `position`: Posición (`'left'`, `'right'`)
- `width`: Ancho en unidades Tailwind (default: `64` = 16rem)

**Ejemplo:**
```blade
<x-ui.sidebar position="left" :width="64">
    Contenido del sidebar
</x-ui.sidebar>
```

### 6. FormGroup (`<x-ui.form-group>`)

Grupo de formulario con label y manejo de errores.

**Props:**
- `name`: Nombre del campo (para errores)
- `label`: Texto del label
- `required`: Campo requerido (default: `false`)

**Ejemplo:**
```blade
<x-ui.form-group name="email" label="Email">
    <x-text-input type="email" name="email" />
</x-ui.form-group>
```

## 📐 Patrones de Uso

### Layout Responsivo Completo

```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl">Título</h2>
    </x-slot>

    <x-ui.container>
        <x-ui.grid :cols="1" :cols-sm="2" :cols-md="3" gap="default">
            <x-ui.card>
                Contenido 1
            </x-ui.card>
            <x-ui.card>
                Contenido 2
            </x-ui.card>
            <x-ui.card>
                Contenido 3
            </x-ui.card>
        </x-ui.grid>
    </x-ui.container>
</x-app-layout>
```

### Formulario Responsivo

```blade
<x-ui.container>
    <x-ui.card>
        <form>
            <x-ui.form-group name="name" label="Nombre">
                <x-text-input type="text" name="name" />
            </x-ui.form-group>
            
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <x-ui.button variant="primary" full-width class="sm:w-auto">
                    Guardar
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-ui.container>
```

## 🎨 Clases Tailwind Comunes

### Espaciado Responsivo
- `p-4 sm:px-6 lg:px-8` - Padding que aumenta en pantallas grandes
- `gap-6` - Espaciado entre elementos del grid
- `mb-4 sm:mb-6` - Margen inferior responsivo

### Tamaños de Texto
- `text-sm sm:text-base` - Texto más pequeño en móvil
- `text-lg sm:text-xl` - Títulos responsivos

### Flexbox Responsivo
- `flex-col sm:flex-row` - Columna en móvil, fila en desktop
- `w-full sm:w-auto` - Ancho completo en móvil, automático en desktop

### Grid Responsivo
- `grid-cols-1 sm:grid-cols-2 md:grid-cols-3` - Patrón estándar: 1 → 2 → 3 columnas

## 🔧 Alpine.js para Interactividad

Los componentes que requieren interactividad (menús móviles, modales) usan Alpine.js:

```blade
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open" x-cloak>Contenido</div>
</div>
```

## 📝 Notas Importantes

1. **Siempre definir estilos base para móvil** (sin prefijo)
2. **Usar prefijos para pantallas más grandes** (`sm:`, `md:`, `lg:`)
3. **Los componentes son modulares y reutilizables**
4. **Mantener consistencia en espaciados y tamaños**
5. **Probar en diferentes tamaños de pantalla**
6. **Usar `<x-ui.container>` para mantener márgenes consistentes**
7. **Seguir el patrón de grid: `grid-cols-1 sm:grid-cols-2 md:grid-cols-3`**
