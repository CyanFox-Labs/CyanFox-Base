<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->user()) {
            if (auth()->user()->language) {
                app()->setLocale(auth()->user()->language);
                return $next($request);
            }
        }

        $language = $request->cookie('language');

        if ($language) {
            app()->setLocale($language);
            return $next($request);
        }else{
            app()->setLocale(env('APP_LANG', 'en'));
            return $next($request)
                ->withCookie(cookie()->forever('language', env('APP_LANG', 'en')));
        }
    }
}
