<?php

namespace Tests\Feature\Livewire\Admin\Groups;

use App\Livewire\Admin\Groups\Groups;
use Livewire\Livewire;
use Tests\TestCase;

class GroupsTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Groups::class)
            ->assertStatus(200);
    }
}
