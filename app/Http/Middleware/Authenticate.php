<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {

        if (!setting('auth_enable')) {
            return null;
        }
        if ($request->fullUrl() === route('home')) {
            return $request->expectsJson() ? null : route('auth.login');
        }
        return $request->expectsJson() ? null : route('auth.login', ['redirect' => $request->fullUrl()]);
    }
}
