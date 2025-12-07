# 📊 Documentación Completa del Cotizador de Importaciones

Este documento describe la implementación completa del sistema de cotización de importaciones, incluyendo arquitectura, funciones, flujos de datos y ejemplos de uso.

## 📋 Tabla de Contenidos

1. [Arquitectura General](#arquitectura-general)
2. [Estructura de Archivos](#estructura-de-archivos)
3. [Configuración de Productos](#configuración-de-productos)
4. [Helper de Cotización](#helper-de-cotización)
5. [Controlador API](#controlador-api)
6. [Frontend (Alpine.js)](#frontend-alpinejs)
7. [Flujo de Datos](#flujo-de-datos)
8. [Validaciones](#validaciones)
9. [Cálculos de Impuestos](#cálculos-de-impuestos)
10. [Tarifas de Envío](#tarifas-de-envío)
11. [Ejemplos de Uso](#ejemplos-de-uso)

---

## 🏗️ Arquitectura General

El cotizador sigue una arquitectura **backend-first** donde toda la lógica de negocio está centralizada en PHP/Laravel, y el frontend solo se encarga de la presentación y comunicación con el backend.

```
┌─────────────────┐
│   Frontend      │
│  (Alpine.js)    │
│  - UI/UX        │
│  - Validación   │
│    básica       │
└────────┬────────┘
         │ AJAX
         ▼
┌─────────────────┐
│   Backend       │
│  (Laravel)      │
│  - Validación   │
│  - Cálculos     │
│  - Lógica       │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   Config        │
│  products.php   │
│  - Productos    │
│  - Tarifas      │
│  - Impuestos    │
└─────────────────┘
```

### Principios de Diseño

- **Separación de Responsabilidades**: Lógica de negocio en PHP, presentación en JavaScript
- **Single Source of Truth**: Datos centralizados en `config/products.php`
- **Reutilización**: Helper reutilizable para cálculos
- **Seguridad**: Validación en backend, CSRF protection
- **Mantenibilidad**: Código modular y documentado

---

## 📁 Estructura de Archivos

```
web_fri_pro/
├── config/
│   └── products.php                    # Configuración de productos, tarifas e impuestos
│
├── app/
│   ├── Helpers/
│   │   └── CotizadorHelper.php        # Funciones de cálculo y validación
│   │
│   └── Http/
│       └── Controllers/
│           └── CotizadorController.php # Controlador API
│
├── resources/
│   ├── views/
│   │   └── cotizador.blade.php        # Vista principal con Alpine.js
│   │
│   └── js/
│       └── cotizador-alpine.js         # Lógica frontend (opcional, mínima)
│
└── routes/
    └── web.php                         # Rutas del cotizador
```

---

## ⚙️ Configuración de Productos

### Ubicación
`config/products.php`

### Estructura

El archivo contiene 4 secciones principales:

#### 1. Productos (`products`)

```php
'products' => [
    'NombreDelProducto' => [
        'adValorem' => 0.30,           // Impuesto ad-valorem (30%)
        'arancelEspecifico' => 0.0     // Arancel específico en USD
    ],
    // ... más de 100 productos
]
```

**Categorías por Ad-Valorem:**
- **30%**: Cocinas, electrodomésticos, juguetes, bicicletas eléctricas
- **25%**: Kits eléctricos, bisutería, audífonos, máquinas de coser
- **20%**: Refrigeradoras, proyectores, cine en casa, DVR
- **15%**: Lavadoras, celulares, tablets, computadoras, cámaras
- **10%**: Repuestos autos, bicicletas, equipos electrónicos
- **5%**: Impresoras, herramientas, drones, televisores (con arancel específico)
- **4%**: Gafas VR, herramientas de mano

#### 2. Tarifas de Envío (`shipping_rates`)

```php
'shipping_rates' => [
    'maritimo' => [
        [peso_min, peso_max, costo_por_libra],
        [10, 99, 4.0],
        [100, 199, 3.75],
        // ...
        [2001, null, 1.25],  // null = sin límite superior
    ],
    'aereo' => [
        [1, 1, 19.8],        // Caso especial: costo total, se divide por peso
        [2, 2, 11.54],
        // ...
        [500, null, 3.42],
    ],
    'aereoExpres' => [
        [50, 99, 12.16],
        [100, 149, 8.03],
        [150, 199, 6.02],
        [200, null, 5.3],
    ],
]
```

**Formato de Rangos:**
- `[min, max, costo]`: Rango con límites definidos
- `[min, null, costo]`: Rango sin límite superior (hasta infinito)

#### 3. Impuestos Fijos (`taxes`)

```php
'taxes' => [
    'fodinfa' => 0.005,      // 0.5%
    'iva' => 0.12,           // 12%
    'seguro_cif' => 0.025,   // 2.5%
]
```

#### 4. Validaciones (`validations`)

```php
'validations' => [
    'maritimo_min_weight' => 100,      // Peso mínimo marítimo
    'aereoExpres_min_weight' => 50,    // Peso mínimo aéreo express
    'aereoExpres_max_weight' => 200,    // Peso máximo aéreo express
    'prendas_max_weight' => 8,          // Peso máximo prendas
]
```

### Uso en el Código

```php
// Obtener productos
$products = config('products.products');

// Obtener tarifas
$rates = config('products.shipping_rates.maritimo');

// Obtener impuestos
$iva = config('products.taxes.iva');

// Obtener validaciones
$minWeight = config('products.validations.maritimo_min_weight');
```

---

## 🔧 Helper de Cotización

### Ubicación
`app/Helpers/CotizadorHelper.php`

### Funciones Disponibles

#### 1. `formatProductName(string $key): string`

Formatea el nombre del producto para mostrar de forma legible.

**Parámetros:**
- `$key`: Clave del producto (ej: `CocinasDeInduccion_Gas_Horno`)

**Retorna:**
- String formateado (ej: `Cocinas De Inducción/Gas Horno`)

**Ejemplo:**
```php
$formatted = CotizadorHelper::formatProductName('CocinasDeInduccion_Gas_Horno');
// Retorna: "Cocinas De Inducción/Gas Horno"
```

**Transformaciones:**
- Agrega espacios entre letras y números
- Agrega espacios entre minúsculas y mayúsculas
- Reemplaza `_` con `/`
- Reemplaza `PTHO` con `(`
- Reemplaza `PTHC` con `)`
- Reemplaza `EXS` con espacio

#### 2. `calculateCostPerPound(string $method, float $weight): float`

Calcula el costo por libra según el método de envío y peso total.

**Parámetros:**
- `$method`: Método de envío (`maritimo`, `aereo`, `aereoExpres`)
- `$weight`: Peso total en libras

**Retorna:**
- Costo por libra (float)

**Lanza:**
- `\Exception` si el método no existe
- `\Exception` si no se encuentra tarifa para el peso

**Ejemplo:**
```php
$cost = CotizadorHelper::calculateCostPerPound('maritimo', 150);
// Retorna: 3.75 (costo por libra para 150 lbs en marítimo)
```

**Lógica:**
1. Obtiene tarifas del método desde config
2. Ordena rangos por peso mínimo (ascendente)
3. Busca el rango que contiene el peso
4. Maneja casos especiales (aéreo peso 1)
5. Retorna costo por libra

#### 3. `calculateQuote(array $data): array`

Calcula todos los costos de la cotización.

**Parámetros:**
```php
[
    'product' => 'NombreDelProducto',
    'quantity' => 2.0,
    'weight' => 10.5,        // Peso unitario en libras
    'unitValue' => 100.0,    // Valor unitario en USD
    'shippingMethod' => 'maritimo'
]
```

**Retorna:**
```php
[
    'product' => 'NombreDelProducto',
    'quantity' => 2.0,
    'weight' => 21.0,                    // Peso total
    'productCost' => 200.0,              // Valor total del producto
    'shippingCost' => 78.75,             // Costo de envío
    'impuestoAdvalorem' => 60.0,         // Impuesto ad-valorem
    'impuestoFodinfa' => 1.0,            // Fodinfa
    'impuestoIva' => 31.32,              // IVA
    'arancelEspecifico' => 0.0,          // Arancel específico
    'totalImpuestos' => 92.32,           // Total impuestos
    'seguroCIF' => 6.97,                 // Seguro CIF
    'totalCotizacion' => 378.04,         // Total con seguro
    'adValorem' => 0.3,                  // Porcentaje ad-valorem
    'fodinfa' => 0.005,                  // Porcentaje fodinfa
    'iva' => 0.12,                       // Porcentaje IVA
]
```

**Lanza:**
- `\Exception` si el producto no existe

**Ejemplo:**
```php
$data = [
    'product' => 'Laptos',
    'quantity' => 1,
    'weight' => 5.0,
    'unitValue' => 800.0,
    'shippingMethod' => 'aereo'
];

$quote = CotizadorHelper::calculateQuote($data);
```

**Lógica de Cálculo:**

1. **Validación de Producto**
   ```php
   $product = config('products.products.' . $data['product']);
   ```

2. **Cálculo de Valores Base**
   ```php
   $totalWeight = $unitWeight * $quantity;
   $productCost = $unitValue * $quantity;
   ```

3. **Cálculo de Envío**
   ```php
   $costPerPound = calculateCostPerPound($shippingMethod, $totalWeight);
   $shippingCost = $costPerPound * $totalWeight;
   ```

4. **Cálculo de Impuestos** (con lógica especial para aéreo)
   ```php
   if ($shippingMethod === 'aereo' && $totalWeight >= 1 && $totalWeight <= 8) {
       // Sin impuestos
   } elseif ($shippingMethod === 'aereo' && $productCost <= 400) {
       // Impuestos reducidos
   } else {
       // Impuestos completos
   }
   ```

5. **Cálculo de Seguro CIF**
   ```php
   $seguroCIF = ($productCost + $shippingCost) * 0.025;
   ```

6. **Total Final**
   ```php
   $totalCotizacion = $productCost + $shippingCost + $totalImpuestos + $seguroCIF;
   ```

#### 4. `validate(array $data): array`

Valida los datos del formulario según reglas de negocio.

**Parámetros:**
```php
[
    'product' => 'NombreDelProducto',
    'quantity' => 2.0,
    'weight' => 10.5,
    'unitValue' => 100.0,
    'shippingMethod' => 'maritimo'
]
```

**Retorna:**
- Array de errores (vacío si no hay errores)

**Validaciones Realizadas:**

1. **Producto válido**
   ```php
   if (empty($data['product']) || $data['product'] === 'selectProducto')
   ```

2. **Método de envío válido**
   ```php
   if (empty($data['shippingMethod']) || $data['shippingMethod'] === 'selectMetodo')
   ```

3. **Valores numéricos válidos**
   ```php
   if ($quantity <= 0 || $weight <= 0 || $unitValue <= 0)
   ```

4. **Peso mínimo marítimo**
   ```php
   if ($shippingMethod === 'maritimo' && $totalWeight < 100)
   ```

5. **Peso mínimo/máximo aéreo express**
   ```php
   if ($shippingMethod === 'aereoExpres') {
       if ($totalWeight < 50) // Mínimo
       if ($totalWeight > 200) // Máximo
   }
   ```

6. **Peso máximo prendas**
   ```php
   if ($product === 'PrendasDeVestirYCalzado' && $totalWeight > 8)
   ```

**Ejemplo:**
```php
$errors = CotizadorHelper::validate($data);
if (!empty($errors)) {
    // Mostrar errores
    foreach ($errors as $error) {
        echo $error;
    }
}
```

---

## 🎮 Controlador API

### Ubicación
`app/Http/Controllers/CotizadorController.php`

### Métodos

#### 1. `index()`

Muestra la página del cotizador.

**Ruta:** `GET /cotizador`

**Retorna:**
- Vista `cotizador.blade.php`

#### 2. `calculate(Request $request): JsonResponse`

Calcula la cotización y retorna resultado en JSON.

**Ruta:** `POST /api/cotizador/calculate`

**Validación Laravel:**
```php
$data = $request->validate([
    'product' => 'required|string',
    'quantity' => 'required|numeric|min:0.01',
    'weight' => 'required|numeric|min:0.01',
    'unitValue' => 'required|numeric|min:0.01',
    'shippingMethod' => 'required|string|in:maritimo,aereo,aereoExpres',
]);
```

**Flujo:**
1. Valida datos con Laravel
2. Valida reglas de negocio con `CotizadorHelper::validate()`
3. Calcula cotización con `CotizadorHelper::calculateQuote()`
4. Formatea nombre del producto
5. Retorna JSON

**Respuesta Exitosa:**
```json
{
    "success": true,
    "data": {
        "product": "Laptos",
        "productName": "Laptos",
        "quantity": 1,
        "weight": 5.0,
        "productCost": 800.0,
        "shippingCost": 29.3,
        "impuestoAdvalorem": 240.0,
        "impuestoFodinfa": 4.0,
        "impuestoIva": 125.28,
        "arancelEspecifico": 0.0,
        "totalImpuestos": 369.28,
        "seguroCIF": 20.73,
        "totalCotizacion": 1219.31,
        "adValorem": 0.3,
        "fodinfa": 0.005,
        "iva": 0.12
    }
}
```

**Respuesta con Errores:**
```json
{
    "success": false,
    "errors": [
        "Para envío marítimo, el peso mínimo es de 100 libras."
    ],
    "message": "Para envío marítimo, el peso mínimo es de 100 libras."
}
```

**Códigos HTTP:**
- `200`: Éxito
- `422`: Errores de validación
- `500`: Error del servidor

#### 3. `getProducts(): JsonResponse`

Obtiene lista de productos formateados.

**Ruta:** `GET /api/cotizador/products`

**Retorna:**
```json
{
    "success": true,
    "data": [
        {
            "key": "Laptos",
            "name": "Laptos",
            "adValorem": 0.3,
            "arancelEspecifico": 0.0
        },
        // ... más productos
    ]
}
```

---

## 🎨 Frontend (Alpine.js)

### Ubicación
`resources/views/cotizador.blade.php`

### Estructura del Componente

```javascript
function cotizadorData() {
    return {
        // Datos
        products: @json(config('products.products')),
        shippingRates: @json(config('products.shipping_rates')),
        
        // Estado del formulario
        formData: {
            product: '',
            quantity: 1,
            weight: 0,
            unitValue: 0,
            shippingMethod: ''
        },
        
        // Estado de la UI
        searchProduct: '',
        showProductDropdown: false,
        filteredProducts: [],
        selectedProductName: '',
        showResult: false,
        result: null,
        showAlert: false,
        alertMessage: '',
        isCalculating: false,
        
        // Métodos...
    }
}
```

### Métodos Principales

#### 1. `init()`

Inicializa el componente.

**Acciones:**
- Carga lista de productos
- Configura listener para cerrar dropdown

#### 2. `getAllProducts()`

Obtiene todos los productos formateados.

**Retorna:**
```javascript
[
    { key: 'Laptos', name: 'Laptos' },
    { key: 'Tablets', name: 'Tablets' },
    // ...
]
```

#### 3. `filterProducts()`

Filtra productos según búsqueda.

**Uso:**
```javascript
// Se ejecuta automáticamente con @input="filterProducts()"
```

#### 4. `selectProduct(product)`

Selecciona un producto del dropdown.

**Parámetros:**
- `product`: Objeto `{ key: string, name: string }`

#### 5. `formatProductName(key)`

Formatea nombre del producto (igual que Helper PHP).

#### 6. `validate(): boolean`

Valida datos en frontend (validación básica).

**Retorna:**
- `true` si válido
- `false` si inválido (muestra error)

#### 7. `async calculate()`

Calcula cotización enviando datos al backend.

**Flujo:**
1. Valida datos localmente
2. Muestra indicador de carga
3. Envía petición AJAX al backend
4. Procesa respuesta
5. Muestra resultado o errores

**Código:**
```javascript
async calculate() {
    if (!this.validate()) return;
    
    this.isCalculating = true;
    
    try {
        const response = await fetch('{{ route("cotizador.calculate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify(this.formData)
        });
        
        const data = await response.json();
        
        if (!response.ok || !data.success) {
            this.showError(data.message || data.errors?.[0]);
            return;
        }
        
        this.result = data.data;
        this.showResult = true;
        
    } catch (error) {
        this.showError('Error de conexión. Por favor intente nuevamente.');
    } finally {
        this.isCalculating = false;
    }
}
```

#### 8. `downloadPDF()`

Genera y descarga PDF de la cotización.

**Usa:** jsPDF

#### 9. `reset()`

Limpia el formulario y resultados.

#### 10. `showError(message)`

Muestra mensaje de error en overlay.

---

## 🔄 Flujo de Datos

### Flujo Completo de Cotización

```
1. Usuario completa formulario
   │
   ▼
2. Frontend valida campos básicos (Alpine.js)
   │
   ▼
3. Usuario hace clic en "Calcular Cotización"
   │
   ▼
4. Frontend envía petición AJAX
   POST /api/cotizador/calculate
   {
       product: "Laptos",
       quantity: 1,
       weight: 5.0,
       unitValue: 800.0,
       shippingMethod: "aereo"
   }
   │
   ▼
5. Backend valida datos (Laravel Validation)
   │
   ▼
6. Backend valida reglas de negocio
   CotizadorHelper::validate()
   │
   ▼
7. Backend calcula cotización
   CotizadorHelper::calculateQuote()
   │
   ├─► Obtiene producto de config
   ├─► Calcula peso total
   ├─► Calcula costo producto
   ├─► Calcula costo envío
   │   └─► calculateCostPerPound()
   ├─► Calcula impuestos
   ├─► Calcula seguro CIF
   └─► Calcula total
   │
   ▼
8. Backend retorna JSON
   {
       success: true,
       data: { ... }
   }
   │
   ▼
9. Frontend procesa respuesta
   │
   ├─► Si éxito: muestra resultado
   └─► Si error: muestra mensaje
   │
   ▼
10. Usuario puede descargar PDF
```

---

## ✅ Validaciones

### Validaciones Frontend (Alpine.js)

Validaciones básicas para UX inmediata:

- Producto seleccionado
- Método de envío seleccionado
- Valores numéricos > 0
- Peso mínimo marítimo (100 lbs)
- Peso mínimo/máximo aéreo express (50-200 lbs)
- Peso máximo prendas (8 lbs)

### Validaciones Backend (Laravel + Helper)

Validaciones completas y seguras:

1. **Laravel Validation**
   ```php
   'quantity' => 'required|numeric|min:0.01',
   'weight' => 'required|numeric|min:0.01',
   'unitValue' => 'required|numeric|min:0.01',
   'shippingMethod' => 'required|string|in:maritimo,aereo,aereoExpres',
   ```

2. **Validaciones de Negocio** (`CotizadorHelper::validate()`)
   - Producto existe en config
   - Método de envío válido
   - Valores numéricos válidos
   - Reglas de peso según método
   - Reglas especiales por producto

---

## 💰 Cálculos de Impuestos

### Fórmulas

#### 1. Ad-Valorem
```
Impuesto Ad-Valorem = Valor Producto × Ad-Valorem%
```

#### 2. Fodinfa
```
Fodinfa = Valor Producto × 0.5%
```

#### 3. IVA
```
IVA = (Valor Producto + Ad-Valorem + Fodinfa) × 12%
```

#### 4. Arancel Específico
```
Arancel Específico = Valor fijo según producto (mayormente $0.00)
```

#### 5. Total Impuestos
```
Total Impuestos = Ad-Valorem + Fodinfa + IVA + Arancel Específico
```

#### 6. Seguro CIF
```
Seguro CIF = (Valor Producto + Costo Envío) × 2.5%
```

#### 7. Total Cotización
```
Total = Valor Producto + Costo Envío + Total Impuestos + Seguro CIF
```

### Casos Especiales

#### Aéreo Peso 1-8 lbs
```php
if ($shippingMethod === 'aereo' && $totalWeight >= 1 && $totalWeight <= 8) {
    // Sin impuestos
    $impuestoAdvalorem = 0;
    $impuestoFodinfa = 0;
    $impuestoIva = 0;
}
```

#### Aéreo Valor ≤ $400
```php
if ($shippingMethod === 'aereo' && $productCost <= 400) {
    // Impuestos normales pero con validación especial
    $impuestoAdvalorem = $productCost * $adValorem;
    $impuestoFodinfa = $productCost * $fodinfa;
    $impuestoIva = ($productCost + $impuestoAdvalorem + $impuestoFodinfa) * $iva;
}
```

---

## 🚢 Tarifas de Envío

### Método: Marítimo

**Peso Mínimo:** 100 libras

| Peso (lbs) | Costo por Libra |
|------------|-----------------|
| 10-99 | $4.00 |
| 100-199 | $3.75 |
| 200-299 | $3.50 |
| 300-399 | $3.25 |
| 400-499 | $3.00 |
| 500-599 | $2.75 |
| 600-699 | $2.55 |
| 700-799 | $2.35 |
| 800-899 | $2.30 |
| 900-1200 | $2.25 |
| 1200-1500 | $1.40 |
| 1501-2000 | $1.30 |
| 2001+ | $1.25 |

### Método: Aéreo

**Peso Mínimo:** 1 libra (sin mínimo)

| Peso (lbs) | Costo por Libra |
|------------|-----------------|
| 1 | $19.80 (costo total) |
| 2 | $11.54 |
| 3 | $9.80 |
| 4 | $8.24 |
| 5 | $7.52 |
| 6 | $7.23 |
| 7 | $6.95 |
| 8 | $6.75 |
| 9 | $6.63 |
| 10-19 | $5.86 |
| 20-29 | $5.40 |
| 30-39 | $5.21 |
| 40-49 | $5.13 |
| 50-59 | $5.08 |
| 60-69 | $4.95 |
| 70-79 | $4.95 |
| 80-99 | $3.67 |
| 100-139 | $3.60 |
| 140-149 | $3.55 |
| 150-199 | $3.55 |
| 200-279 | $3.49 |
| 280-499 | $3.45 |
| 500+ | $3.42 |

### Método: Aéreo Express

**Peso Mínimo:** 50 libras  
**Peso Máximo:** 200 libras

| Peso (lbs) | Costo por Libra |
|------------|-----------------|
| 50-99 | $12.16 |
| 100-149 | $8.03 |
| 150-199 | $6.02 |
| 200+ | $5.30 |

---

## 📝 Ejemplos de Uso

### Ejemplo 1: Cotización Básica

**Datos:**
- Producto: Laptos
- Cantidad: 1
- Peso unitario: 5 lbs
- Valor unitario: $800 USD
- Método: Aéreo

**Cálculo:**
```php
$data = [
    'product' => 'Laptos',
    'quantity' => 1,
    'weight' => 5.0,
    'unitValue' => 800.0,
    'shippingMethod' => 'aereo'
];

$quote = CotizadorHelper::calculateQuote($data);
```

**Resultado:**
- Peso total: 5 lbs
- Valor producto: $800.00
- Costo envío: $29.30 (5.86 × 5)
- Ad-Valorem (30%): $240.00
- Fodinfa (0.5%): $4.00
- IVA (12%): $125.28
- Seguro CIF: $20.73
- **Total: $1,219.31**

### Ejemplo 2: Cotización Marítima

**Datos:**
- Producto: Refrigeradora
- Cantidad: 2
- Peso unitario: 150 lbs
- Valor unitario: $600 USD
- Método: Marítimo

**Cálculo:**
```php
$data = [
    'product' => 'Refrigeradora',
    'quantity' => 2,
    'weight' => 150.0,
    'unitValue' => 600.0,
    'shippingMethod' => 'maritimo'
];

$quote = CotizadorHelper::calculateQuote($data);
```

**Resultado:**
- Peso total: 300 lbs
- Valor producto: $1,200.00
- Costo envío: $975.00 (3.25 × 300)
- Ad-Valorem (20%): $240.00
- Fodinfa (0.5%): $6.00
- IVA (12%): $173.52
- Seguro CIF: $54.38
- **Total: $2,648.90**

### Ejemplo 3: Uso desde Frontend

```javascript
// En Alpine.js
async calculate() {
    const response = await fetch('/api/cotizador/calculate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product: 'Laptos',
            quantity: 1,
            weight: 5.0,
            unitValue: 800.0,
            shippingMethod: 'aereo'
        })
    });
    
    const data = await response.json();
    console.log(data);
}
```

### Ejemplo 4: Validación Manual

```php
$data = [
    'product' => 'Laptos',
    'quantity' => 1,
    'weight' => 5.0,
    'unitValue' => 800.0,
    'shippingMethod' => 'maritimo'  // Error: peso mínimo 100 lbs
];

$errors = CotizadorHelper::validate($data);
// Retorna: ["Para envío marítimo, el peso mínimo es de 100 libras."]
```

---

## 🔐 Seguridad

### CSRF Protection

Todas las peticiones POST incluyen token CSRF:

```javascript
headers: {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
}
```

### Validación en Backend

- Validación Laravel (tipo, formato)
- Validación de negocio (reglas específicas)
- Sanitización de datos
- Manejo de excepciones

### Rate Limiting

Considerar agregar rate limiting para prevenir abuso:

```php
Route::middleware('throttle:10,1')->group(function () {
    Route::post('/api/cotizador/calculate', ...);
});
```

---

## 🧪 Testing

### Probar Helper Directamente

```php
use App\Helpers\CotizadorHelper;

// Test formato de nombre
$formatted = CotizadorHelper::formatProductName('CocinasDeInduccion_Gas_Horno');
assert($formatted === 'Cocinas De Inducción/Gas Horno');

// Test cálculo de costo
$cost = CotizadorHelper::calculateCostPerPound('maritimo', 150);
assert($cost === 3.75);

// Test cotización completa
$data = [...];
$quote = CotizadorHelper::calculateQuote($data);
assert(isset($quote['totalCotizacion']));
```

### Probar API Endpoint

```bash
curl -X POST http://localhost:8000/api/cotizador/calculate \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: token" \
  -d '{
    "product": "Laptos",
    "quantity": 1,
    "weight": 5.0,
    "unitValue": 800.0,
    "shippingMethod": "aereo"
  }'
```

---

## 📊 Estructura de Respuesta JSON

### Respuesta Exitosa

```json
{
    "success": true,
    "data": {
        "product": "Laptos",
        "productName": "Laptos",
        "quantity": 1.0,
        "weight": 5.0,
        "productCost": 800.0,
        "shippingCost": 29.3,
        "impuestoAdvalorem": 240.0,
        "impuestoFodinfa": 4.0,
        "impuestoIva": 125.28,
        "arancelEspecifico": 0.0,
        "totalImpuestos": 369.28,
        "seguroCIF": 20.73,
        "totalCotizacion": 1219.31,
        "adValorem": 0.3,
        "fodinfa": 0.005,
        "iva": 0.12
    }
}
```

### Respuesta con Errores

```json
{
    "success": false,
    "errors": [
        "Para envío marítimo, el peso mínimo es de 100 libras."
    ],
    "message": "Para envío marítimo, el peso mínimo es de 100 libras."
}
```

---

## 🚀 Mejoras Futuras

### Posibles Mejoras

1. **Base de Datos**
   - Migrar productos a tabla `products`
   - Migrar tarifas a tabla `shipping_rates`
   - Crear modelos Eloquent

2. **Caché**
   - Cachear configuración de productos
   - Cachear resultados de cotizaciones frecuentes

3. **Historial**
   - Guardar cotizaciones en base de datos
   - Permitir reutilizar cotizaciones anteriores

4. **Exportación**
   - Mejorar generación de PDF
   - Agregar exportación a Excel
   - Agregar exportación a CSV

5. **Notificaciones**
   - Enviar cotización por email
   - Notificaciones push

6. **Analytics**
   - Tracking de cotizaciones
   - Estadísticas de productos más cotizados

---

## 📚 Referencias

- **Configuración:** `config/products.php`
- **Helper:** `app/Helpers/CotizadorHelper.php`
- **Controlador:** `app/Http/Controllers/CotizadorController.php`
- **Vista:** `resources/views/cotizador.blade.php`
- **Rutas:** `routes/web.php`

---

## ✅ Checklist de Implementación

- [x] Archivo de configuración `config/products.php`
- [x] Helper `CotizadorHelper` con todas las funciones
- [x] Controlador API `CotizadorController`
- [x] Rutas API configuradas
- [x] Vista con Alpine.js
- [x] Validaciones frontend y backend
- [x] Cálculos de impuestos
- [x] Tarifas de envío
- [x] Generación de PDF
- [x] Manejo de errores
- [x] CSRF protection
- [x] Documentación completa

---

**Última actualización:** 2024-12-19

