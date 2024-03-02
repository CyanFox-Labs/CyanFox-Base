<?php

namespace Tests\Feature\Livewire\Components\Modals\Account;

use App\Livewire\Components\Modals\Account\ChangeAvatar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ChangeAvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        Livewire::actingAs($user)
            ->test(ChangeAvatar::class)
            ->assertStatus(200);
    }

    /** @test */
    public function can_user_change_avatar()
    {
        $user = User::factory()->create();
        Livewire::actingAs($user)
            ->test(ChangeAvatar::class)
            ->set('customAvatarUrl', 'https://source.boringavatars.com/beam/120/avatar')
            ->call('updateAvatar');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'custom_avatar_url' => 'https://source.boringavatars.com/beam/120/avatar',
        ]);
    }
}
