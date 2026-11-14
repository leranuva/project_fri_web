<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialUser;
use Tests\TestCase;

class SocialRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_x_registration_requires_local_email_verification(): void
    {
        config(['services.twitter.client_id' => 'test', 'services.twitter.client_secret' => 'test']);
        Notification::fake();
        Socialite::shouldReceive('driver->user')->once()->andReturn((new SocialUser)->map([
            'id' => '12345', 'name' => 'Ana', 'email' => 'ana@example.com',
        ]));

        $this->get(route('auth.x.callback'))->assertRedirect(route('verification.notice'));

        $user = User::where('x_id', '12345')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertFalse($user->hasVerifiedEmail());
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_x_cannot_link_an_existing_account_by_email(): void
    {
        config(['services.twitter.client_id' => 'test', 'services.twitter.client_secret' => 'test']);
        $user = User::factory()->create();
        Socialite::shouldReceive('driver->user')->once()->andReturn((new SocialUser)->map([
            'id' => '12345', 'email' => $user->email,
        ]));

        $this->get(route('auth.x.callback'))->assertRedirect(route('login'));
        $this->assertGuest();
        $this->assertNull($user->fresh()->x_id);
    }
}
