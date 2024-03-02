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

        $password = fake()->password(8);
        $username = fake()->userName;
        $email = fake()->email;

        Livewire::test(Register::class)
            ->set('firstName', fake()->firstName)
            ->set('lastName', fake()->lastName)
            ->set('username', $username)
            ->set('email', $email)
            ->set('password', $password)
            ->set('passwordConfirmation', $password)
            ->call('register');

        $this->assertDatabaseHas('users', [
            'username' => $username,
            'email' => $email,
        ]);
    }
}
