<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ShippingRate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CotizadorTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedTestData();
    }

    private function seedTestData(): void
    {
        Product::create([
            'key' => 'Celulares_NuevosSolamente',
            'name' => 'Celulares Nuevos',
            'ad_valorem' => 0.15,
            'arancel_especifico' => 0,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        ShippingRate::create([
            'method' => 'maritimo',
            'min_weight' => 10,
            'max_weight' => 99,
            'cost_per_pound' => 4.0,
            'fixed_cost' => 0,
            'is_special_case' => false,
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }

    public function test_get_products_retorna_lista(): void
    {
        $response = $this->getJson('/api/cotizador/products');

        $response->assertOk()
            ->assertJson(['success' => true])
            ->assertJsonStructure(['data' => [['key', 'name', 'adValorem', 'arancelEspecifico']]]);
    }

    public function test_get_shipping_methods_retorna_metodos(): void
    {
        $response = $this->getJson('/api/cotizador/shipping-methods');

        $response->assertOk()
            ->assertJson(['success' => true])
            ->assertJsonFragment(['maritimo']);
    }

    public function test_calculate_retorna_cotizacion_valida(): void
    {
        $response = $this->postJson('/api/cotizador/calculate', [
            'product' => 'Celulares_NuevosSolamente',
            'quantity' => 1,
            'weight' => 15,
            'unitValue' => 200,
            'shippingMethod' => 'maritimo',
        ]);

        $response->assertOk()
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'data' => [
                    'productCost',
                    'shippingCost',
                    'totalImpuestos',
                    'totalCotizacion',
                    'weight',
                ],
            ]);

        $data = $response->json('data');
        $this->assertGreaterThan(0, $data['totalCotizacion']);
        $this->assertEquals(15, $data['weight']);
    }

    public function test_calculate_rechaza_producto_invalido(): void
    {
        $response = $this->postJson('/api/cotizador/calculate', [
            'product' => 'selectProducto',
            'quantity' => 1,
            'weight' => 15,
            'unitValue' => 200,
            'shippingMethod' => 'maritimo',
        ]);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_calculate_rechaza_metodo_envio_invalido(): void
    {
        $response = $this->postJson('/api/cotizador/calculate', [
            'product' => 'Celulares_NuevosSolamente',
            'quantity' => 1,
            'weight' => 15,
            'unitValue' => 200,
            'shippingMethod' => 'metodo_inexistente',
        ]);

        $response->assertStatus(422);
    }

    public function test_calculate_rechaza_peso_fuera_de_rango(): void
    {
        $response = $this->postJson('/api/cotizador/calculate', [
            'product' => 'Celulares_NuevosSolamente',
            'quantity' => 1,
            'weight' => 5,
            'unitValue' => 200,
            'shippingMethod' => 'maritimo',
        ]);

        $response->assertStatus(422);
    }
}
