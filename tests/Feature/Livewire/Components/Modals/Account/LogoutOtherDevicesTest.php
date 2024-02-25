<?php

namespace Tests\Feature\Livewire\Components\Modals\Account;

use App\Livewire\Components\Modals\Account\LogoutOtherDevices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class LogoutOtherDevicesTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(LogoutOtherDevices::class)
            ->assertStatus(200);
    }
}