<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{
   /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle(Request $request, \Closure $next)
    {
        $locale = $request->header('x-locale');
        if ($locale && in_array($locale, config('app.supported_locales'))) {
            App::setLocale($locale);
        }
        return $next($request);
    }
}
