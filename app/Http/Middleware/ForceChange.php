<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceChange
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && (auth()->user()->force_change_password === 1 || auth()->user()->force_activate_two_factor === 1)) {
            if (auth()->user()->force_change_password == 1) {
                if ($request->fullUrl() === route('home')) {
                    return redirect()->route('account.force-change.password');
                }
                return redirect()->route('account.force-change.password', ['redirect' => $request->fullUrl()]);
            }

            if (auth()->user()->force_activate_two_factor == 1) {
                if ($request->fullUrl() === route('home')) {
                    return redirect()->route('account.force-activate.two-factor');
                }
                return redirect()->route('account.force-activate.two-factor', ['redirect' => $request->fullUrl()]);
            }

            return $next($request);
        }

        return $next($request);
    }
}
