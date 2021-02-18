<?php

namespace Jersyfi\Localization;

use Illuminate\Http\Request;
use Jersyfi\Localization\Exceptions\LocalesNotDefined;
use Jersyfi\Localization\Exceptions\UnsupportedLocale;
use Illuminate\Support\Facades\Route;
use Arr;
use App;

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
     * Return the given locale or the app locale with replaced separator
     * 
     * @param string locale
     *
     * @return string
     */
    public function getLocaleSlug(string $locale = null): string
    {
        if ($locale == null) {
            $locale = App::getLocale();
        }
        
        return str_replace('_', '-', $locale);
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
        return config('localization.default_locale');
    }

    /**
     * Return all available locales without the default locale.
     * 
     * @return array
     */
    public function getLocalesWithoutDefault(): array
    {
        foreach ($array = $this->getLocales() as $key => $value) {
            if ($value == $this->getDefaultLocale()) {
                unset($array[$key]);
            }
        }

        return $array;
    }

    /**
     * Return the current Route URL with different locale
     * 
     * @param string locale
     * 
     * @return string url
     */
    public function currentRouteLocaleURL(string $locale): string
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
     * Return the current Route URL with default locale
     * 
     * @return string url
     */
    public function currentRouteDefaultLocaleURL(): string
    {
        return $this->currentRouteLocaleURL($this->getDefaultLocale());
    }

    /**
     * Check if the locales are valid
     *
     * @param array locales
     *
     * @return bool
     */
    public function localeIsValid(...$locales): bool
    {
        foreach ($locales as $key) {
            if (!in_array(
                $key,
                $this->getLocales()
            )) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if the Locales are defined
     * 
     * @throws LocalesNotDefined
     */
    private function configHasLocales()
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
    private function localesHasDefaultLocale()
    {
        if (!$this->localeIsValid($this->getDefaultLocale(), config('app.locale'))) {
            throw UnsupportedLocale::make();
        }
    }
}
