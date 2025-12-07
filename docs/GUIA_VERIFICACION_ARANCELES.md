# 📋 Guía de Verificación de Códigos Arancelarios

## 🔍 Verificación con Arancel Nacional Oficial del SENAE

Para garantizar que los códigos arancelarios en la base de datos sean 100% correctos, es **esencial** consultar el Arancel Nacional oficial del SENAE.

### Acceso al Arancel Nacional

**URL Oficial:** https://www.aduana.gob.ec/arancel-nacional/

### Estructura de Códigos Arancelarios en Ecuador

El Arancel Nacional del Ecuador se basa en:
- **NANDINA** (Nomenclatura Común de los Países Miembros de la Comunidad Andina): 8 dígitos
- **Código Nacional**: 2 dígitos adicionales
- **Total**: 10 dígitos (formato: XXXX.XX.XX.XX)

**Ejemplo:** `8516.60.00.00` donde:
- `85` = Capítulo (Máquinas y aparatos eléctricos)
- `8516` = Partida (Calentadores eléctricos de agua)
- `8516.60` = Subpartida (Otros aparatos electrotérmicos)
- `8516.60.00` = Subpartida NANDINA (8 dígitos)
- `8516.60.00.00` = Código Nacional completo (10 dígitos)

### Reforma Arancelaria 2023

**Importante:** Desde el **1 de septiembre de 2023**, entró en vigor la **Resolución COMEX Nro. 002-2023**, que reformó íntegramente el Arancel del Ecuador e implementa la **Séptima Enmienda del Sistema Armonizado**.

Todos los códigos deben estar actualizados según esta reforma.

---

## 📝 Proceso de Verificación

### Paso 1: Acceder al Arancel Nacional

1. Visite: https://www.aduana.gob.ec/arancel-nacional/
2. Utilice la herramienta de búsqueda
3. Ingrese el nombre del producto o características principales

### Paso 2: Buscar el Código Correcto

1. Ingrese términos específicos del producto
2. Revise las descripciones detalladas
3. Verifique que la descripción coincida con el producto
4. Anote el código arancelario completo (10 dígitos)

### Paso 3: Verificar Tarifas y Restricciones

1. Revise la tarifa arancelaria aplicable
2. Verifique si hay restricciones o requisitos especiales
3. Consulte las observaciones o notas explicativas

### Paso 4: Actualizar la Base de Datos

Una vez verificado el código correcto, actualice:
- Campo `arancel_code` (8 dígitos NANDINA)
- Campo `arancel_subpartida` (10 dígitos completo)

---

## 🔧 Actualización de Códigos en el Sistema

### Opción 1: Actualizar Manualmente

1. Editar `database/seeders/AssignArancelCodesSeeder.php`
2. Actualizar el array `$arancelCodes` con los códigos verificados
3. Ejecutar: `php artisan db:seed --class=AssignArancelCodesSeeder`

### Opción 2: Actualizar por Producto Individual

```php
use App\Models\Product;

$product = Product::where('key', 'NombreDelProducto')->first();
$product->update([
    'arancel_code' => '8516.60.00',        // 8 dígitos NANDINA
    'arancel_subpartida' => '8516.60.00.00' // 10 dígitos completo
]);
```

### Opción 3: Actualización Masiva desde CSV

1. Exportar productos desde base de datos
2. Verificar códigos en Arancel Nacional
3. Importar códigos corregidos

---

## 📊 Códigos Actuales (Basados en Sistema Armonizado)

Los códigos actuales en el sistema están basados en el **Sistema Armonizado** estándar, que es la base de NANDINA. Sin embargo, **deben verificarse** en el Arancel Nacional oficial porque:

1. Ecuador puede tener códigos nacionales específicos (2 últimos dígitos)
2. Puede haber subpartidas adicionales no contempladas en el Sistema Armonizado estándar
3. La reforma 2023 puede haber cambiado algunas clasificaciones

### Categorías Principales

| Categoría | Capítulo SA | Ejemplo de Código |
|-----------|-------------|-------------------|
| Electrodomésticos cocina | 85 | 8516.60.00 |
| Refrigeradoras | 84 | 8418.10.00 |
| Computadoras | 84 | 8471.30.00 |
| Celulares | 85 | 8517.12.00 |
| Televisores | 85 | 8528.72.00 |
| Herramientas eléctricas | 84 | 8467.21.00 |
| Bicicletas | 87 | 8712.00.00 |
| Juguetes | 95 | 9503.00.00 |

---

## ⚠️ Importancia de la Verificación

### Consecuencias de Códigos Incorrectos

1. **Sanciones**: Clasificación incorrecta puede resultar en sanciones del SENAE
2. **Retrasos**: Aduanas puede retener mercancías por clasificación incorrecta
3. **Aranceles Erróneos**: Se pueden aplicar aranceles incorrectos
4. **Problemas Legales**: Puede haber problemas con certificados de origen

### Beneficios de Códigos Correctos

1. ✅ Cumplimiento normativo
2. ✅ Cálculos de aranceles precisos
3. ✅ Procesos aduaneros más rápidos
4. ✅ Evitar sanciones y multas

---

## 🛠️ Herramientas Útiles

### 1. Arancel Nacional SENAE
- **URL**: https://www.aduana.gob.ec/arancel-nacional/
- **Uso**: Búsqueda oficial de códigos arancelarios

### 2. Clasificador Aduanero HY
- **URL**: https://aduanero.com.ec/clasificador-aduanero/
- **Uso**: Herramienta especializada para clasificación arancelaria

### 3. Resolución Anticipada
- **Proceso**: Solicitar al SENAE una resolución anticipada de clasificación
- **Beneficio**: Clasificación oficial y vinculante para un producto específico

---

## 📅 Mantenimiento Periódico

### Frecuencia Recomendada

- **Revisión Anual**: Verificar códigos al menos una vez al año
- **Actualización Inmediata**: Cuando se publiquen nuevas resoluciones COMEX
- **Verificación por Producto**: Al agregar nuevos productos

### Eventos que Requieren Actualización

1. ✅ Nuevas resoluciones COMEX
2. ✅ Reformas arancelarias
3. ✅ Cambios en el Sistema Armonizado
4. ✅ Actualizaciones de NANDINA

---

## 📞 Contacto y Soporte

### SENAE - Servicio Nacional de Aduana del Ecuador

- **Sitio Web**: https://www.aduana.gob.ec/
- **Consultas**: A través del sitio web oficial
- **Resoluciones Anticipadas**: Solicitar según procedimiento oficial

### COMEX - Comité de Comercio Exterior

- **Resoluciones**: Publicadas en Gaceta Oficial
- **Actualizaciones**: Monitorear resoluciones que afecten aranceles

---

## ✅ Checklist de Verificación

- [ ] Acceder al Arancel Nacional oficial
- [ ] Verificar código de 8 dígitos (NANDINA)
- [ ] Verificar código completo de 10 dígitos
- [ ] Confirmar descripción del producto
- [ ] Revisar tarifa arancelaria aplicable
- [ ] Verificar restricciones o requisitos especiales
- [ ] Actualizar base de datos con código verificado
- [ ] Documentar fecha de verificación
- [ ] Programar próxima revisión

---

**Última Actualización:** 2024-12-19  
**Próxima Revisión Recomendada:** 2025-01-19

**Nota Importante:** Los códigos en la base de datos actual son aproximados basados en el Sistema Armonizado. Se requiere verificación oficial en el Arancel Nacional del SENAE para garantizar precisión al 100%.





