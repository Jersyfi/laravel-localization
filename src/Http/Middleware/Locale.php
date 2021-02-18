<?php

namespace Jersyfi\Localization\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Localization;
use Illuminate\Support\Facades\URL;
use App;

class Locale
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
        if (!Localization::localeIsValid($locale = $request->locale)) {
            abort(404);
        }

        $request->session()->put('locale', $locale);
        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
