<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Home;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Home::class)
            ->assertStatus(200);
    }
}
