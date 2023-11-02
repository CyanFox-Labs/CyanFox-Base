<?php

namespace Tests\Feature\Views\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_login(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }
}
