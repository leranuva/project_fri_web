<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_login_sends_a_link_and_restricts_the_account_until_verification(): void
    {
        Notification::fake();
        $user = User::factory()->unverified()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route('verification.notice'))
            ->assertSessionHas('status', 'verification-link-sent');

        $this->get('/')->assertRedirect(route('verification.notice'));
        $this->postJson(route('cotizador.calculate'))->assertForbidden();
        $this->post(route('verification.send'))->assertSessionHas('status', 'verification-link-recent');
        Notification::assertSentToTimes($user, VerifyEmail::class, 1);

        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(5), [
            'id' => $user->id,
            'hash' => sha1($user->email),
        ]);

        $this->get($url.'&changed=1')->assertForbidden();
        $this->assertFalse($user->fresh()->hasVerifiedEmail());

        $this->get($url)->assertRedirect('/dashboard?verified=1');
        $this->assertTrue($user->fresh()->hasVerifiedEmail());

        $this->withoutVite()->get('/profile')->assertOk();
    }
}
