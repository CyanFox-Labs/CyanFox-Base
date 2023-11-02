<?php

namespace Tests\Feature\Views\Account;

use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivateTwoFactorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_activate_two_factor(): void
    {
        $user = User::factory()->create();

        AuthController::generateTwoFactorSecret($user);
        $response = $this->actingAs($user)->get(route('account.activate-two-factor'));

        $response->assertStatus(200);
    }
}
