<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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

        if (Auth::check() && Auth::user()->language) {
            App::setLocale(Auth::user()->language);

            return $next($request);
        }

        $language = $request->cookie('language');

        if ($language) {
            App::setLocale($language);

            return $next($request);
        } else {
            App::setLocale(setting('app_lang'));
            $response = $next($request);

            if ($response instanceof \Illuminate\Http\Response) {
                $response->withCookie(cookie()->forever('language', setting('app_lang')));
            }

            return $response;
        }
    }
}
