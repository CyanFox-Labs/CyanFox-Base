<?php

namespace Tests\Feature\Livewire\Admin\Groups;

use App\Livewire\Admin\Groups\UpdateGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateGroupTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(UpdateGroup::class)
            ->assertStatus(200);
    }
}
