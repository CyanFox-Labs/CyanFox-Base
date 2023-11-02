<?php

namespace Tests\Feature\Views\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_forgot_password(): void
    {
        $user = User::factory()->create(['password_reset_token' => 'test']);

        $response = $this->get(route('forgot-password', $user->password_reset_token));

        $response->assertStatus(200);
    }
}
