# Diseño Multi-País — Escalabilidad futura

**Fase 5.4** — Documento de diseño para soporte multi-país

---

## Estado actual

El sistema está diseñado para **Ecuador únicamente**:
- Impuestos: Fodinfa, IVA, Seguro CIF (tasas ecuatorianas)
- Productos: Códigos arancelarios Ecuador
- Tarifas de envío: Configuradas para Ecuador

---

## Objetivo

Permitir escalar a:
- **Colombia**
- **Perú**
- **México**
- Otros países de la región

---

## Estructura propuesta

### 1. Tabla `countries`

```sql
CREATE TABLE countries (
    id BIGINT PRIMARY KEY,
    code VARCHAR(3) UNIQUE NOT NULL,  -- EC, CO, PE, MX
    name VARCHAR(100) NOT NULL,
    currency_code VARCHAR(3) DEFAULT 'USD',
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### 2. Tabla `tax_rules` (reemplazar o extender `tax_rates`)

```sql
CREATE TABLE tax_rules (
    id BIGINT PRIMARY KEY,
    country_id BIGINT NOT NULL,
    name VARCHAR(50) NOT NULL,  -- fodinfa, iva, seguro_cif
    rate DECIMAL(8,4) NOT NULL,
    description TEXT,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE(country_id, name)
);
```

### 3. Tabla `shipping_rules` (extender `shipping_rates`)

Agregar columna `country_id` a `shipping_rates`:

```sql
ALTER TABLE shipping_rates ADD COLUMN country_id BIGINT NULL;
-- NULL = aplica a todos (compatibilidad)
```

### 4. Tabla `products` (extender)

Agregar soporte por país para ad-valorem y arancel:

```sql
-- Opción A: product_country_rates (más flexible)
CREATE TABLE product_country_rates (
    id BIGINT PRIMARY KEY,
    product_id BIGINT NOT NULL,
    country_id BIGINT NOT NULL,
    ad_valorem DECIMAL(8,4) NOT NULL,
    arancel_especifico DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE(product_id, country_id)
);

-- Opción B: Agregar country_id a products (más simple)
ALTER TABLE products ADD COLUMN country_id BIGINT NULL;
```

### 5. Tabla `quotes` (actual)

Ya tiene los campos necesarios. Agregar:

```sql
ALTER TABLE quotes ADD COLUMN country_id BIGINT NULL;
```

---

## Flujo de cotización multi-país

1. Usuario selecciona país (o se detecta por IP/geolocalización)
2. Se cargan `tax_rules` y `shipping_rates` para ese país
3. Se cargan productos con `product_country_rates` para ese país
4. El cálculo usa las reglas del país seleccionado

---

## Migración gradual

1. **Fase 1:** Crear tabla `countries`, seed con Ecuador
2. **Fase 2:** Crear `tax_rules`, migrar datos de `tax_rates`
3. **Fase 3:** Agregar `country_id` a `shipping_rates`
4. **Fase 4:** Crear `product_country_rates` o extender `products`
5. **Fase 5:** Actualizar CotizadorController y servicios para filtrar por país

---

## Consideraciones

- **Locale:** Cada país puede tener idioma y formato de moneda diferente
- **Validaciones:** Límites de peso, valor FOB pueden variar por país
- **Courier 4x4:** Es específico de Ecuador; otros países tendrán regímenes distintos
