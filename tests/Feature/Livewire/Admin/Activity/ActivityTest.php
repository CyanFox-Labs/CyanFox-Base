<?php

namespace Tests\Feature\Livewire\Admin\Activity;

use App\Livewire\Admin\Activity\Activity;
use Livewire\Livewire;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Activity::class)
            ->assertStatus(200);
    }
}
