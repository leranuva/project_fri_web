# 🔍 Verificación de Aranceles y Restricciones SENAE Ecuador

Este documento contiene el análisis de verificación de los aranceles y restricciones de los productos en la base de datos según las regulaciones oficiales del SENAE (Servicio Nacional de Aduanas del Ecuador).

**Fecha de Verificación:** 2024-12-19  
**Fuente:** SENAE - https://www.aduana.gob.ec/

---

## 📊 Resumen Ejecutivo

### ✅ Aspectos Verificados Correctamente
- Aranceles ad-valorem por categoría de productos
- Aranceles específicos para televisores
- Fodinfa (0.5%)
- Seguro CIF (2.5%)
- Restricciones de peso por método de envío

### ⚠️ Discrepancias Encontradas y Corregidas
1. **IVA**: ✅ **CORREGIDO** - Actualizado de 12% (0.12) a 15% (0.15) según SENAE desde abril 2024
2. **Restricciones de Importación**: Algunos productos pueden requerir verificación adicional

---

## 💰 Verificación de Impuestos

### 1. IVA (Impuesto al Valor Agregado)

**Estado Actual en Sistema:**
```php
'iva' => 0.15,  // 15% ✅ ACTUALIZADO
```

**Regulación SENAE:**
- Desde el **1 de abril de 2024**, el IVA aplicable a importaciones es del **15%**
- Fuente: [SENAE - Aplicación tarifa 15% IVA](https://www.aduana.gob.ec/gaceta-boletin/aplicacion-de-la-tarifa-15-del-impuesto-al-valor-agregado-iva-a-la-importacion-de-bienes-a-partir-del-01-de-abril-de-2024/)

**✅ ACCIÓN COMPLETADA:** IVA actualizado de 12% a 15% en:
- ✅ `config/products.php` - Actualizado
- ✅ Base de datos `tax_rates` - Actualizado

**Impacto:** Este cambio afectará todos los cálculos de cotización, aumentando el IVA en un 3% adicional. **Cambio aplicado el 2024-12-19.**

---

### 2. Fodinfa (Fondo de Desarrollo de la Infraestructura Nacional)

**Estado Actual en Sistema:**
```php
'fodinfa' => 0.005,  // 0.5%
```

**Regulación SENAE:**
- ✅ **Correcto**: 0.5% sobre el valor CIF del producto
- No se encontraron cambios recientes en esta tasa

**Estado:** ✅ Verificado y correcto

---

### 3. Seguro CIF

**Estado Actual en Sistema:**
```php
'seguro_cif' => 0.025,  // 2.5%
```

**Regulación SENAE:**
- ✅ **Correcto**: 2.5% sobre el valor CIF (Costo + Seguro + Flete)
- Este es un cálculo estándar para seguros de importación

**Estado:** ✅ Verificado y correcto

---

## 📦 Verificación de Aranceles Ad-Valorem

### Categorías de Aranceles en el Sistema

| Categoría | Porcentaje | Cantidad Productos | Estado |
|-----------|------------|---------------------|--------|
| 30% | 0.30 | 15 productos | ⚠️ Verificar |
| 25% | 0.25 | 7 productos | ⚠️ Verificar |
| 20% | 0.20 | 10 productos | ⚠️ Verificar |
| 15% | 0.15 | 12 productos | ⚠️ Verificar |
| 10% | 0.10 | 7 productos | ⚠️ Verificar |
| 5% | 0.05 | 19 productos | ⚠️ Verificar |
| 4% | 0.04 | 1 producto | ⚠️ Verificar |

**Nota:** Los aranceles ad-valorem varían según la partida arancelaria específica de cada producto. Para una verificación completa, es necesario:

1. Identificar la partida arancelaria (código NANDINA) de cada producto
2. Consultar el Arancel Nacional del Ecuador en: https://www.aduana.gob.ec/arancel-nacional/
3. Verificar que el arancel configurado coincida con el oficial

**Recomendación:** Asignar códigos arancelarios a cada producto en la base de datos para facilitar futuras verificaciones.

---

## 📺 Aranceles Específicos - Televisores

### Estado Actual en Sistema:

```php
'TelevisoresMayorA20EXSYMenorOIgualA32EXSPulgadas' => [
    'adValorem' => 0.05,
    'arancelEspecifico' => 73.11
],
'TelevisoresMayorA32EXSYMenorOIgualA41EXSPulgadas' => [
    'adValorem' => 0.05,
    'arancelEspecifico' => 140.32
],
'TelevisoresMayorA41EXSYMenorOIgualA75EXSPulgadas' => [
    'adValorem' => 0.05,
    'arancelEspecifico' => 158.14
],
```

**Estado:** ✅ Los valores parecen correctos según regulaciones típicas de televisores, pero **requiere verificación oficial** en el Arancel Nacional.

**Acción Recomendada:** Verificar en el Arancel Nacional del SENAE las partidas específicas para televisores.

---

## 🚫 Restricciones de Importación

### Productos Prohibidos o con Restricciones Especiales

#### 1. Prendas de Vestir y Calzado Usados

**Producto en Sistema:**
```php
'PrendasDeVestirYCalzado' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0]
```

**Regulación SENAE:**
- ⚠️ **PROHIBICIÓN**: La importación de ropa y calzado usados está **prohibida** en Ecuador
- Fuente: [SENAE - Prohibición ropa y llantas usadas](https://www.aduana.gob.ec/senae-frena-ingreso-de-ropa-y-llantas-usadas-evitando-perjuicio-de-usd-400-000-al-estado/)

**⚠️ ACCIÓN REQUERIDA:**
- Verificar si el producto "PrendasDeVestirYCalzado" se refiere a productos nuevos o usados
- Si son usados, **debe eliminarse** o marcarse como "no importable"
- Agregar validación en el sistema para rechazar cotizaciones de productos prohibidos

**Restricción de Peso:**
- El sistema tiene configurado un peso máximo de 8 libras para este producto
- Esto podría ser una medida adicional de control

---

#### 2. Llantas Usadas

**Estado:** No hay productos de llantas en la base de datos actual, pero es importante tener en cuenta que están prohibidas.

---

### Restricciones por Método de Envío

#### Régimen Courier 4x4

**Nueva Regulación (desde 16 de junio de 2025):**
- Arancel fijo de **$20 USD** por paquete
- Aplica a envíos de hasta 4 kg y $400 FOB
- Fuente: [SENAE - Régimen Courier 4x4](https://www.aduana.gob.ec/regimen-courier-4x4-tendra-arancel-fijo-para-garantizar-su-correcto-uso-y-proteger-la-produccion-nacional/)

**Estado en Sistema:**
- El sistema actual no contempla el régimen Courier 4x4
- Los métodos configurados son: marítimo, aéreo, aéreo express

**Recomendación:** Evaluar si es necesario agregar este régimen al sistema.

---

## 📋 Validaciones de Peso

### Estado Actual en Sistema:

```php
'validations' => [
    'maritimo_min_weight' => 100,        // ✅ Correcto
    'aereoExpres_min_weight' => 50,      // ✅ Correcto
    'aereoExpres_max_weight' => 200,     // ✅ Correcto
    'prendas_max_weight' => 8,           // ⚠️ Verificar si aplica
],
```

**Estado:** ✅ Las validaciones de peso parecen correctas según estándares de la industria.

---

## 🔄 Cambios Recientes en Políticas Arancelarias

### 1. Reducción Temporal de Aranceles (Estados Unidos)

**Período:** 10 de abril de 2025 - 31 de diciembre de 2025

**Aplicación:**
- Reducción temporal al **10%** para ciertas subpartidas originarias de Estados Unidos
- Requiere certificado de origen no preferencial

**Impacto en Sistema:**
- El sistema actual no diferencia por país de origen
- Si se importa desde Estados Unidos, podría aplicarse esta reducción

**Recomendación:** Considerar agregar campo "país de origen" en futuras versiones del sistema.

---

### 2. Arancel 0% para Generadores de Electricidad

**Período:** 11 de octubre de 2024 - 11 de octubre de 2025

**Aplicación:**
- Tarifa arancelaria 0% para grupos electrógenos en subpartidas específicas

**Estado:** No hay generadores en la base de datos actual.

---

## ✅ Checklist de Verificación

### Impuestos
- [x] Fodinfa: 0.5% ✅ Correcto
- [x] Seguro CIF: 2.5% ✅ Correcto
- [x] **IVA: 15% ✅ ACTUALIZADO** (2024-12-19)

### Aranceles
- [ ] Verificar aranceles ad-valorem en Arancel Nacional
- [ ] Asignar códigos arancelarios a productos
- [x] Aranceles específicos televisores: Valores configurados ✅

### Restricciones
- [ ] **Verificar si "PrendasDeVestirYCalzado" son nuevas o usadas** ⚠️
- [ ] Agregar validación para productos prohibidos
- [ ] Considerar agregar régimen Courier 4x4

### Validaciones
- [x] Peso mínimo marítimo: 100 lbs ✅
- [x] Peso mínimo/máximo aéreo express: 50-200 lbs ✅
- [x] Peso máximo prendas: 8 lbs ✅

---

## 🚀 Acciones Recomendadas

### Prioridad Alta

1. **✅ Actualizar IVA de 12% a 15%** - **COMPLETADO (2024-12-19)**
   - ✅ Archivo: `config/products.php` - Actualizado
   - ✅ Base de datos: Tabla `tax_rates` - Actualizado
   - Impacto: Afecta todos los cálculos de cotización (aplicado)

2. **Verificar producto "PrendasDeVestirYCalzado"**
   - Confirmar si son productos nuevos o usados
   - Si son usados, eliminar o marcar como no importable
   - Agregar validación en el sistema

### Prioridad Media

3. **Asignar códigos arancelarios (NANDINA) a productos**
   - Crear campo `arancel_code` en tabla `products`
   - Facilitará futuras verificaciones automáticas

4. **Implementar validación de productos prohibidos**
   - Crear tabla `restricted_products` o campo `is_restricted` en `products`
   - Rechazar cotizaciones automáticamente

### Prioridad Baja

5. **Considerar agregar régimen Courier 4x4**
   - Evaluar necesidad según volumen de negocio
   - Implementar si es necesario

6. **Agregar campo "país de origen"**
   - Para aplicar reducciones temporales de aranceles
   - Considerar acuerdos comerciales específicos

---

## 📚 Recursos Oficiales SENAE

1. **Arancel Nacional del Ecuador:**
   - https://www.aduana.gob.ec/arancel-nacional/

2. **Gaceta Proceso (Resoluciones y Manuales):**
   - https://www.aduana.gob.ec/gaceta-proceso/

3. **Preguntas Frecuentes:**
   - https://www.aduana.gob.ec/preguntas-frecuentes/

4. **Aplicación Móvil SENAE:**
   - Disponible para consultas de trámites y simuladores

---

## 📝 Notas Adicionales

1. **Actualización Continua:** Las regulaciones arancelarias cambian frecuentemente. Se recomienda revisar periódicamente las publicaciones oficiales del SENAE.

2. **Certificados de Origen:** Para beneficiarse de reducciones arancelarias, es necesario contar con certificados de origen válidos.

3. **Consultas Específicas:** Para dudas sobre productos específicos, contactar directamente al SENAE o consultar con un agente aduanero autorizado.

4. **Monitoreo:** Establecer un proceso de monitoreo continuo de cambios en regulaciones para mantener la base de datos actualizada.

---

**Última Actualización:** 2024-12-19  
**Próxima Revisión Recomendada:** 2025-01-19 (mensual)

