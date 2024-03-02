<?php

namespace Tests\Feature\Livewire\Admin\Groups;

use App\Livewire\Admin\Groups\UpdateGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UpdateGroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);

        $this->actingAs($user)->get(route('admin.groups.update', ['groupId' => $group->id]))
            ->assertStatus(200);
    }

    /** @test */
    public function can_update_group()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);

        Livewire::actingAs($user)
            ->test(UpdateGroup::class, ['groupId' => $group->id])
            ->set('name', 'test')
            ->set('guardName', 'web')
            ->call('updateGroup');

        $this->assertDatabaseHas('roles', [
            'name' => 'test',
            'guard_name' => 'web',
        ]);
    }
}
