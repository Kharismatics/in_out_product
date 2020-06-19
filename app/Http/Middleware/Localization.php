<?php

namespace App\Http\Middleware;

use Closure;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if (auth()->check()) {
        //     $language = auth()->user()->language;
        //     if (empty($language)) {
        //         $language = config('app.fallback_locale');
        //     }
        //     app()->setLocale($language);
        //     session()->put('applocale', $language);
        //     auth()->user()->language = $language;
        //     auth()->user()->save();
        //     return $next($request);
        // }
        // if (session()->has('applocale')) {
        //     app()->setLocale(session()->get('applocale'));
        // } else {
        //     app()->setLocale(config('app.fallback_locale'));
        //     session()->put('applocale', config('app.fallback_locale'));
        // }
        if (auth()->check()) {
            $language = auth()->user()->language;
            app()->setLocale($language);
            auth()->user()->language = $language;
            auth()->user()->save();
            return $next($request);
        }
        return $next($request);
    }
}
