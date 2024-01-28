<?php

namespace Tests\Feature\Livewire\Components\Modals\Admin\Groups;

use App\Livewire\Components\Modals\Admin\Groups\DeleteGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteGroupTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(DeleteGroup::class)
            ->assertStatus(200);
    }
}
