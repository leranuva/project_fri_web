// Importar dependencias
import $ from 'jquery';
import 'select2/dist/css/select2.min.css';
import 'select2';
import { jsPDF } from 'jspdf';

// Hacer jQuery y Select2 disponibles globalmente
window.$ = window.jQuery = $;
window.jsPDF = { jsPDF };
window.jspdf = { jsPDF };

$(document).ready(function () {
    // Inicialización de Select2 para el selector de productos
    $("#product").select2({
        placeholder: "Buscar producto...",
        allowClear: false,
        theme: 'default',
        width: '100%'
    });

    // Aplicar estilos glassmorphism a Select2
    $('.select2-container').css({
        'background': 'rgba(255, 255, 255, 0.2)',
        'backdrop-filter': 'blur(10px)',
        '-webkit-backdrop-filter': 'blur(10px)',
        'border': '1px solid rgba(255, 255, 255, 0.3)',
        'border-radius': '12px'
    });
});

//==================== SIMULATED DATABASE ====================//
const productsData = {
    // ADVALOREM 30% ====================//
    CocinasDeInduccion_Gas_Horno: { adValorem: 0.3, arancelEspecifico: 0.0 },
    OllasParaCocinaDeInducción: { adValorem: 0.3, arancelEspecifico: 0.0 },
    HornosConvection: { adValorem: 0.3, arancelEspecifico: 0.0 },
    ExtractorDeCocina_Hoods: { adValorem: 0.3, arancelEspecifico: 0.0 },
    AsientosParaBebe: { adValorem: 0.3, arancelEspecifico: 0.0 },
    JuguetesYAccesoriosParaBebe: { adValorem: 0.3, arancelEspecifico: 0.0 },
    RadiosParaCarros: { adValorem: 0.3, arancelEspecifico: 0.0 },
    MueblesDeMaderaParaCocina: { adValorem: 0.3, arancelEspecifico: 0.0 },
    BicicletasElectricas: { adValorem: 0.3, arancelEspecifico: 0.0 },
    OllasDePresion: { adValorem: 0.3, arancelEspecifico: 0.0 },
    CuchillosDeCocina: { adValorem: 0.3, arancelEspecifico: 0.0 },
    ElectrodomesticosCocina: { adValorem: 0.3, arancelEspecifico: 0.0 },
    Jugueteria: { adValorem: 0.3, arancelEspecifico: 0.0 },
    Triciclos_Patines_CochesConRuedas: { adValorem: 0.3, arancelEspecifico: 0.0 },
    UtenciliosParaMesa_CocinaYPlatosParaServicioDeMesa_Cocina: { adValorem: 0.3, arancelEspecifico: 0.0 },
    RefrigeradoraKitchenAid: { adValorem: 0.3, arancelEspecifico: 0.0 },
    
    // ADVALOREM 25% ====================//
    KitElectricoParaBicicleta: { adValorem: 0.25, arancelEspecifico: 0.0 },
    Bisuteria_Relojes_Joyas: { adValorem: 0.25, arancelEspecifico: 0.0 },
    AudifonosGamerConCasco: { adValorem: 0.25, arancelEspecifico: 0.0 },
    AudifonosAirpodsInalambricos: { adValorem: 0.25, arancelEspecifico: 0.0 },
    MaquinasDeCoser: { adValorem: 0.25, arancelEspecifico: 0.0 },
    SoporteDeSierraInglentadora: { adValorem: 0.25, arancelEspecifico: 0.0 },
    SmartToilets_SanitariosInteligentes: { adValorem: 0.25, arancelEspecifico: 0.0 },
    
    // ADVALOREM 20% ====================//
    Refrigeradora: { adValorem: 0.2, arancelEspecifico: 0.0 },
    BathTubs_Tinas: { adValorem: 0.2, arancelEspecifico: 0.0 },
    ProtectoresParaIpods: { adValorem: 0.2, arancelEspecifico: 0.0 },
    ProyectoresDeImagen_DeLuz: { adValorem: 0.2, arancelEspecifico: 0.0 },
    CineEnCasa: { adValorem: 0.2, arancelEspecifico: 0.0 },
    EquiposDeGrabacionYProduccion: { adValorem: 0.2, arancelEspecifico: 0.0 },
    DVRParaCamarasDeSeguridad: { adValorem: 0.2, arancelEspecifico: 0.0 },
    GrifosParaFregaderosDeCocina_KitchenFaucets: { adValorem: 0.2, arancelEspecifico: 0.0 },
    Cajas_PanelesElectricos: { adValorem: 0.2, arancelEspecifico: 0.0 },
    ShoppingCarts_CarritosDeCompras: { adValorem: 0.2, arancelEspecifico: 0.0 },
    
    // ADVALOREM 15% ====================//
    LavadoraDeRopa_Secadora: { adValorem: 0.15, arancelEspecifico: 0.0 },
    Celulares_NuevosSolamente: { adValorem: 0.15, arancelEspecifico: 0.0 },
    Ipods: { adValorem: 0.15, arancelEspecifico: 0.0 },
    Tablets: { adValorem: 0.15, arancelEspecifico: 0.0 },
    ComputadorasDeEscritorio: { adValorem: 0.15, arancelEspecifico: 0.0 },
    CamarasDeVideo: { adValorem: 0.15, arancelEspecifico: 0.0 },
    CamarasDeSeguridad: { adValorem: 0.15, arancelEspecifico: 0.0 },
    AspiradoraRobotica: { adValorem: 0.15, arancelEspecifico: 0.0 },
    PisosDeMaderaEspesorSuperiorA5mmPeroInferiorOIgualA9mm: { adValorem: 0.15, arancelEspecifico: 0.0 },
    PisoFlotanteDeEspesorSuperiorA9mm: { adValorem: 0.15, arancelEspecifico: 0.0 },
    Caladoras_Jigsaw: { adValorem: 0.15, arancelEspecifico: 0.0 },
    ManguerasDeAire: { adValorem: 0.15, arancelEspecifico: 0.0 },
    
    // ADVALOREM 10% ====================//
    RepuestosElectricosParaAutos: { adValorem: 0.1, arancelEspecifico: 0.0 },
    Bicicletas: { adValorem: 0.1, arancelEspecifico: 0.0 },
    TapaCubosYAccesorios: { adValorem: 0.1, arancelEspecifico: 0.0 },
    EquiposElectronicos: { adValorem: 0.1, arancelEspecifico: 0.0 },
    Amplificadores_Parlantes: { adValorem: 0.1, arancelEspecifico: 0.0 },
    AspiradoraPartes: { adValorem: 0.1, arancelEspecifico: 0.0 },
    SoundBars: { adValorem: 0.1, arancelEspecifico: 0.0 },
    
    // ADVALOREM 5% ====================//
    MaquinaParaHacerHelados: { adValorem: 0.05, arancelEspecifico: 0.0 },
    CamarasDeTelevision: { adValorem: 0.05, arancelEspecifico: 0.0 },
    ImpresorasWirless: { adValorem: 0.05, arancelEspecifico: 0.0 },
    ImpresorasIndustriales: { adValorem: 0.05, arancelEspecifico: 0.0 },
    SoldadoraCautin: { adValorem: 0.05, arancelEspecifico: 0.0 },
    PartesDeAutoFiltrosGasolina: { adValorem: 0.05, arancelEspecifico: 0.0 },
    CamarasDeSeguridadConDVR: { adValorem: 0.05, arancelEspecifico: 0.0 },
    JuegoDeDadosAjustables: { adValorem: 0.05, arancelEspecifico: 0.0 },
    NivelesLaser_LaserLevel: { adValorem: 0.05, arancelEspecifico: 0.0 },
    PartesParaNivelesLaserTripoEtc: { adValorem: 0.05, arancelEspecifico: 0.0 },
    JuegoDeDestornilladores: { adValorem: 0.05, arancelEspecifico: 0.0 },
    SierraVerticalDeCinta: { adValorem: 0.05, arancelEspecifico: 0.0 },
    HerramientasDeTaladrarORascarPTHOIncluidasLasTerrajasPTHC: { adValorem: 0.05, arancelEspecifico: 0.0 },
    TaladrosInalambricos_Driles: { adValorem: 0.05, arancelEspecifico: 0.0 },
    Drone: { adValorem: 0.05, arancelEspecifico: 0.0 },
    TelevisoresMayorA20EXSYMenorOIgualA32EXSPulgadas: { adValorem: 0.05, arancelEspecifico: 73.11 },
    TelevisoresMayorA32EXSYMenorOIgualA41EXSPulgadas: { adValorem: 0.05, arancelEspecifico: 140.32 },
    TelevisoresMayorA41EXSYMenorOIgualA75EXSPulgadas: { adValorem: 0.05, arancelEspecifico: 158.14 },
    
    // ADVALOREM 4% ====================//
    GafasVirtualReality: { adValorem: 0.04, arancelEspecifico: 0.0 },
    HerramientasDeMano: { adValorem: 0.15, arancelEspecifico: 0.0 },
    
    // ADVALOREM 0% ====================//
    SierrasDeMesa: { adValorem: 0.3, arancelEspecifico: 0.0 },
    SierrasParaCarpinteria: { adValorem: 0.3, arancelEspecifico: 0.0 },
    SierraIngletadora: { adValorem: 0.3, arancelEspecifico: 0.0 },
    PowerWash: { adValorem: 0.3, arancelEspecifico: 0.0 },
    CortadoraDeCesped: { adValorem: 0.3, arancelEspecifico: 0.0 },
    CocinaInduccionElectricaSinHorno: { adValorem: 0.3, arancelEspecifico: 0.0 },
    HornosDeInduccionElectricos_Microondas: { adValorem: 0.3, arancelEspecifico: 0.0 },
    ExtractorDeJugos: { adValorem: 0.3, arancelEspecifico: 0.0 },
    FiltrosExtractorDeCocina: { adValorem: 0.3, arancelEspecifico: 0.0 },
    BujiasParaAutos: { adValorem: 0.3, arancelEspecifico: 0.0 },
    RepuestosParaAutos: { adValorem: 0.3, arancelEspecifico: 0.0 },
    JuegoDeArosParaCarrosOAutomoviles: { adValorem: 0.3, arancelEspecifico: 0.0 },
    RuedasYSusPartes: { adValorem: 0.3, arancelEspecifico: 0.0 },
    SincronizadorDeVehiculo: { adValorem: 0.3, arancelEspecifico: 0.0 },
    Computer_CPU: { adValorem: 0.3, arancelEspecifico: 0.0 },
    RepuestosParaComputadoras: { adValorem: 0.3, arancelEspecifico: 0.0 },
    SystemaGPS: { adValorem: 0.3, arancelEspecifico: 0.0 },
    AlarmasComerciales_Residenciales: { adValorem: 0.3, arancelEspecifico: 0.0 },
    HogarDecorativos_Cintas: { adValorem: 0.3, arancelEspecifico: 0.0 },
    Soldadoras: { adValorem: 0.3, arancelEspecifico: 0.0 },
    PisoFlotante: { adValorem: 0.3, arancelEspecifico: 0.0 },
    DiagnosticadorDeAutos: { adValorem: 0.3, arancelEspecifico: 0.0 },
    SmartphonesNuevos: { adValorem: 0.3, arancelEspecifico: 0.0 },
    PartesDeAutoFiltrosDeAire: { adValorem: 0.3, arancelEspecifico: 0.0 },
    PartesDeAutoAireAcondicionado: { adValorem: 0.3, arancelEspecifico: 0.0 },
    Smartwatch: { adValorem: 0.3, arancelEspecifico: 0.0 },
    CerradurasInteligentes: { adValorem: 0.3, arancelEspecifico: 0.0 },
    AirCompresorDePotenciaInferiorA30kwPTHO40hpPTHC: { adValorem: 0.3, arancelEspecifico: 0.0 },
    Amoladoras: { adValorem: 0.3, arancelEspecifico: 0.0 },
    CNCRouterMachine: { adValorem: 0.3, arancelEspecifico: 0.0 },
    Fresadora: { adValorem: 0.3, arancelEspecifico: 0.0 },
    SierraEscuadradora_SlidingTableSaw: { adValorem: 0.3, arancelEspecifico: 0.0 },
    UtilesDeTaladrarBrocasParaHamerDrill: { adValorem: 0.3, arancelEspecifico: 0.0 },
    HamerDrill: { adValorem: 0.3, arancelEspecifico: 0.0 },
    KitchenSinks_Fregaderos: { adValorem: 0.3, arancelEspecifico: 0.0 },
    PistolasParaPintar_SprayGun: { adValorem: 0.3, arancelEspecifico: 0.0 },
    Laptos: { adValorem: 0.3, arancelEspecifico: 0.0, newPercent: 0.12 },
    PrendasDeVestirYCalzado: { adValorem: 0.3, arancelEspecifico: 0.0 },
};

//==================== MODIFY STRING FUNCTION ====================//
const moddedString = (key) => {
    let string = key.toString();
    string = string.replace(/([a-z])([0-9])/g, "$1 $2");
    string = string.replace(/([A-Z])([0-9])/g, "$1 $2");
    string = string.replace(/([a-z])([A-Z])/g, "$1 $2");
    string = string.replace(/([A-Z])([A-Z][a-z])/g, "$1 $2");
    string = string.replaceAll("_", "/");
    string = string.replaceAll("PTHO", "(");
    string = string.replaceAll("PTHC", ")");
    string = string.replaceAll("EXS", " ");
    return string;
};

//==================== CREATE & INSERT OPTIONS ====================//
$(document).ready(function() {
    const productSelection = document.getElementById("product");
    if (productSelection) {
        const keys = Object.keys(productsData);
        keys.forEach((key) => {
            const element = document.createElement("option");
            const elementText = moddedString(key);
            element.value = key;
            element.textContent = elementText;
            productSelection.appendChild(element);
        });
    }
});

//==================== TO PERCENT ====================//
const toPercent = (val) => {
    let newPercent = val * 100;
    return newPercent;
};

//==================== GENERAL CALCULATIONS ====================//
function calculateShipping() {
    const productSelected = document.getElementById("product").value;
    const shippingMethod = document.getElementById("shippingMethod").value;
    const unitWeight = parseFloat(document.getElementById("weight").value);
    const quantity = parseFloat(document.getElementById("quantity").value);
    const unitValue = parseFloat(document.getElementById("unitValue").value);
    const weight = unitWeight * quantity;
    let costPerPound = 0;

    //==================== Function To Show Alert ====================//
    const overlay = document.querySelector(".overlay");
    const alertMessage = document.querySelector(".alertMessage");
    const alertBtn = document.querySelector(".alertBtn");
    
    const showAlert = (msg) => {
        if (overlay && alertMessage) {
            overlay.classList.add("openOverlay");
            alertMessage.textContent = msg;
            if (alertBtn) {
                alertBtn.addEventListener("click", () => {
                    overlay.classList.remove("openOverlay");
                }, { once: true });
            }
        } else {
            alert(msg);
        }
    };

    //==================== Form Validation ====================//
    if (productSelected == "selectProducto" || !productSelected) {
        showAlert("Por favor seleccione un producto válido.");
        return;
    }
    if (shippingMethod == "selectMetodo" || !shippingMethod) {
        showAlert("Por favor seleccione un método de envío válido.");
        return;
    }
    if (isNaN(weight) || isNaN(quantity) || isNaN(unitValue) || weight <= 0 || quantity <= 0 || unitValue <= 0) {
        showAlert("Por favor ingrese valores válidos.");
        return;
    }

    if (shippingMethod === "maritimo" && weight < 100) {
        showAlert("Para envío marítimo, el peso mínimo es de 100 libras.");
        return;
    }

    if (shippingMethod === "aereoExpres" && weight < 50) {
        showAlert("Para envío Aéreo-Express, el peso mínimo es de 50 libras.");
        return;
    }

    if (shippingMethod === "aereoExpres" && weight > 200) {
        showAlert("Para envío aereoExpres, el peso máximo permitido es de 200 libras.");
        return;
    }

    if (productSelected === "PrendasDeVestirYCalzado" && weight > 8) {
        showAlert("No se puede realizar el envío de prendas de vestir y calzado si el peso excede las 8 libras.");
        return;
    }

    // Calcular costo por libra según método de envío
    switch (shippingMethod) {
        case "maritimo":
            if (weight >= 10 && weight <= 99) costPerPound = 4.0;
            else if (weight >= 100 && weight <= 199) costPerPound = 3.75;
            else if (weight >= 200 && weight <= 299) costPerPound = 3.5;
            else if (weight >= 300 && weight <= 399) costPerPound = 3.25;
            else if (weight >= 400 && weight <= 499) costPerPound = 3.0;
            else if (weight >= 500 && weight <= 599) costPerPound = 2.75;
            else if (weight >= 600 && weight <= 699) costPerPound = 2.55;
            else if (weight >= 700 && weight <= 799) costPerPound = 2.35;
            else if (weight >= 800 && weight <= 899) costPerPound = 2.3;
            else if (weight >= 900 && weight <= 1200) costPerPound = 2.25;
            else if (weight >= 1200 && weight <= 1500) costPerPound = 1.4;
            else if (weight >= 1501 && weight <= 2000) costPerPound = 1.3;
            else if (weight >= 2001) costPerPound = 1.25;
            break;
        case "aereo":
            if (weight == 1) costPerPound = 19.8 / weight;
            else if (weight == 2) costPerPound = 11.54;
            else if (weight == 3) costPerPound = 9.8;
            else if (weight == 4) costPerPound = 8.24;
            else if (weight == 5) costPerPound = 7.52;
            else if (weight == 6) costPerPound = 7.23;
            else if (weight == 7) costPerPound = 6.95;
            else if (weight == 8) costPerPound = 6.75;
            else if (weight == 9) costPerPound = 6.63;
            else if (weight >= 10 && weight <= 19) costPerPound = 5.86;
            else if (weight >= 20 && weight <= 29) costPerPound = 5.4;
            else if (weight >= 30 && weight <= 39) costPerPound = 5.21;
            else if (weight >= 40 && weight <= 49) costPerPound = 5.13;
            else if (weight >= 50 && weight <= 59) costPerPound = 5.08;
            else if (weight >= 60 && weight <= 69) costPerPound = 4.95;
            else if (weight >= 80 && weight <= 99) costPerPound = 3.67;
            else if (weight >= 100 && weight <= 139) costPerPound = 3.6;
            else if (weight >= 140 && weight <= 149) costPerPound = 3.55;
            else if (weight >= 150 && weight <= 199) costPerPound = 3.55;
            else if (weight >= 200 && weight <= 279) costPerPound = 3.49;
            else if (weight >= 280 && weight <= 499) costPerPound = 3.45;
            else if (weight >= 500) costPerPound = 3.42;
            break;
        case "aereoExpres":
            if (weight >= 50 && weight <= 99) costPerPound = 12.16;
            else if (weight >= 100 && weight <= 149) costPerPound = 8.03;
            else if (weight >= 150 && weight <= 199) costPerPound = 6.02;
            else if (weight >= 200) costPerPound = 5.3;
            break;
    }

    const shippingCost = costPerPound * unitWeight * quantity;
    const productCost = unitValue * quantity;

    let impuestoAdvalorem = 0;
    let impuestoFodinfa = 0;
    let impuestoIva = 0;
    const arancelEspecifico = productsData[productSelected].arancelEspecifico;

    // Lógica de validación para condiciones específicas
    if (shippingMethod === "aereo" && weight >= 1 && weight <= 8) {
        // Sin impuestos para este caso
    } else if (shippingMethod === "aereo" && productCost <= 400) {
        const fodinfa = 0.005;
        const iva = 0.12;
        const adValorem = productsData[productSelected].adValorem;
        impuestoAdvalorem = productCost * adValorem;
        impuestoFodinfa = productCost * fodinfa;
        impuestoIva = (productCost + impuestoAdvalorem + impuestoFodinfa) * iva;
    } else {
        const fodinfa = 0.005;
        const iva = 0.12;
        const adValorem = productsData[productSelected].adValorem;
        impuestoAdvalorem = productCost * adValorem;
        impuestoFodinfa = productCost * fodinfa;
        impuestoIva = (productCost + impuestoAdvalorem + impuestoFodinfa) * iva;
    }

    const totalImpuestos = impuestoAdvalorem + impuestoFodinfa + impuestoIva + arancelEspecifico;
    
    // Seguro CIF
    const seguroCIF = (productCost + shippingCost) * 0.025;
    const totalCotizacion = productCost + shippingCost + totalImpuestos;
    const totalConSeguro = totalCotizacion + seguroCIF;

    const adValorem = productsData[productSelected].adValorem;
    const fodinfa = 0.005;
    const iva = 0.12;

    const resultContainer = document.getElementById("result");
    const resultCard = resultContainer ? resultContainer.querySelector('.result-card') : null;
    if (resultCard) {
        // Insertar antes del botón de descarga
        const descargarBtn = resultCard.querySelector('#descargar');
        const resultContent = document.createElement('div');
        resultContent.className = 'result-content';
        resultContent.innerHTML = `
            <div class="gridrow"><p>Detalles de la Cotización</p></div>
            <div class="gridrow">Producto: <span>${moddedString(productSelected)}</span></div>
            <div class="gridrow">Cantidad: <span>${quantity}</span></div>
            <div class="gridrow">Peso: <span>${weight} lb</span></div>
            <div class="gridrow">Valor del producto: <span>$${productCost.toFixed(2)}</span></div>
            <div class="gridrow">Valor del envío: <span>$${shippingCost.toFixed(2)}</span></div>
            <div class="gridrow">Valor de los impuestos: <span>$${totalImpuestos.toFixed(2)}</span></div>
            <div class="gridrow">Seguro CIF: <span>$${seguroCIF.toFixed(2)}</span></div>
            <div class="gridrow"></div>
            <div class="gridrow"><p>Detalles de Impuestos</p></div>
            <div class="gridrow">Ad-valorem: (${toPercent(adValorem)}%)<span>$${impuestoAdvalorem.toFixed(2)}</span></div>
            <div class="gridrow">Fodinfa: (${toPercent(fodinfa)}%) <span>$${impuestoFodinfa.toFixed(2)}</span></div>
            <div class="gridrow">IVA: (${toPercent(iva)}%) <span>$${impuestoIva.toFixed(2)}</span></div>
            <div class="gridrow">Arancel específico: <span>$${arancelEspecifico.toFixed(2)}</span></div>
            <div class="gridrow"></div>
            <div class="gridrow">Total Impuestos: <span>$${totalImpuestos.toFixed(2)}</span></div>
            <div class="gridrow">Total de la cotización: <span>$${totalConSeguro.toFixed(2)}</span></div>
        `;
        
        // Eliminar contenido anterior si existe
        const existingContent = resultCard.querySelector('.result-content');
        if (existingContent) {
            existingContent.remove();
        }
        
        // Insertar antes del botón
        if (descargarBtn && descargarBtn.parentNode) {
            descargarBtn.parentNode.insertBefore(resultContent, descargarBtn);
        } else {
            resultCard.appendChild(resultContent);
        }
        
        resultContainer.style.display = 'block';
    }

    // Mostrar botón de descarga
    const descargarBtn = document.getElementById("descargar");
    if (descargarBtn) {
        descargarBtn.style.display = "block";
        descargarBtn.onclick = () => {
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF();
            const resultContent = document.querySelector('.result-content');
            if (resultContent) {
                const text = resultContent.innerText || resultContent.textContent;
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
    }
}

// Reset button
document.addEventListener('DOMContentLoaded', function() {
    const resetButton = document.getElementById("resetButton");
    if (resetButton) {
        resetButton.addEventListener("click", function () {
            window.location.reload();
        });
    }
});

// Exportar funciones para uso global
window.calculateShipping = calculateShipping;
window.productsData = productsData;
window.moddedString = moddedString;

