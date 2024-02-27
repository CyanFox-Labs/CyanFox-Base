<?php

namespace Tests\Feature\Livewire\Auth;

use App\Livewire\Auth\ForgotPassword;
use Livewire\Livewire;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ForgotPassword::class)
            ->assertStatus(200);
    }
}
