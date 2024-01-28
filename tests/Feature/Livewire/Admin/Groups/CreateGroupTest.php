<?php

namespace Tests\Feature\Livewire\Admin\Groups;

use App\Livewire\Admin\Groups\CreateGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateGroupTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(CreateGroup::class)
            ->assertStatus(200);
    }
}
