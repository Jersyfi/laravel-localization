<?php

namespace Jersyfi\Localization;

use Illuminate\Http\Request;
use Jersyfi\Localization\Exceptions\LocalesNotDefined;
use Jersyfi\Localization\Exceptions\UnsupportedLocale;
use Illuminate\Support\Facades\Route;

class Localization
{
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->configHasLocales();
        $this->localesHasDefaultLocale();
    }

    /**
     * Return all available locales.
     *
     * @return array
     */
    public function getLocales(): array
    {
        return config('localization.locales', []);
    }

    /**
     * Return application locale.
     *
     * @return array
     */
    public function getDefaultLocale(): string
    {
        return config('app.locale', 'en');
    }

    /**
     * Return the current Route URL with a different locale
     * 
     * @param string locale
     * 
     * @return string url
     */
    public function currentLocaleRoute(string $locale): string
    {
        $route = Route::current();
        $params = $route->parameters;
        $params['locale'] = $locale;

        return route(
            $route->getName(),
            $params
        );
    }

    /**
     * Check if the locale is valid
     *
     * @param string locale
     *
     * @return bool
     */
    public function localeIsValid(string $locale): bool
    {        
        return in_array(
            $locale,
            $this->getLocales()
        );
    }

    /**
     * Check if the Locales are defined
     * 
     * @throws LocalesNotDefined
     */
    public function configHasLocales()
    {
        if (count($this->getLocales()) < 1) {
            throw LocalesNotDefined::make();
        }
    }

    /**
     * Check if the App locale is in Locales
     * 
     * @throws UnsupportedLocale
     */
    public function localesHasDefaultLocale()
    {
        if (!$this->localeIsValid($this->getDefaultLocale())) {
            throw UnsupportedLocale::make();
        }
    }
}