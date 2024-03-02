<?php

namespace Tests\Feature\Livewire\Components\Modals\Account\APIKeys;

use App\Facades\UserManager;
use App\Livewire\Components\Modals\Account\APIKeys\DeleteAPIKey;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteAPIKeyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        Livewire::actingAs($user)
            ->test(DeleteAPIKey::class)
            ->assertStatus(200);
    }

    /** @test */
    public function can_user_create_api_key()
    {
        $user = User::factory()->create();
        UserManager::getUser($user)->getAPIKeyManager()->createAPIKey('Test API Key');
        $apiKey = $user->tokens()->where('name', 'Test API Key')->first();

        Livewire::actingAs($user)
            ->test(DeleteAPIKey::class)
            ->set('apiKeyId', $apiKey->id)
            ->call('deleteAPIKey');

        $this->assertDatabaseMissing('personal_access_tokens', [
            'name' => 'Test API Key',
        ]);
    }
}
