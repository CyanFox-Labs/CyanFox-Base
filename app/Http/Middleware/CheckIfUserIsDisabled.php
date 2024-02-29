<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::check() && Auth::user()->disabled === 1) {
            Auth::logout();

            session()->flash('error', __('auth.login.user_disabled'));

            if ($request->fullUrl() === route('home')) {
                return redirect()->route('auth.login');
            }

            return redirect()->route('auth.login', ['redirect' => $request->fullUrl()]);
        }

        return $next($request);
    }
}
