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

    public function test_apple_uses_a_secure_nonce_cookie_and_rejects_callbacks_without_it(): void
    {
        config([
            'services.apple.client_id' => 'com.example.signin',
            'services.apple.team_id' => 'test-team',
            'services.apple.key_id' => 'test-key',
            'services.apple.private_key' => __FILE__,
            'services.apple.redirect' => 'https://leranuva.com/auth/apple/callback',
        ]);

        $redirect = $this->get(route('auth.apple.redirect'))->assertRedirect();
        $this->assertStringStartsWith('https://appleid.apple.com/', $redirect->headers->get('Location'));
        $redirect->assertCookie('socialite_apple_nonce');

        $this->post(route('auth.apple.callback'))->assertRedirect(route('login'));
        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_facebook_registration_requires_local_email_verification(): void
    {
        config(['services.facebook.client_id' => 'test', 'services.facebook.client_secret' => 'test']);
        Notification::fake();
        Socialite::shouldReceive('driver->user')->once()->andReturn((new SocialUser)->map([
            'id' => '9876', 'name' => 'Ana', 'email' => 'ana@example.com',
        ]));

        $this->get(route('auth.facebook.callback'))->assertRedirect(route('verification.notice'));

        $user = User::where('facebook_id', '9876')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertFalse($user->hasVerifiedEmail());
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_google_links_an_existing_verified_gmail_customer(): void
    {
        config(['services.google.client_id' => 'test', 'services.google.client_secret' => 'test']);
        $user = User::factory()->create(['email' => 'ana@gmail.com']);
        Socialite::shouldReceive('driver->user')->once()->andReturn(
            (new SocialUser)->setRaw(['verified_email' => true])->map([
                'id' => 'google-123', 'email' => $user->email,
            ])
        );

        $this->get(route('auth.google.callback'))->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
        $this->assertSame('google-123', $user->fresh()->google_id);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_google_does_not_link_an_existing_admin(): void
    {
        config(['services.google.client_id' => 'test', 'services.google.client_secret' => 'test']);
        $user = User::factory()->create(['email' => 'admin@gmail.com', 'role' => 'admin']);
        Socialite::shouldReceive('driver->user')->once()->andReturn(
            (new SocialUser)->setRaw(['verified_email' => true])->map([
                'id' => 'google-123', 'email' => $user->email,
            ])
        );

        $this->get(route('auth.google.callback'))->assertRedirect(route('login'));
        $this->assertGuest();
        $this->assertNull($user->fresh()->google_id);
    }

    public function test_existing_admin_can_link_google_from_a_confirmed_session(): void
    {
        config(['services.google.client_id' => 'test', 'services.google.client_secret' => 'test']);
        $user = User::factory()->create(['role' => 'admin', 'email' => 'admin@gmail.com']);

        $this->actingAs($user)->get(route('profile.google.link'))
            ->assertRedirect(route('password.confirm'));

        Socialite::shouldReceive('driver->redirect')->once()->andReturn(redirect('https://accounts.google.com/'));
        Socialite::shouldReceive('driver->user')->twice()->andReturn(
            (new SocialUser)->setRaw(['verified_email' => true])->map([
                'id' => 'google-admin', 'email' => $user->email,
            ])
        );

        $this->withSession(['auth.password_confirmed_at' => time()])->get(route('profile.google.link'))
            ->assertRedirect('https://accounts.google.com/');
        $this->get(route('auth.google.callback'))->assertRedirect(route('profile.edit'));
        $this->assertSame('google-admin', $user->fresh()->google_id);

        $this->post(route('logout'));
        $this->get(route('auth.google.callback'))->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }
}
