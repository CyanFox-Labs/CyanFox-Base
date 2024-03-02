<?php

namespace Tests\Feature\Livewire\Components\Modals\Admin\Users;

use App\Livewire\Components\Modals\Admin\Users\DeleteUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);

        Livewire::actingAs($user)
            ->test(DeleteUser::class)
            ->assertStatus(200);
    }

    /** @test */
    public function can_user_delete_user(): void
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);

        $userToDelete = User::factory()->create();

        Livewire::actingAs($user)
            ->test(DeleteUser::class)
            ->set('userId', $userToDelete->id)
            ->call('deleteUser');

        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }
}
