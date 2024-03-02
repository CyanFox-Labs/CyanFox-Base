<?php

namespace Tests\Feature\Livewire\Components\Modals\Admin\Groups;

use App\Livewire\Components\Modals\Admin\Groups\DeleteGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DeleteGroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);
        Livewire::actingAs($user)
            ->test(DeleteGroup::class)
            ->assertStatus(200);
    }

    /** @test */
    public function can_user_delete_group()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);

        Livewire::actingAs($user)
            ->test(DeleteGroup::class)
            ->set('groupId', $group->id)
            ->call('deleteGroup');

        $this->assertDatabaseMissing('roles', ['name' => 'Super Admin']);
    }
}
