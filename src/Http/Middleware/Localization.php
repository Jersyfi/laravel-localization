<?php

namespace Jersyfi\Localization\Http\Middleware;

use Closure;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

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
        if (!in_array(
            $locale = $request->locale,
            config('localization.locales')
        )) {
            if (!($locale = config('app.fallback_locale'))) {
                abort(404);
            }
        }

        $request->session()->put('locale', $locale);
        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
