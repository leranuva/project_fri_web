/**
 * Componente Alpine para el Cotizador de Importaciones
 * Estado, métodos y lógica de UI separados para mejor mantenibilidad
 *
 * Uso: El componente se usa vía cotizadorData() definido inline en la vista
 * ya que requiere datos del servidor (@json). Este archivo documenta la estructura
 * y puede usarse como referencia para futuras refactorizaciones.
 *
 * Estructura del componente:
 * - state: formData, products, result, showAlert, etc.
 * - methods: calculate(), validate(), downloadPDF(), etc.
 * - UI logic: filterProducts(), selectProduct(), scrollToResult()
 */

export const quoteCalculatorConfig = {
  // Campos del formulario
  formFields: ['product', 'quantity', 'weight', 'unitValue', 'shippingMethod'],

  // Métodos de envío con etiquetas
  methodLabels: {
    maritimo: 'Marítimo',
    aereo: 'Aéreo',
    aereoExpres: 'Aéreo Express',
    courier4x4: 'Courier 4x4 (Arancel fijo $20)',
  },

  // Validaciones de peso por método
  weightLimits: {
    maritimo: { min: 100 },
    aereoExpres: { min: 50, max: 200 },
    courier4x4: { maxWeight: 8.82, maxValueFob: 400 },
    PrendasDeVestirYCalzado: { maxWeight: 8 },
  },
};
