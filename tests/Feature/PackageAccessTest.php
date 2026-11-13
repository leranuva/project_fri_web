<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\User;
use App\Services\TrackingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PackageAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_tracking_only_shows_status_for_an_exact_match(): void
    {
        $this->withoutVite();
        Package::create([
            'tracking_number' => 'TEST12345',
            'status' => 'delivered',
            'notes' => 'Private package note',
            'destination' => 'Private destination',
        ]);
        $this->mock(TrackingService::class)
            ->shouldReceive('fetchTrackingInfo')->once()->with('TEST123')->andReturnNull();

        $this->get('/tracking/TEST12345')->assertOk()
            ->assertSee('Entregado')
            ->assertDontSee('Private package note')
            ->assertDontSee('Private destination');
        $this->get('/tracking/TEST123')->assertRedirect(route('home').'#tracking');
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
