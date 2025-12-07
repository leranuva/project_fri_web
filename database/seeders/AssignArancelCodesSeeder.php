<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class AssignArancelCodesSeeder extends Seeder
{
    /**
     * Mapeo de productos a códigos arancelarios
     * Basado en Sistema Armonizado (base de NANDINA)
     * 
     * ⚠️ IMPORTANTE: Estos códigos están basados en el Sistema Armonizado estándar.
     * Para garantizar precisión al 100%, DEBE verificar cada código en el Arancel Nacional oficial:
     * https://www.aduana.gob.ec/arancel-nacional/
     * 
     * Notas:
     * - Los códigos de 8 dígitos corresponden a NANDINA
     * - Los códigos de 10 dígitos incluyen los 2 dígitos nacionales de Ecuador
     * - Desde septiembre 2023 rige la Resolución COMEX Nro. 002-2023 (Séptima Enmienda)
     * - Ver documentación en: docs/GUIA_VERIFICACION_ARANCELES.md
     */
    private $arancelCodes = [
        // Electrodomésticos de cocina (Capítulo 85)
        'CocinasDeInduccion_Gas_Horno' => ['code' => '8516.60.00', 'subpartida' => '8516.60.00.00'],
        'OllasParaCocinaDeInducción' => ['code' => '8516.60.00', 'subpartida' => '8516.60.00.00'],
        'HornosConvection' => ['code' => '8516.60.00', 'subpartida' => '8516.60.00.00'],
        'ExtractorDeCocina_Hoods' => ['code' => '8414.80.00', 'subpartida' => '8414.80.00.00'],
        'Refrigeradora' => ['code' => '8418.10.00', 'subpartida' => '8418.10.00.00'],
        'RefrigeradoraKitchenAid' => ['code' => '8418.10.00', 'subpartida' => '8418.10.00.00'],
        'LavadoraDeRopa_Secadora' => ['code' => '8450.11.00', 'subpartida' => '8450.11.00.00'],
        'OllasDePresion' => ['code' => '7323.93.00', 'subpartida' => '7323.93.00.00'],
        'CuchillosDeCocina' => ['code' => '8211.91.00', 'subpartida' => '8211.91.00.00'],
        'ElectrodomesticosCocina' => ['code' => '8516.60.00', 'subpartida' => '8516.60.00.00'],
        'CocinaInduccionElectricaSinHorno' => ['code' => '8516.60.00', 'subpartida' => '8516.60.00.00'],
        'HornosDeInduccionElectricos_Microondas' => ['code' => '8516.50.00', 'subpartida' => '8516.50.00.00'],
        'ExtractorDeJugos' => ['code' => '8509.40.00', 'subpartida' => '8509.40.00.00'],
        'FiltrosExtractorDeCocina' => ['code' => '8414.80.00', 'subpartida' => '8414.80.00.00'],
        'KitchenSinks_Fregaderos' => ['code' => '7324.10.00', 'subpartida' => '7324.10.00.00'],
        'GrifosParaFregaderosDeCocina_KitchenFaucets' => ['code' => '8481.80.00', 'subpartida' => '8481.80.00.00'],
        'UtenciliosParaMesa_CocinaYPlatosParaServicioDeMesa_Cocina' => ['code' => '6911.10.00', 'subpartida' => '6911.10.00.00'],
        'MueblesDeMaderaParaCocina' => ['code' => '9403.40.00', 'subpartida' => '9403.40.00.00'],
        
        // Productos para bebés (Capítulo 94, 95)
        'AsientosParaBebe' => ['code' => '9401.30.00', 'subpartida' => '9401.30.00.00'],
        'JuguetesYAccesoriosParaBebe' => ['code' => '9503.00.00', 'subpartida' => '9503.00.00.00'],
        'Jugueteria' => ['code' => '9503.00.00', 'subpartida' => '9503.00.00.00'],
        'Triciclos_Patines_CochesConRuedas' => ['code' => '9503.00.00', 'subpartida' => '9503.00.00.00'],
        
        // Bicicletas (Capítulo 87)
        'BicicletasElectricas' => ['code' => '8711.60.00', 'subpartida' => '8711.60.00.00'],
        'Bicicletas' => ['code' => '8712.00.00', 'subpartida' => '8712.00.00.00'],
        'KitElectricoParaBicicleta' => ['code' => '8507.80.00', 'subpartida' => '8507.80.00.00'],
        
        // Electrónica y computadoras (Capítulo 84, 85)
        'Laptos' => ['code' => '8471.30.00', 'subpartida' => '8471.30.00.00'],
        'Tablets' => ['code' => '8471.30.00', 'subpartida' => '8471.30.00.00'],
        'ComputadorasDeEscritorio' => ['code' => '8471.50.00', 'subpartida' => '8471.50.00.00'],
        'Computer_CPU' => ['code' => '8471.50.00', 'subpartida' => '8471.50.00.00'],
        'RepuestosParaComputadoras' => ['code' => '8473.30.00', 'subpartida' => '8473.30.00.00'],
        'Celulares_NuevosSolamente' => ['code' => '8517.12.00', 'subpartida' => '8517.12.00.00'],
        'SmartphonesNuevos' => ['code' => '8517.12.00', 'subpartida' => '8517.12.00.00'],
        'Ipods' => ['code' => '8519.81.00', 'subpartida' => '8519.81.00.00'],
        'ProtectoresParaIpods' => ['code' => '4202.12.00', 'subpartida' => '4202.12.00.00'],
        
        // Audio y video (Capítulo 85)
        'RadiosParaCarros' => ['code' => '8527.21.00', 'subpartida' => '8527.21.00.00'],
        'AudifonosGamerConCasco' => ['code' => '8518.30.00', 'subpartida' => '8518.30.00.00'],
        'AudifonosAirpodsInalambricos' => ['code' => '8518.30.00', 'subpartida' => '8518.30.00.00'],
        'ProyectoresDeImagen_DeLuz' => ['code' => '8528.62.00', 'subpartida' => '8528.62.00.00'],
        'CineEnCasa' => ['code' => '8518.21.00', 'subpartida' => '8518.21.00.00'],
        'EquiposDeGrabacionYProduccion' => ['code' => '8519.81.00', 'subpartida' => '8519.81.00.00'],
        'Amplificadores_Parlantes' => ['code' => '8518.40.00', 'subpartida' => '8518.40.00.00'],
        'SoundBars' => ['code' => '8518.40.00', 'subpartida' => '8518.40.00.00'],
        'CamarasDeVideo' => ['code' => '8525.80.00', 'subpartida' => '8525.80.00.00'],
        'CamarasDeTelevision' => ['code' => '8525.80.00', 'subpartida' => '8525.80.00.00'],
        'CamarasDeSeguridad' => ['code' => '8525.80.00', 'subpartida' => '8525.80.00.00'],
        'DVRParaCamarasDeSeguridad' => ['code' => '8521.90.00', 'subpartida' => '8521.90.00.00'],
        'CamarasDeSeguridadConDVR' => ['code' => '8525.80.00', 'subpartida' => '8525.80.00.00'],
        'AlarmasComerciales_Residenciales' => ['code' => '8531.10.00', 'subpartida' => '8531.10.00.00'],
        
        // Televisores (Capítulo 85)
        'TelevisoresMayorA20EXSYMenorOIgualA32EXSPulgadas' => ['code' => '8528.72.00', 'subpartida' => '8528.72.00.00'],
        'TelevisoresMayorA32EXSYMenorOIgualA41EXSPulgadas' => ['code' => '8528.72.00', 'subpartida' => '8528.72.00.00'],
        'TelevisoresMayorA41EXSYMenorOIgualA75EXSPulgadas' => ['code' => '8528.72.00', 'subpartida' => '8528.72.00.00'],
        
        // Herramientas (Capítulo 82, 84)
        'HerramientasDeMano' => ['code' => '8205.40.00', 'subpartida' => '8205.40.00.00'],
        'Caladoras_Jigsaw' => ['code' => '8461.50.00', 'subpartida' => '8461.50.00.00'],
        'TaladrosInalambricos_Driles' => ['code' => '8467.21.00', 'subpartida' => '8467.21.00.00'],
        'SierrasDeMesa' => ['code' => '8461.10.00', 'subpartida' => '8461.10.00.00'],
        'SierrasParaCarpinteria' => ['code' => '8461.10.00', 'subpartida' => '8461.10.00.00'],
        'SierraIngletadora' => ['code' => '8461.10.00', 'subpartida' => '8461.10.00.00'],
        'SoporteDeSierraInglentadora' => ['code' => '8466.93.00', 'subpartida' => '8466.93.00.00'],
        'SierraVerticalDeCinta' => ['code' => '8461.10.00', 'subpartida' => '8461.10.00.00'],
        'SierraEscuadradora_SlidingTableSaw' => ['code' => '8461.10.00', 'subpartida' => '8461.10.00.00'],
        'HerramientasDeTaladrarORascarPTHOIncluidasLasTerrajasPTHC' => ['code' => '8207.50.00', 'subpartida' => '8207.50.00.00'],
        'UtilesDeTaladrarBrocasParaHamerDrill' => ['code' => '8207.50.00', 'subpartida' => '8207.50.00.00'],
        'HamerDrill' => ['code' => '8467.21.00', 'subpartida' => '8467.21.00.00'],
        'JuegoDeDestornilladores' => ['code' => '8205.40.00', 'subpartida' => '8205.40.00.00'],
        'JuegoDeDadosAjustables' => ['code' => '8205.40.00', 'subpartida' => '8205.40.00.00'],
        'SoldadoraCautin' => ['code' => '8515.80.00', 'subpartida' => '8515.80.00.00'],
        'Soldadoras' => ['code' => '8515.80.00', 'subpartida' => '8515.80.00.00'],
        'Amoladoras' => ['code' => '8467.29.00', 'subpartida' => '8467.29.00.00'],
        'Fresadora' => ['code' => '8465.93.00', 'subpartida' => '8465.93.00.00'],
        'CNCRouterMachine' => ['code' => '8465.93.00', 'subpartida' => '8465.93.00.00'],
        'NivelesLaser_LaserLevel' => ['code' => '9031.80.00', 'subpartida' => '9031.80.00.00'],
        'PartesParaNivelesLaserTripoEtc' => ['code' => '9031.90.00', 'subpartida' => '9031.90.00.00'],
        'ManguerasDeAire' => ['code' => '4009.12.00', 'subpartida' => '4009.12.00.00'],
        'AirCompresorDePotenciaInferiorA30kwPTHO40hpPTHC' => ['code' => '8414.80.00', 'subpartida' => '8414.80.00.00'],
        'PistolasParaPintar_SprayGun' => ['code' => '8424.20.00', 'subpartida' => '8424.20.00.00'],
        'PowerWash' => ['code' => '8424.20.00', 'subpartida' => '8424.20.00.00'],
        'CortadoraDeCesped' => ['code' => '8433.11.00', 'subpartida' => '8433.11.00.00'],
        
        // Repuestos automotrices (Capítulo 87)
        'RepuestosElectricosParaAutos' => ['code' => '8512.20.00', 'subpartida' => '8512.20.00.00'],
        'RepuestosParaAutos' => ['code' => '8708.99.00', 'subpartida' => '8708.99.00.00'],
        'BujiasParaAutos' => ['code' => '8511.30.00', 'subpartida' => '8511.30.00.00'],
        'JuegoDeArosParaCarrosOAutomoviles' => ['code' => '8708.70.00', 'subpartida' => '8708.70.00.00'],
        'RuedasYSusPartes' => ['code' => '8708.70.00', 'subpartida' => '8708.70.00.00'],
        'TapaCubosYAccesorios' => ['code' => '8708.99.00', 'subpartida' => '8708.99.00.00'],
        'SincronizadorDeVehiculo' => ['code' => '9031.80.00', 'subpartida' => '9031.80.00.00'],
        'DiagnosticadorDeAutos' => ['code' => '9031.80.00', 'subpartida' => '9031.80.00.00'],
        'PartesDeAutoFiltrosGasolina' => ['code' => '8421.23.00', 'subpartida' => '8421.23.00.00'],
        'PartesDeAutoFiltrosDeAire' => ['code' => '8421.23.00', 'subpartida' => '8421.23.00.00'],
        'PartesDeAutoAireAcondicionado' => ['code' => '8415.90.00', 'subpartida' => '8415.90.00.00'],
        
        // Otros productos
        'Bisuteria_Relojes_Joyas' => ['code' => '7117.19.00', 'subpartida' => '7117.19.00.00'],
        'MaquinasDeCoser' => ['code' => '8452.10.00', 'subpartida' => '8452.10.00.00'],
        'SmartToilets_SanitariosInteligentes' => ['code' => '6910.10.00', 'subpartida' => '6910.10.00.00'],
        'BathTubs_Tinas' => ['code' => '6910.10.00', 'subpartida' => '6910.10.00.00'],
        'AspiradoraRobotica' => ['code' => '8508.11.00', 'subpartida' => '8508.11.00.00'],
        'AspiradoraPartes' => ['code' => '8508.70.00', 'subpartida' => '8508.70.00.00'],
        'PisosDeMaderaEspesorSuperiorA5mmPeroInferiorOIgualA9mm' => ['code' => '4409.10.00', 'subpartida' => '4409.10.00.00'],
        'PisoFlotanteDeEspesorSuperiorA9mm' => ['code' => '4409.10.00', 'subpartida' => '4409.10.00.00'],
        'PisoFlotante' => ['code' => '4409.10.00', 'subpartida' => '4409.10.00.00'],
        'RepuestosElectricosParaAutos' => ['code' => '8512.20.00', 'subpartida' => '8512.20.00.00'],
        'EquiposElectronicos' => ['code' => '8543.70.00', 'subpartida' => '8543.70.00.00'],
        'MaquinaParaHacerHelados' => ['code' => '8418.69.00', 'subpartida' => '8418.69.00.00'],
        'ImpresorasWirless' => ['code' => '8443.32.00', 'subpartida' => '8443.32.00.00'],
        'ImpresorasIndustriales' => ['code' => '8443.32.00', 'subpartida' => '8443.32.00.00'],
        'Cajas_PanelesElectricos' => ['code' => '8537.10.00', 'subpartida' => '8537.10.00.00'],
        'ShoppingCarts_CarritosDeCompras' => ['code' => '8716.80.00', 'subpartida' => '8716.80.00.00'],
        'SystemaGPS' => ['code' => '8526.91.00', 'subpartida' => '8526.91.00.00'],
        'HogarDecorativos_Cintas' => ['code' => '6307.90.00', 'subpartida' => '6307.90.00.00'],
        'Smartwatch' => ['code' => '9102.12.00', 'subpartida' => '9102.12.00.00'],
        'CerradurasInteligentes' => ['code' => '8301.40.00', 'subpartida' => '8301.40.00.00'],
        'GafasVirtualReality' => ['code' => '9001.50.00', 'subpartida' => '9001.50.00.00'],
        'Drone' => ['code' => '8802.11.00', 'subpartida' => '8802.11.00.00'],
        'PrendasDeVestirYCalzado' => ['code' => '6403.99.00', 'subpartida' => '6403.99.00.00'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Asignando códigos arancelarios a productos...');
        
        $updated = 0;
        $notFound = [];
        
        foreach ($this->arancelCodes as $key => $codes) {
            $product = Product::where('key', $key)->first();
            
            if ($product) {
                $product->update([
                    'arancel_code' => $codes['code'],
                    'arancel_subpartida' => $codes['subpartida'],
                ]);
                $updated++;
            } else {
                $notFound[] = $key;
            }
        }
        
        $this->command->info("✓ Códigos arancelarios asignados: {$updated}");
        
        if (!empty($notFound)) {
            $this->command->warn("⚠ Productos no encontrados: " . count($notFound));
            foreach ($notFound as $key) {
                $this->command->warn("  - {$key}");
            }
        }
        
        $this->command->info("\n⚠ IMPORTANTE:");
        $this->command->info("   Estos códigos están basados en el Sistema Armonizado estándar.");
        $this->command->info("   Para garantizar precisión al 100%, verifique cada código en:");
        $this->command->info("   https://www.aduana.gob.ec/arancel-nacional/");
        $this->command->info("\n   Consulte la guía completa en: docs/GUIA_VERIFICACION_ARANCELES.md");
    }
}
