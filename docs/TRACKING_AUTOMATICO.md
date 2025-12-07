# 📦 Sistema de Tracking Automático

## ✅ Funcionalidad Implementada

El sistema ahora busca automáticamente información de paquetes cuando se ingresa un número de tracking que no existe en la base de datos.

### Cómo Funciona

1. **Detección Automática de Transportista**: El sistema detecta automáticamente el transportista basándose en el formato del número de tracking:
   - **Amazon**: Números que empiezan con `TBA` (ej: `TBA326257143026`)
   - **USPS**: Varios formatos de 22-24 dígitos
   - **FedEx**: 12-15 dígitos
   - **UPS**: Formato `1Z` seguido de 16 caracteres alfanuméricos
   - **DHL**: 10-11 dígitos o formato internacional

2. **Búsqueda Automática**: Cuando un usuario busca un número de tracking:
   - Primero busca en la base de datos local
   - Si no lo encuentra, intenta obtener información automáticamente
   - Crea un registro en la base de datos con la información obtenida
   - Muestra la información al usuario

3. **Información Básica**: Por defecto, el sistema crea información básica basada en el transportista detectado. Para obtener información REAL y actualizada, puedes configurar APIs de tracking.

---

## 🔧 Configuración de APIs de Tracking Reales

### Opción 1: TrackingMore API (Recomendado)

TrackingMore ofrece un plan gratuito limitado y planes de pago para más consultas.

1. **Registrarse**: Ve a [TrackingMore](https://www.trackingmore.com/) y crea una cuenta
2. **Obtener API Key**: Ve a tu panel y copia tu API Key
3. **Configurar en Laravel**: Agrega al archivo `.env`:
   ```env
   TRACKINGMORE_API_KEY=tu_api_key_aqui
   ```

El sistema usará automáticamente TrackingMore cuando esté configurado.

### Opción 2: AfterShip API

AfterShip también ofrece tracking agregado.

1. **Registrarse**: Ve a [AfterShip](https://www.aftership.com/) y crea una cuenta
2. **Obtener API Key**: Copia tu API Key del panel
3. **Modificar TrackingService**: Agrega el método para AfterShip en `app/Services/TrackingService.php`

### Opción 3: APIs Directas de Transportistas

#### USPS API
- Requiere registro en [USPS Web Tools](https://www.usps.com/business/web-tools-apis/)
- Necesitas un User ID
- Más complejo de implementar

#### FedEx API
- Requiere cuenta de desarrollador en [FedEx Developer Portal](https://developer.fedex.com/)
- Necesitas API Key y Secret
- Más complejo de implementar

#### UPS API
- Requiere cuenta en [UPS Developer Kit](https://developer.ups.com/)
- Necesitas Access Key y Username
- Más complejo de implementar

---

## 📝 Ejemplo de Uso

### Para Usuarios

1. Ve a la página de inicio
2. Desplázate hasta "Seguimiento de Paquetes"
3. Ingresa un número de tracking (ej: `TBA326257143026`)
4. Haz clic en "Buscar información"
5. El sistema automáticamente:
   - Detecta el transportista (Amazon en este caso)
   - Crea un registro con información básica
   - Muestra la información

### Para Administradores

Los paquetes creados automáticamente aparecen en el panel de administración:
- **Dashboard** → **Paquetes / Tracking**
- Puedes editar, actualizar o eliminar estos paquetes
- Puedes asignarlos a usuarios específicos

---

## 🔄 Actualización de Información

Actualmente, el sistema crea la información una vez. Para actualizar información de tracking en tiempo real:

1. **Configurar TrackingMore API** (recomendado)
2. **Crear un Job/Command** que actualice paquetes periódicamente:
   ```bash
   php artisan make:command UpdateTrackingInfo
   ```
3. **Programar con Cron** para ejecutar cada X horas

---

## 🎯 Mejoras Futuras

- [ ] Integración completa con TrackingMore API
- [ ] Integración con AfterShip API
- [ ] Job programado para actualizar tracking automáticamente
- [ ] Notificaciones cuando cambie el estado del paquete
- [ ] Webhooks para actualizaciones en tiempo real

---

## ⚠️ Notas Importantes

1. **Límites de API**: Las APIs gratuitas tienen límites de consultas. Considera planes de pago para producción.

2. **Información Básica**: Sin API configurada, el sistema crea información básica basada en el transportista detectado. Esta información puede no ser 100% precisa.

3. **Privacidad**: Los números de tracking pueden ser sensibles. Asegúrate de cumplir con las políticas de privacidad.

4. **Rendimiento**: Las llamadas a APIs externas pueden ser lentas. Considera usar colas (queues) para no bloquear las peticiones del usuario.

---

## 🆘 Solución de Problemas

### El sistema no detecta el transportista

- Verifica que el número de tracking tenga el formato correcto
- Algunos números pueden no coincidir con los patrones definidos
- El sistema creará el paquete con transportista "Desconocido"

### No se obtiene información real

- Verifica que la API key esté configurada correctamente en `.env`
- Revisa los logs en `storage/logs/laravel.log` para errores
- Algunos números de tracking pueden no estar disponibles en las APIs públicas

### Error al crear el paquete

- Verifica que la base de datos esté funcionando
- Revisa que la migración de `packages` se haya ejecutado
- Verifica los permisos de escritura en la base de datos






