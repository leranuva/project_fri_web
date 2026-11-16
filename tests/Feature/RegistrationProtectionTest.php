<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegistrationProtectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_rejects_markup_and_limits_repeated_attempts(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->postJson('/register', ['name' => '<a>Spam</a>'])
                ->assertUnprocessable()
                ->assertJsonValidationErrors('name');
        }

        $this->postJson('/register')->assertTooManyRequests();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_checks_turnstile_before_creating_a_user(): void
    {
        config([
            'app.url' => 'https://leranuva.com',
            'services.turnstile.site_key' => 'test-site',
            'services.turnstile.secret_key' => 'test-secret',
        ]);
        Notification::fake();
        Http::fake([
            'challenges.cloudflare.com/*' => Http::sequence()
                ->push(['success' => true, 'action' => 'register', 'hostname' => 'other.example'])
                ->push(['success' => true, 'action' => 'register', 'hostname' => 'leranuva.com']),
        ]);

        $fields = [
            'name' => 'María Anne-Marie O’Connor',
            'email' => 'customer@example.com',
            'password' => 'test-password',
            'password_confirmation' => 'test-password',
        ];
        $this->postJson('/register', $fields)->assertJsonValidationErrors('cf-turnstile-response');
        $this->postJson('/register', $fields + ['cf-turnstile-response' => 'wrong-host'])
            ->assertJsonValidationErrors('cf-turnstile-response');
        $this->assertDatabaseCount('users', 0);

        $this->post('/register', $fields + ['cf-turnstile-response' => 'valid'])
            ->assertRedirect(route('verification.notice'));
        $this->assertDatabaseHas('users', ['email' => 'customer@example.com', 'name' => $fields['name']]);
    }

    public function test_unverified_users_are_redirected_from_account_pages(): void
    {
        $this->actingAs(User::factory()->unverified()->create());

        foreach (['/profile', '/mis-cotizaciones', '/mis-paquetes'] as $path) {
            $this->get($path)->assertRedirect(route('verification.notice'));
        }
    }
}
