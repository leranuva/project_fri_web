// Cotizador con Alpine.js - Sin dependencias de jQuery
import { jsPDF } from 'jspdf';
import html2canvas from 'html2canvas';

// Hacer jsPDF y html2canvas disponibles globalmente
// Asegurarse de que estén disponibles cuando el script se carga
// Usar una función que se ejecute inmediatamente
(function() {
    'use strict';
    
    // Exponer las librerías globalmente
    if (typeof window !== 'undefined') {
        window.jspdf = { jsPDF };
        window.html2canvas = html2canvas;
        
        // También exponer directamente para compatibilidad
        if (!window.html2canvas) {
            window.html2canvas = html2canvas;
        }
    }
})();

// Función para formatear nombres de productos
function formatProductName(key) {
    let string = key.toString();
    string = string.replace(/([a-z])([0-9])/gi, "$1 $2");
    string = string.replace(/([a-z])([A-Z])/g, "$1 $2");
    string = string.replace(/([A-Z])([A-Z][a-z])/g, "$1 $2");
    string = string.replaceAll("_", "/");
    string = string.replaceAll("PTHO", "(");
    string = string.replaceAll("PTHC", ")");
    string = string.replaceAll("EXS", " ");
    return string;
}

// Función para calcular costo por libra
function calculateCostPerPound(method, weight) {
    const rates = window.shippingRates[method] || [];
    
    for (let rate of rates) {
        const [min, max, cost] = rate;
        
        if (max === null) {
            if (weight >= min) return cost;
        } else {
            if (weight >= min && weight <= max) {
                if (method === 'aereo' && weight == 1) {
                    return cost / weight;
                }
                return cost;
            }
        }
    }
    
    return 0;
}

// Función para calcular cotización
function calculateQuote(data) {
    const product = window.productsData[data.product];
    if (!product) return null;

    const quantity = parseFloat(data.quantity);
    const unitWeight = parseFloat(data.weight);
    const unitValue = parseFloat(data.unitValue);
    const shippingMethod = data.shippingMethod;
    
    const totalWeight = unitWeight * quantity;
    const productCost = unitValue * quantity;
    
    // Calcular costo de envío
    const costPerPound = calculateCostPerPound(shippingMethod, totalWeight);
    const shippingCost = costPerPound * totalWeight;
    
    // Calcular impuestos
    const adValorem = product.adValorem;
    const arancelEspecifico = product.arancelEspecifico;
    
    let impuestoAdvalorem = 0;
    let impuestoFodinfa = 0;
    let impuestoIva = 0;
    
    const fodinfa = 0.005;
    const iva = 0.12;
    
    // Lógica especial para aereo
    if (shippingMethod === 'aereo' && totalWeight >= 1 && totalWeight <= 8) {
        // Sin impuestos
    } else if (shippingMethod === 'aereo' && productCost <= 400) {
        impuestoAdvalorem = productCost * adValorem;
        impuestoFodinfa = productCost * fodinfa;
        impuestoIva = (productCost + impuestoAdvalorem + impuestoFodinfa) * iva;
    } else {
        impuestoAdvalorem = productCost * adValorem;
        impuestoFodinfa = productCost * fodinfa;
        impuestoIva = (productCost + impuestoAdvalorem + impuestoFodinfa) * iva;
    }
    
    const totalImpuestos = impuestoAdvalorem + impuestoFodinfa + impuestoIva + arancelEspecifico;
    
    // Seguro CIF
    const seguroCIF = (productCost + shippingCost) * 0.025;
    const totalCotizacion = productCost + shippingCost + totalImpuestos;
    const totalConSeguro = totalCotizacion + seguroCIF;
    
    return {
        product: data.product,
        quantity,
        weight: totalWeight,
        productCost,
        shippingCost,
        impuestoAdvalorem,
        impuestoFodinfa,
        impuestoIva,
        arancelEspecifico,
        totalImpuestos,
        seguroCIF,
        totalCotizacion: totalConSeguro,
        adValorem,
        fodinfa,
        iva,
    };
}

// Función para validar
function validate(data) {
    const errors = [];
    
    if (!data.product || data.product === 'selectProducto') {
        errors.push('Por favor seleccione un producto válido.');
    }
    
    if (!data.shippingMethod || data.shippingMethod === 'selectMetodo') {
        errors.push('Por favor seleccione un método de envío válido.');
    }
    
    const quantity = parseFloat(data.quantity || 0);
    const weight = parseFloat(data.weight || 0);
    const unitValue = parseFloat(data.unitValue || 0);
    const totalWeight = weight * quantity;
    
    if (quantity <= 0 || weight <= 0 || unitValue <= 0) {
        errors.push('Por favor ingrese valores válidos.');
    }
    
    if (data.shippingMethod === 'maritimo' && totalWeight < 100) {
        errors.push('Para envío marítimo, el peso mínimo es de 100 libras.');
    }
    
    if (data.shippingMethod === 'aereoExpres') {
        if (totalWeight < 50) {
            errors.push('Para envío Aéreo-Express, el peso mínimo es de 50 libras.');
        }
        if (totalWeight > 200) {
            errors.push('Para envío aereoExpres, el peso máximo permitido es de 200 libras.');
        }
    }
    
    if (data.product === 'PrendasDeVestirYCalzado' && totalWeight > 8) {
        errors.push('No se puede realizar el envío de prendas de vestir y calzado si el peso excede las 8 libras.');
    }
    
    return errors;
}

// Exportar funciones para uso global
window.cotizadorAlpine = {
    formatProductName,
    calculateQuote,
    validate,
    generatePDF(result) {
        const pdf = new jsPDF();
        const text = document.querySelector('.result-content')?.innerText || '';
        const lines = pdf.splitTextToSize(text, 180);
        let y = 20;
        lines.forEach((line) => {
            if (y > 280) {
                pdf.addPage();
                y = 20;
            }
            pdf.text(line, 20, y);
            y += 7;
        });
        pdf.save("cotizacion.pdf");
    }
};

