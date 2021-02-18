<?php

namespace Jersyfi\Localization\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App;
use Localization;

class LocaleController extends Controller
{
    /**
     * Localize the correct Language
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function localize(Request $request)
    {
        $locales = Localization::getLocales();

        if ($request->session()->has('locale')) {
            $locale = $locale = $request->session()->get('locale');
        } elseif (config('localization.detect_locale', false) && $request->header('Accept-Language')) {
            $locale = $request->getPreferredLanguage($locales);
        } else {
            $locale = config('localization.default_locale', App::getLocale());
        }

        $request->session()->put('locale', $locale);

        return redirect('/'.$locale);
    }
}
