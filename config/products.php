<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Productos y sus Impuestos
    |--------------------------------------------------------------------------
    |
    | Este archivo contiene la configuración de productos con sus respectivos
    | impuestos (adValorem y arancelEspecifico).
    |
    */

    'products' => [
        // ADVALOREM 30%
        'CocinasDeInduccion_Gas_Horno' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'OllasParaCocinaDeInducción' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'HornosConvection' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'ExtractorDeCocina_Hoods' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'AsientosParaBebe' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'JuguetesYAccesoriosParaBebe' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'RadiosParaCarros' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'MueblesDeMaderaParaCocina' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'BicicletasElectricas' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'OllasDePresion' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'CuchillosDeCocina' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'ElectrodomesticosCocina' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'Jugueteria' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'Triciclos_Patines_CochesConRuedas' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'UtenciliosParaMesa_CocinaYPlatosParaServicioDeMesa_Cocina' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'RefrigeradoraKitchenAid' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],

        // ADVALOREM 25%
        'KitElectricoParaBicicleta' => ['adValorem' => 0.25, 'arancelEspecifico' => 0.0],
        'Bisuteria_Relojes_Joyas' => ['adValorem' => 0.25, 'arancelEspecifico' => 0.0],
        'AudifonosGamerConCasco' => ['adValorem' => 0.25, 'arancelEspecifico' => 0.0],
        'AudifonosAirpodsInalambricos' => ['adValorem' => 0.25, 'arancelEspecifico' => 0.0],
        'MaquinasDeCoser' => ['adValorem' => 0.25, 'arancelEspecifico' => 0.0],
        'SoporteDeSierraInglentadora' => ['adValorem' => 0.25, 'arancelEspecifico' => 0.0],
        'SmartToilets_SanitariosInteligentes' => ['adValorem' => 0.25, 'arancelEspecifico' => 0.0],

        // ADVALOREM 20%
        'Refrigeradora' => ['adValorem' => 0.2, 'arancelEspecifico' => 0.0],
        'BathTubs_Tinas' => ['adValorem' => 0.2, 'arancelEspecifico' => 0.0],
        'ProtectoresParaIpods' => ['adValorem' => 0.2, 'arancelEspecifico' => 0.0],
        'ProyectoresDeImagen_DeLuz' => ['adValorem' => 0.2, 'arancelEspecifico' => 0.0],
        'CineEnCasa' => ['adValorem' => 0.2, 'arancelEspecifico' => 0.0],
        'EquiposDeGrabacionYProduccion' => ['adValorem' => 0.2, 'arancelEspecifico' => 0.0],
        'DVRParaCamarasDeSeguridad' => ['adValorem' => 0.2, 'arancelEspecifico' => 0.0],
        'GrifosParaFregaderosDeCocina_KitchenFaucets' => ['adValorem' => 0.2, 'arancelEspecifico' => 0.0],
        'Cajas_PanelesElectricos' => ['adValorem' => 0.2, 'arancelEspecifico' => 0.0],
        'ShoppingCarts_CarritosDeCompras' => ['adValorem' => 0.2, 'arancelEspecifico' => 0.0],

        // ADVALOREM 15%
        'LavadoraDeRopa_Secadora' => ['adValorem' => 0.15, 'arancelEspecifico' => 0.0],
        'Celulares_NuevosSolamente' => ['adValorem' => 0.15, 'arancelEspecifico' => 0.0],
        'Ipods' => ['adValorem' => 0.15, 'arancelEspecifico' => 0.0],
        'Tablets' => ['adValorem' => 0.15, 'arancelEspecifico' => 0.0],
        'ComputadorasDeEscritorio' => ['adValorem' => 0.15, 'arancelEspecifico' => 0.0],
        'CamarasDeVideo' => ['adValorem' => 0.15, 'arancelEspecifico' => 0.0],
        'CamarasDeSeguridad' => ['adValorem' => 0.15, 'arancelEspecifico' => 0.0],
        'AspiradoraRobotica' => ['adValorem' => 0.15, 'arancelEspecifico' => 0.0],
        'PisosDeMaderaEspesorSuperiorA5mmPeroInferiorOIgualA9mm' => ['adValorem' => 0.15, 'arancelEspecifico' => 0.0],
        'PisoFlotanteDeEspesorSuperiorA9mm' => ['adValorem' => 0.15, 'arancelEspecifico' => 0.0],
        'Caladoras_Jigsaw' => ['adValorem' => 0.15, 'arancelEspecifico' => 0.0],
        'ManguerasDeAire' => ['adValorem' => 0.15, 'arancelEspecifico' => 0.0],

        // ADVALOREM 10%
        'RepuestosElectricosParaAutos' => ['adValorem' => 0.1, 'arancelEspecifico' => 0.0],
        'Bicicletas' => ['adValorem' => 0.1, 'arancelEspecifico' => 0.0],
        'TapaCubosYAccesorios' => ['adValorem' => 0.1, 'arancelEspecifico' => 0.0],
        'EquiposElectronicos' => ['adValorem' => 0.1, 'arancelEspecifico' => 0.0],
        'Amplificadores_Parlantes' => ['adValorem' => 0.1, 'arancelEspecifico' => 0.0],
        'AspiradoraPartes' => ['adValorem' => 0.1, 'arancelEspecifico' => 0.0],
        'SoundBars' => ['adValorem' => 0.1, 'arancelEspecifico' => 0.0],

        // ADVALOREM 5%
        'MaquinaParaHacerHelados' => ['adValorem' => 0.05, 'arancelEspecifico' => 0.0],
        'CamarasDeTelevision' => ['adValorem' => 0.05, 'arancelEspecifico' => 0.0],
        'ImpresorasWirless' => ['adValorem' => 0.05, 'arancelEspecifico' => 0.0],
        'ImpresorasIndustriales' => ['adValorem' => 0.05, 'arancelEspecifico' => 0.0],
        'SoldadoraCautin' => ['adValorem' => 0.05, 'arancelEspecifico' => 0.0],
        'PartesDeAutoFiltrosGasolina' => ['adValorem' => 0.05, 'arancelEspecifico' => 0.0],
        'CamarasDeSeguridadConDVR' => ['adValorem' => 0.05, 'arancelEspecifico' => 0.0],
        'JuegoDeDadosAjustables' => ['adValorem' => 0.05, 'arancelEspecifico' => 0.0],
        'NivelesLaser_LaserLevel' => ['adValorem' => 0.05, 'arancelEspecifico' => 0.0],
        'PartesParaNivelesLaserTripoEtc' => ['adValorem' => 0.05, 'arancelEspecifico' => 0.0],
        'JuegoDeDestornilladores' => ['adValorem' => 0.05, 'arancelEspecifico' => 0.0],
        'SierraVerticalDeCinta' => ['adValorem' => 0.05, 'arancelEspecifico' => 0.0],
        'HerramientasDeTaladrarORascarPTHOIncluidasLasTerrajasPTHC' => ['adValorem' => 0.05, 'arancelEspecifico' => 0.0],
        'TaladrosInalambricos_Driles' => ['adValorem' => 0.05, 'arancelEspecifico' => 0.0],
        'Drone' => ['adValorem' => 0.05, 'arancelEspecifico' => 0.0],
        'TelevisoresMayorA20EXSYMenorOIgualA32EXSPulgadas' => ['adValorem' => 0.05, 'arancelEspecifico' => 73.11],
        'TelevisoresMayorA32EXSYMenorOIgualA41EXSPulgadas' => ['adValorem' => 0.05, 'arancelEspecifico' => 140.32],
        'TelevisoresMayorA41EXSYMenorOIgualA75EXSPulgadas' => ['adValorem' => 0.05, 'arancelEspecifico' => 158.14],

        // ADVALOREM 4%
        'GafasVirtualReality' => ['adValorem' => 0.04, 'arancelEspecifico' => 0.0],
        'HerramientasDeMano' => ['adValorem' => 0.15, 'arancelEspecifico' => 0.0],

        // ADVALOREM 0% (pero con adValorem 0.3)
        'SierrasDeMesa' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'SierrasParaCarpinteria' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'SierraIngletadora' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'PowerWash' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'CortadoraDeCesped' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'CocinaInduccionElectricaSinHorno' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'HornosDeInduccionElectricos_Microondas' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'ExtractorDeJugos' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'FiltrosExtractorDeCocina' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'BujiasParaAutos' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'RepuestosParaAutos' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'JuegoDeArosParaCarrosOAutomoviles' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'RuedasYSusPartes' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'SincronizadorDeVehiculo' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'Computer_CPU' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'RepuestosParaComputadoras' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'SystemaGPS' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'AlarmasComerciales_Residenciales' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'HogarDecorativos_Cintas' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'Soldadoras' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'PisoFlotante' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'DiagnosticadorDeAutos' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'SmartphonesNuevos' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'PartesDeAutoFiltrosDeAire' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'PartesDeAutoAireAcondicionado' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'Smartwatch' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'CerradurasInteligentes' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'AirCompresorDePotenciaInferiorA30kwPTHO40hpPTHC' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'Amoladoras' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'CNCRouterMachine' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'Fresadora' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'SierraEscuadradora_SlidingTableSaw' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'UtilesDeTaladrarBrocasParaHamerDrill' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'HamerDrill' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'KitchenSinks_Fregaderos' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'PistolasParaPintar_SprayGun' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
        'Laptos' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0, 'newPercent' => 0.12],
        'PrendasDeVestirYCalzado' => ['adValorem' => 0.3, 'arancelEspecifico' => 0.0],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tarifas de Envío
    |--------------------------------------------------------------------------
    */
    'shipping_rates' => [
        'maritimo' => [
            // Formato: [peso_min, peso_max, costo_por_libra]
            // null en peso_max significa "hasta infinito"
            [10, 99, 4.0],
            [100, 199, 3.75],
            [200, 299, 3.5],
            [300, 399, 3.25],
            [400, 499, 3.0],
            [500, 599, 2.75],
            [600, 699, 2.55],
            [700, 799, 2.35],
            [800, 899, 2.3],
            [900, 1200, 2.25],
            [1200, 1500, 1.4],
            [1501, 2000, 1.3],
            [2001, null, 1.25], // null = sin límite superior
        ],
        'aereo' => [
            // Casos especiales para pesos exactos
            [1, 1, 19.8],    // Para peso 1, el costo total es 19.8, se divide por peso
            [2, 2, 11.54],
            [3, 3, 9.8],
            [4, 4, 8.24],
            [5, 5, 7.52],
            [6, 6, 7.23],
            [7, 7, 6.95],
            [8, 8, 6.75],
            [9, 9, 6.63],
            // Rangos
            [10, 19, 5.86],
            [20, 29, 5.4],
            [30, 39, 5.21],
            [40, 49, 5.13],
            [50, 59, 5.08],
            [60, 69, 4.95],
            [70, 79, 4.95],  // Rango faltante completado
            [80, 99, 3.67],
            [100, 139, 3.6],
            [140, 149, 3.55],
            [150, 199, 3.55],
            [200, 279, 3.49],
            [280, 499, 3.45],
            [500, null, 3.42], // null = sin límite superior
        ],
        'aereoExpres' => [
            [50, 99, 12.16],
            [100, 149, 8.03],
            [150, 199, 6.02],
            [200, null, 5.3], // null = sin límite superior (aunque hay validación de max 200)
        ],
        'courier4x4' => [
            // Régimen Courier 4x4 - Arancel fijo de $20
            // Peso máximo: 4kg (8.82 lbs), Valor FOB máximo: $400
            // Vigente desde 16 de junio de 2025
            [0.01, 8.82, 20.00], // Costo fijo, no por libra
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Impuestos Fijos
    |--------------------------------------------------------------------------
    */
    'taxes' => [
        'fodinfa' => 0.005,      // 0.5% - Fondo de Desarrollo de la Infraestructura Nacional
        'iva' => 0.15,            // 15% - Impuesto al Valor Agregado (actualizado desde abril 2024)
        'seguro_cif' => 0.025,   // 2.5% - Seguro sobre valor CIF
    ],

    /*
    |--------------------------------------------------------------------------
    | Validaciones
    |--------------------------------------------------------------------------
    */
    'validations' => [
        'maritimo_min_weight' => 100,
        'aereoExpres_min_weight' => 50,
        'aereoExpres_max_weight' => 200,
        'courier4x4_max_weight' => 8.82, // 4 kg en libras
        'courier4x4_max_value_fob' => 400, // Valor FOB máximo en USD
        'prendas_max_weight' => 8,
    ],
];

