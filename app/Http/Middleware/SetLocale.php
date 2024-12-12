<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from URL, fallback to default or session if needed
        $locale = $request->segment(1); // First segment as locale
        
        // Check if the locale is supported
        if (in_array($locale, config('app.supported_locales'))) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            // Use session or default locale
            $locale = Session::get('locale', config('app.locale'));

            if ($locale === config('app.locale') && $request->path() === '/') {
                return $next($request);    
            }

            if (!$request->segment(1)) {
                return redirect($locale . '/' . ltrim($request->path(), '/'));
            }

            App::setLocale($locale);
        }

        return $next($request);
    }
}
