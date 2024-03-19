<?php

namespace Tests\Feature\Livewire\Auth;

use App\Livewire\Auth\Register;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $this->get(route('auth.register'))
            ->assertStatus(200);
    }

    /** @test */
    public function can_register(): void
    {
        Livewire::test(Register::class)
            ->set('firstName', 'TestUser')
            ->set('lastName', 'TestUser')
            ->set('username', 'testuser')
            ->set('email', 'test@local.host')
            ->set('password', 'kXqz=k^zwu7d^;UrMPNF')
            ->set('passwordConfirmation', 'kXqz=k^zwu7d^;UrMPNF')
            ->call('register');

        $this->assertDatabaseHas('users', [
            'username' => 'testuser',
            'email' => 'test@local.host',
        ]);
    }
}
