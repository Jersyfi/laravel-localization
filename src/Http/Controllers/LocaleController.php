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
}
