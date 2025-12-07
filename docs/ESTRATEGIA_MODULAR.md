# 🚀 Estrategia Modular con Componentes Blade

Esta guía documenta la estrategia de diseño modular utilizando Componentes Blade para garantizar la reusabilidad y el mantenimiento.

## 📁 Estructura de Componentes

Utilizamos una estructura organizada por tipo de componente:

### Directorios de Componentes

| Tipo de Componente | Directorio | Ejemplo de Nombre | Uso Principal |
| :--- | :--- | :--- | :--- |
| **Layouts** | `resources/views/layouts/` | `layouts.app` | Estructura principal, incluye Sidebar, Header, Footer |
| **Base/UI** | `resources/views/components/ui/` | `ui.card`, `ui.button`, `ui.container` | Elementos de interfaz reutilizables |
| **App** | `resources/views/components/app/` | `app.dashboard-stats` | Bloques de contenido específicos de la aplicación |

## 🧩 Creación de un Componente

### 1. Crear el Componente

```bash
# Componente UI genérico
php artisan make:component Ui/Card

# Componente específico de la aplicación
php artisan make:component App/DashboardStats
```

### 2. Uso en Blade

```blade
{{-- Componente UI genérico --}}
<x-ui.card class="shadow-lg">
    Contenido de la tarjeta
</x-ui.card>

{{-- Componente específico de la app --}}
<x-app.dashboard-stats 
    title="Usuarios Totales" 
    value="1,234" 
    icon="fas fa-users"
    color="blue"
/>
```

## 📐 Patrones de Diseño Responsivo Clave

### 4.1. Contenedor Principal (`x-ui.container`)

El componente `x-ui.container` es esencial para aplicar márgenes y anchos máximos consistentes en todos los dispositivos.

**Implementación:**
```blade
<div class="mx-auto max-w-7xl p-4 sm:px-6 lg:px-8 {{ $attributes->get('class') }}">
    {{ $slot }}
</div>
```

**Uso:**
```blade
<x-ui.container>
    Contenido aquí
</x-ui.container>
```

**Características:**
- `mx-auto`: Centra el contenedor horizontalmente
- `max-w-7xl`: Ancho máximo de 80rem (1280px)
- `p-4`: Padding base en móvil (1rem)
- `sm:px-6`: Padding horizontal en pantallas pequeñas (1.5rem)
- `lg:px-8`: Padding horizontal en pantallas grandes (2rem)

### 4.2. Rejillas Responsivas (Grids)

Utilizar `grid-cols-{n}` para definir cómo se apilan los elementos en función del tamaño de la pantalla.

**Patrón de Rejilla (1 / 2 / 3 Columnas):**

```blade
<div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
    <div>Item 1</div>
    <div>Item 2</div>
    <div>Item 3</div>
</div>
```

**Usando el Componente Grid:**

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

## 🎨 Componentes UI Disponibles

### Container
```blade
<x-ui.container>
    Contenido con márgenes y padding consistentes
</x-ui.container>
```

### Card
```blade
<x-ui.card padding="default" shadow>
    Contenido de la tarjeta
</x-ui.card>
```

### Button
```blade
<x-ui.button variant="primary" size="default" full-width>
    Enviar
</x-ui.button>
```

### Grid
```blade
<x-ui.grid :cols="1" :cols-sm="2" :cols-md="3" gap="default">
    {{-- Items del grid --}}
</x-ui.grid>
```

### FormGroup
```blade
<x-ui.form-group name="email" label="Email">
    <x-text-input type="email" name="email" />
</x-ui.form-group>
```

## 📱 Ejemplo Completo: Dashboard con Estadísticas

```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800">
            Dashboard
        </h2>
    </x-slot>

    <x-ui.container>
        {{-- Grid de estadísticas --}}
        <x-ui.grid :cols="1" :cols-sm="2" :cols-md="4" gap="default" class="mb-6">
            <x-app.dashboard-stats 
                title="Usuarios" 
                value="1,234" 
                icon="fas fa-users"
                color="blue"
            />
            <x-app.dashboard-stats 
                title="Ventas" 
                value="$5,678" 
                icon="fas fa-dollar-sign"
                color="green"
            />
            <x-app.dashboard-stats 
                title="Pedidos" 
                value="89" 
                icon="fas fa-shopping-cart"
                color="purple"
            />
            <x-app.dashboard-stats 
                title="Productos" 
                value="456" 
                icon="fas fa-box"
                color="yellow"
            />
        </x-ui.grid>

        {{-- Contenido principal --}}
        <x-ui.grid :cols="1" :cols-md="2" gap="default">
            <x-ui.card>
                <h3 class="text-lg font-semibold mb-4">Gráfico 1</h3>
                {{-- Contenido del gráfico --}}
            </x-ui.card>
            <x-ui.card>
                <h3 class="text-lg font-semibold mb-4">Gráfico 2</h3>
                {{-- Contenido del gráfico --}}
            </x-ui.card>
        </x-ui.grid>
    </x-ui.container>
</x-app-layout>
```

## 🔧 Mejores Prácticas

1. **Siempre usar componentes UI para elementos reutilizables**
2. **Crear componentes App para bloques específicos de la aplicación**
3. **Seguir la filosofía mobile-first en todos los componentes**
4. **Usar el componente Container para mantener consistencia en márgenes**
5. **Utilizar Grid para layouts responsivos**
6. **Mantener los componentes pequeños y enfocados en una sola responsabilidad**

## 📝 Convenciones de Nomenclatura

- **Componentes UI**: `Ui/ComponentName` → `<x-ui.component-name>`
- **Componentes App**: `App/ComponentName` → `<x-app.component-name>`
- **Layouts**: `layouts/layout-name.blade.php` → `@include('layouts.layout-name')`

## 🎯 Ventajas de esta Estrategia

✅ **Reusabilidad**: Los componentes pueden usarse en múltiples lugares
✅ **Mantenibilidad**: Cambios en un componente se reflejan en toda la aplicación
✅ **Consistencia**: Diseño uniforme en toda la aplicación
✅ **Escalabilidad**: Fácil agregar nuevos componentes
✅ **Responsive**: Todos los componentes siguen mobile-first




