<?php

namespace Tests\Unit;

use App\Models\TaxRate;
use App\Services\Cotizador\TaxCalculator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaxCalculatorTest extends TestCase
{
    use RefreshDatabase;

    private TaxCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new TaxCalculator;
    }

    public function test_calcula_impuestos_correctamente_sin_courier4x4(): void
    {
        $result = $this->calculator->calculate(
            productCost: 100,
            shippingCost: 0,
            adValorem: 0.15,
            arancelEspecifico: 0,
            shippingMethod: 'maritimo',
            isCourier4x4Valid: false
        );

        $this->assertSame(15.0, $result['impuestoAdvalorem']);
        $this->assertGreaterThan(0, $result['impuestoFodinfa']);
        $this->assertGreaterThan(0, $result['impuestoIva']);
        $this->assertSame(0.0, $result['arancelEspecifico']);
        $this->assertGreaterThan($result['impuestoAdvalorem'], $result['totalImpuestos']);
    }

    public function test_courier4x4_valido_no_cobra_impuestos(): void
    {
        $result = $this->calculator->calculate(
            productCost: 100,
            shippingCost: 25,
            adValorem: 0.15,
            arancelEspecifico: 0,
            shippingMethod: 'courier4x4',
            isCourier4x4Valid: true
        );

        $this->assertEquals(0, $result['impuestoAdvalorem']);
        $this->assertEquals(0, $result['impuestoFodinfa']);
        $this->assertEquals(0, $result['impuestoIva']);
        $this->assertEquals(0, $result['arancelEspecifico']);
        $this->assertEquals(0, $result['totalImpuestos']);
    }

    public function test_incluye_arancel_especifico(): void
    {
        $result = $this->calculator->calculate(
            productCost: 500,
            shippingCost: 0,
            adValorem: 0.05,
            arancelEspecifico: 73.11,
            shippingMethod: 'maritimo',
            isCourier4x4Valid: false
        );

        $this->assertSame(73.11, $result['arancelEspecifico']);
        $this->assertGreaterThanOrEqual(73.11, $result['totalImpuestos']);
    }

    public function test_usar_tasas_de_base_de_datos_si_existen(): void
    {
        TaxRate::create([
            'name' => 'fodinfa',
            'label' => 'Fodinfa',
            'rate' => 0.005,
            'is_active' => true,
        ]);
        TaxRate::create([
            'name' => 'iva',
            'label' => 'IVA',
            'rate' => 0.12,
            'is_active' => true,
        ]);

        $result = $this->calculator->calculate(
            productCost: 100,
            shippingCost: 0,
            adValorem: 0.1,
            arancelEspecifico: 0,
            shippingMethod: 'maritimo',
            isCourier4x4Valid: false
        );

        $this->assertSame(0.005, $result['fodinfa']);
        $this->assertSame(0.12, $result['iva']);
    }

    public function test_impuestos_porcentuales_usan_base_producto_mas_envio(): void
    {
        $result = $this->calculator->calculate(
            productCost: 100,
            shippingCost: 50,
            adValorem: 0.15,
            arancelEspecifico: 0,
            shippingMethod: 'maritimo',
            isCourier4x4Valid: false
        );

        $base = 150;
        $this->assertEqualsWithDelta(22.5, $result['impuestoAdvalorem'], 0.00001);
        $this->assertEqualsWithDelta(0.75, $result['impuestoFodinfa'], 0.00001);
        $expectedIva = ($base + $result['impuestoAdvalorem'] + $result['impuestoFodinfa']) * 0.12;
        $this->assertEqualsWithDelta($expectedIva, $result['impuestoIva'], 0.00001);
    }
}
