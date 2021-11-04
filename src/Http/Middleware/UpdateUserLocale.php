<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use App;

class UpdateUserLocale
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
        $response = $next($request);
        
        if (config('localization.store_users_database')) {
            if (Auth::check()) {
                $preferedLocale = config('localization.database.prefered_locale_column_name');
                
                Auth::user()->$preferedLocale = App::getLocale();
                Auth::user()->save();
            }
        }

        return $response;
    }
}
