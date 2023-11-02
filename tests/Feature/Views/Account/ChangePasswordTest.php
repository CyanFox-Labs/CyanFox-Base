<?php

namespace Tests\Feature\Views\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_change_password(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('account.change-password'));

        $response->assertStatus(200);
    }
}
