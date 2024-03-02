<?php

namespace Tests\Feature\Livewire\Components\Modals\Account\APIKeys;

use App\Livewire\Components\Modals\Account\APIKeys\CreateAPIKey;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateAPIKeyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        Livewire::actingAs($user)
            ->test(CreateAPIKey::class)
            ->assertStatus(200);
    }

    /** @test */
    public function can_user_create_api_key()
    {
        $user = User::factory()->create();
        Livewire::actingAs($user)
            ->test(CreateAPIKey::class)
            ->set('name', 'Test API Key')
            ->call('createAPIKey');

        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'Test API Key',
        ]);
    }
}
