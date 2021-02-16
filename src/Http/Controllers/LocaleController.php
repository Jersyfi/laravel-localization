<?php

namespace Jersyfi\Localization\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App;

class LocaleController extends Controller
{
    /**
     * Localize the correct Language
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function localize(Request $request)
    {
        if ($request->session()->has('locale')) {
            if (in_array(
                $locale = $request->session()->get('locale'),
                config('localization.locales')
            )) {
                App::setLocale($locale);
            } else {
                $request->session()->put('locale', App::getLocale());
            }
        }

        return redirect('/' . App::getLocale());
    }

    /**
     * Change the current Locale.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return route
     */
    public function change(Request $request)
    {
        $locale = $request->localeChange;
        $url = URL::previous();
        $url = str_replace('/'. App::getLocale(), '/' . $locale, $url);

        //Route Name mitgeben und Default Locale umändern
        //danach die Route neu laden

        session()->put('locale', $locale);
        App::setLocale($locale);

        return redirect($url);
    }
}
