<?php

namespace Tests\Feature\Livewire\Components\Modals;

use App\Livewire\Components\Modals\ShowActivityLogDetails;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ShowActivityLogDetailsTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ShowActivityLogDetails::class)
            ->assertStatus(200);
    }
}
