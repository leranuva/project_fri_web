# 📦 Migración de Base de Datos de Productos a Laravel

Este documento describe la migración completa de la lógica de productos desde JavaScript al backend de Laravel.

## ✅ Archivo de Configuración Creado

### `config/products.php`

Este archivo centraliza toda la información de productos, tarifas e impuestos en un formato estructurado y mantenible.

#### Estructura del Archivo

```php
return [
    // 1. PRODUCTOS Y SUS IMPUESTOS
    'products' => [
        'NombreDelProducto' => [
            'adValorem' => 0.30,        // Impuesto ad-valorem (30%)
            'arancelEspecifico' => 0.0  // Arancel específico en USD
        ],
        // ... más de 100 productos
    ],

    // 2. TARIFAS DE ENVÍO
    'shipping_rates' => [
        'maritimo' => [
            [peso_min, peso_max, costo_por_libra],
            // ... rangos de peso
        ],
        'aereo' => [...],
        'aereoExpres' => [...]
    ],

    // 3. IMPUESTOS FIJOS
    'taxes' => [
        'fodinfa' => 0.005,      // 0.5%
        'iva' => 0.12,           // 12%
        'seguro_cif' => 0.025    // 2.5%
    ],

    // 4. VALIDACIONES
    'validations' => [
        'maritimo_min_weight' => 100,
        'aereoExpres_min_weight' => 50,
        'aereoExpres_max_weight' => 200,
        'prendas_max_weight' => 8
    ]
];
```

## 📊 Categorías de Productos por Ad-Valorem

### Ad-Valorem 30%
- Cocinas de inducción, hornos, extractores
- Juguetes y accesorios para bebé
- Electrodomésticos de cocina
- Bicicletas eléctricas
- Y más...

### Ad-Valorem 25%
- Kit eléctrico para bicicleta
- Bisutería, relojes, joyas
- Audífonos gamer y AirPods
- Máquinas de coser
- Smart toilets

### Ad-Valorem 20%
- Refrigeradoras
- Proyectores de imagen
- Cine en casa
- Equipos de grabación
- DVR para cámaras de seguridad

### Ad-Valorem 15%
- Lavadoras y secadoras
- Celulares nuevos
- Tablets y computadoras
- Cámaras de video y seguridad
- Aspiradoras robóticas

### Ad-Valorem 10%
- Repuestos eléctricos para autos
- Bicicletas
- Equipos electrónicos
- Amplificadores y parlantes
- Sound bars

### Ad-Valorem 5%
- Máquinas para hacer helados
- Impresoras
- Herramientas
- Drones
- Televisores (con arancel específico según tamaño)

### Ad-Valorem 4%
- Gafas de realidad virtual
- Herramientas de mano

## 🚢 Tarifas de Envío

### Marítimo
- Peso mínimo: 100 libras
- Rangos desde 10-99 lbs hasta 2001+ lbs
- Costos por libra desde $4.00 hasta $1.25

### Aéreo
- Sin peso mínimo
- Rangos desde 1 lb hasta 500+ lbs
- Costos por libra desde $19.80 hasta $3.42

### Aéreo Express
- Peso mínimo: 50 libras
- Peso máximo: 200 libras
- Rangos desde 50-99 lbs hasta 200+ lbs
- Costos por libra desde $12.16 hasta $5.30

## 💰 Impuestos Aplicados

1. **Ad-Valorem**: Variable según producto (4% - 30%)
2. **Fodinfa**: 0.5% fijo sobre el valor del producto
3. **IVA**: 12% sobre (valor producto + ad-valorem + fodinfa)
4. **Arancel Específico**: Variable según producto (mayormente $0.00, excepto televisores)
5. **Seguro CIF**: 2.5% sobre (valor producto + costo envío)

## 🔧 Uso en el Código

### En Blade Templates
```php
@php
    $products = config('products.products');
    $shippingRates = config('products.shipping_rates');
@endphp
```

### En Helpers PHP
```php
use App\Helpers\CotizadorHelper;

$product = config('products.products.' . $productKey);
$quote = CotizadorHelper::calculateQuote($data);
```

### En Alpine.js (Frontend)
```javascript
products: @json(config('products.products')),
shippingRates: @json(config('products.shipping_rates'))
```

## 📝 Ventajas de esta Estructura

1. **Centralización**: Todos los datos en un solo lugar
2. **Mantenibilidad**: Fácil de actualizar y modificar
3. **Escalabilidad**: Preparado para migrar a base de datos
4. **Type Safety**: Estructura consistente y predecible
5. **Documentación**: Comentarios claros en el código
6. **Versionado**: Cambios rastreables con Git

## 🔄 Próximos Pasos (Opcional)

Para una solución más robusta, se puede migrar a base de datos:

1. Crear migraciones para tablas:
   - `products`
   - `shipping_rates`
   - `tax_rates`

2. Crear modelos Eloquent:
   - `Product`
   - `ShippingRate`
   - `TaxRate`

3. Crear seeders para poblar datos iniciales

4. Actualizar el Helper para usar modelos en lugar de config

## 📍 Ubicación de Archivos

- **Configuración**: `config/products.php`
- **Helper**: `app/Helpers/CotizadorHelper.php`
- **Vista**: `resources/views/cotizador.blade.php`
- **JavaScript**: `resources/js/cotizador-alpine.js`

