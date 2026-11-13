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

    public function test_catalogo_refleja_activacion_de_productos_con_cache_caliente(): void
    {
        $product = Product::findByKey('Celulares_NuevosSolamente');
        $product->update(['is_active' => false]);

        $this->getJson('/api/cotizador/data')
            ->assertOk()
            ->assertJsonPath('data.products', []);

        $product->update(['is_active' => true]);
        $this->getJson('/api/cotizador/data')
            ->assertOk()
            ->assertJsonPath('data.products.Celulares_NuevosSolamente.name', 'Celulares Nuevos');

        $newProduct = $product->replicate()->fill(['key' => 'Nuevo', 'is_active' => false]);
        $newProduct->save();
        $this->getJson('/api/cotizador/data')
            ->assertOk()
            ->assertJsonMissingPath('data.products.Nuevo');

        $newProduct->update(['is_active' => true]);
        $this->getJson('/api/cotizador/data')
            ->assertOk()
            ->assertJsonPath('data.products.Nuevo.name', 'Celulares Nuevos');
    }

    public function test_catalogo_actualiza_rangos_y_metodos_al_editar_tarifas(): void
    {
        $this->getJson('/api/cotizador/data')
            ->assertOk()
            ->assertJsonPath('data.shippingMethodRanges.maritimo.max_weight', 99);

        $rate = ShippingRate::forMethod('maritimo')->firstOrFail();
        $rate->update(['max_weight' => null]);
        $this->getJson('/api/cotizador/data')
            ->assertOk()
            ->assertJsonPath('data.shippingMethodRanges.maritimo.has_unlimited', true)
            ->assertJsonPath('data.shippingMethodRanges.maritimo.ranges.0.max', null);

        $rate->update(['is_active' => false]);
        $this->getJson('/api/cotizador/data')
            ->assertOk()
            ->assertJsonMissingPath('data.shippingMethodRanges.maritimo');
    }

    public function test_formulario_y_widget_renderizan_el_catalogo(): void
    {
        $this->withoutVite();

        foreach (['/cotizador', '/embed/cotizador'] as $url) {
            $this->get($url)
                ->assertOk()
                ->assertViewHas('shippingMethods', fn (array $methods) => in_array('maritimo', $methods, true))
                ->assertViewHas('products', fn ($products) => $products->contains('key', 'Celulares_NuevosSolamente'));
        }
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
