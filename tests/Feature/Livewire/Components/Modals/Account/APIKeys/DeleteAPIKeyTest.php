<?php

namespace Tests\Feature\Livewire\Components\Modals\Account\APIKeys;

use App\Livewire\Components\Modals\Account\APIKeys\DeleteAPIKey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteAPIKeyTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(DeleteAPIKey::class)
            ->assertStatus(200);
    }
}
