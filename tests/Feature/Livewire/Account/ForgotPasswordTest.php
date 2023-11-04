<?php

namespace Tests\Feature\Livewire\Account;

use App\Livewire\Account\ForgotPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_user_reset_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'password_reset_expiration' => now()->addHour(),
        ]);

        Livewire::actingAs($user)
            ->test(ForgotPassword::class)
            ->set('password', 'password')
            ->set('password_confirm', 'password')
            ->call('resetPassword')
            ->assertRedirect(route('login'));

    }
}
