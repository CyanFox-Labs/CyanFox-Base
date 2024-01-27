<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfUserIsDisabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->disabled === 1) {
            auth()->logout();

            session()->flash('error', __('pages/auth/login.user_disabled'));

            if ($request->fullUrl() === route('home')) {
                return redirect()->route('auth.login');
            }
            return redirect()->route('auth.login', ['redirect' => $request->fullUrl()]);
        }

        return $next($request);
    }
}
