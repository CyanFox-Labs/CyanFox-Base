<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLanguage
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
            app()->setLocale(config('app.locale'));
            $response = $next($request);

            if ($response instanceof \Illuminate\Http\Response) {
                $response->withCookie(cookie()->forever('language', config('app.locale')));
            }

            return $response;
        }
    }
}
