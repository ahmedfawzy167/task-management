<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->header('lang'); // Accept 'lang' header

        if ($lang && in_array($lang, ['en', 'ar'])) {
            App::setLocale($lang);
        } else {
            App::setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
