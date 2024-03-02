<?php

namespace Tests\Feature\Livewire\Components\Modals\Account;

use App\Livewire\Components\Modals\Account\LogoutOtherDevices;
use App\Models\Session;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LogoutOtherDevicesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        Livewire::actingAs($user)
            ->test(LogoutOtherDevices::class)
            ->assertStatus(200);
    }

    /** @test */
    public function can_user_logout_other_devices(): void
    {
        $user = User::factory()->create();
        $uuid = fake()->uuid;
        Session::factory()->create([
            'user_id' => $user->id,
            'id' => $uuid,
        ]);
        Livewire::actingAs($user)
            ->test(LogoutOtherDevices::class)
            ->call('logoutOtherDevices');

        $this->assertDatabaseMissing('sessions', [
            'user_id' => $user->id,
            'id' => $uuid,
        ]);
    }
}
