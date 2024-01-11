<?php

namespace Tests\Feature\Livewire\Auth;

use App\Livewire\Auth\Register;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Register::class)
            ->assertStatus(200);
    }
}
