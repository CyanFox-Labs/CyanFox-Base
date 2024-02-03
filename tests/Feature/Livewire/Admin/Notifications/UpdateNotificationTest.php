<?php

namespace Tests\Feature\Livewire\Admin\Notifications;

use App\Livewire\Admin\Notifications\UpdateNotification;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateNotificationTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(UpdateNotification::class)
            ->assertStatus(200);
    }
}
