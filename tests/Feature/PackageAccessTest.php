<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PackageAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_refresh_without_carrier_data_preserves_the_registered_maritime_status(): void
    {
        config(['services.trackingmore.api_key' => null]);
        $owner = User::factory()->create();
        $package = Package::create([
            'user_id' => $owner->id,
            'tracking_number' => 'FRILCLDEMO002',
            'status' => 'in_transit',
        ]);

        $this->actingAs($owner)->post(route('packages.refresh', $package->tracking_number))
            ->assertRedirect(route('packages.show', $package->tracking_number));

        $this->assertSame('in_transit', $package->fresh()->status);
    }

    public function test_public_tracking_displays_an_in_transit_maritime_reference(): void
    {
        $this->withoutVite();
        $number = 'FRILCLDEMO001';
        Package::create(['tracking_number' => $number, 'status' => 'in_transit']);
        Http::fake();

        $result = route('tracking.show', ['trackingNumber' => $number]);
        $this->post(route('tracking.search'), ['tracking_number' => $number])->assertRedirect($result);
        $this->get($result)->assertOk()->assertSee($number)->assertSee('En Tránsito');
        Http::assertNothingSent();
    }

    public function test_admin_can_register_and_update_a_public_tracking_history(): void
    {
        $this->withoutVite();
        Http::fake();
        $admin = User::factory()->create(['role' => 'admin']);
        $number = 'TEST-MANUAL-2026';
        $data = ['tracking_number' => $number, 'carrier' => 'USPS', 'status' => 'in_transit'];
        $this->actingAs($admin)->post(route('admin.packages.store'), $data)
            ->assertRedirect(route('admin.packages.index'));
        $package = Package::where('tracking_number', $number)->firstOrFail();

        $this->put(route('admin.packages.update', $package->id), array_replace($data, [
            'status' => 'delivered',
            'event_description' => 'Entregado en el buzón',
            'event_location' => 'Ridgewood, NY',
            'notes' => 'Private admin note',
        ]))->assertRedirect(route('admin.packages.index'));

        $this->get(route('tracking.show', $number))->assertOk()
            ->assertSee('Entregado en el buzón')->assertSee('Ridgewood, NY')
            ->assertSee('Ver todo el historial')->assertSee('En tránsito')
            ->assertDontSee('Private admin note');
        $this->assertCount(2, $package->fresh()->tracking_history);
        Http::assertNothingSent();
    }

    public function test_public_tracking_only_shows_status_for_an_exact_match(): void
    {
        $this->withoutVite();
        Package::create([
            'tracking_number' => 'TEST12345',
            'status' => 'delivered',
            'notes' => 'Private package note',
            'destination' => 'Private destination',
        ]);
        config(['services.trackingmore.api_key' => null]);

        $this->get('/tracking/TEST12345')->assertOk()
            ->assertSee('Entregado')
            ->assertDontSee('Private package note')
            ->assertDontSee('Private destination');
        $this->get('/tracking/TEST123')->assertRedirect(route('tracking.index'));
    }

    public function test_a_customer_cannot_claim_or_access_an_existing_package(): void
    {
        $owner = User::factory()->create();
        $customer = User::factory()->create();
        $package = Package::create([
            'tracking_number' => 'TEST12345',
            'user_id' => $owner->id,
            'status' => 'delivered',
        ]);
        $this->actingAs($customer);

        $this->post('/mis-paquetes', ['tracking_number' => $package->tracking_number])->assertNotFound();
        $this->get('/mis-paquetes/'.$package->tracking_number)->assertNotFound();
        $this->post('/mis-paquetes/'.$package->tracking_number.'/refresh')->assertNotFound();
        $this->assertSame($owner->id, $package->fresh()->user_id);
    }
}
