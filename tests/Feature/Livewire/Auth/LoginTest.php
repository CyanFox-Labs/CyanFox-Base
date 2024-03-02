<?php

namespace Tests\Feature\Livewire\Auth;

use App\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $this->get(route('auth.login'))
            ->assertStatus(200);
    }

    /** @test */
    public function can_login(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        Livewire::test(Login::class)
            ->set('username', $user->username)
            ->set('password', 'password')
            ->call('attemptLogin')
            ->assertRedirect(route('home'));
    }
}
