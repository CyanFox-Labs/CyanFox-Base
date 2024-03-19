<?php

namespace Tests\Feature\Livewire\Auth;

use App\Livewire\Auth\ForgotPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $this->get(route('auth.forgot-password', ''))
            ->assertStatus(200);

        $user = User::factory()->create([
            'password_reset_token' => 'token',
            'password_reset_expiration' => now()->addHour(),
        ]);

        $this->get(route('auth.forgot-password', 'token'))
            ->assertStatus(200);
    }

    /** @test */
    public function can_reset_password(): void
    {
        $user = User::factory()->create([
            'password_reset_token' => 'token',
            'password_reset_expiration' => now()->addHour(),
        ]);

        Livewire::test(ForgotPassword::class)
            ->set('password', 'kXqz=k^zwu7d^;UrMPNF')
            ->set('passwordConfirmation', 'kXqz=k^zwu7d^;UrMPNF')
            ->set('resetToken', 'token')
            ->call('resetPassword');

        $this->assertTrue(Hash::check('kXqz=k^zwu7d^;UrMPNF', $user->fresh()->password));
    }
}
