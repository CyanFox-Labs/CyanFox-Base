<?php

namespace Tests\Feature\Livewire\Components\Modals\Account\APIKeys;

use App\Livewire\Components\Modals\Account\APIKeys\CreateAPIKey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateAPIKeyTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(CreateAPIKey::class)
            ->assertStatus(200);
    }
}
