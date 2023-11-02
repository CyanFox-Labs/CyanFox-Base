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
    public function can_user_register(): void
    {
        Livewire::test(Register::class)
            ->set('first_name', 'test')
            ->set('last_name', 'test')
            ->set('username', 'test')
            ->set('email', 'test@local.host')
            ->set('password', 'password')
            ->set('password_confirm', 'password')
            ->call('register')
            ->assertRedirect(route('login'));
    }
}
