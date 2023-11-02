<?php

namespace Tests\Feature\Livewire\Account;

use App\Livewire\Account\ChangePassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_user_change_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        Livewire::actingAs($user)
            ->test(ChangePassword::class)
            ->set('current_password', 'password')
            ->set('new_password', 'new_password')
            ->set('new_password_confirm', 'new_password')
            ->call('changePassword')
            ->assertRedirect(route('home'));

    }
}
