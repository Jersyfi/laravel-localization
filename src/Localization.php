<?php

namespace Jersyfi\Localization;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Route;
use Jersyfi\Localization\Exceptions\LocalesNotDefined;
use Jersyfi\Localization\Exceptions\UnsupportedLocale;
use Jersyfi\Localization\Exceptions\UsersDatabaseCorreupted;
use Illuminate\Support\Facades\Schema;

class Localization
{
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->configHasLocales();
        $this->localesHasDefaultLocale();
        $this->usersDatabaseHasDetails();
    }
    
    /**
     * Return the given locale or the app locale with replaced separator
     * 
     * @param string $locale
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
     * Return all available locales without the current locale.
     * 
     * @return array
     */
    public function getLocalesWithoutCurrent(): array
    {
        foreach ($array = $this->getLocales() as $key => $value) {
            if ($value == App::getLocale()) {
                unset($array[$key]);
            }
        }

        return $array;
    }
    
    /**
     * Return the current Route URL
     * 
     * @return string
     */
    public function currentRouteURL(): string
    {
        return $this->currentRouteLocaleURL(
            App::getLocale()
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
     * Return the current Route URL with different locale
     * 
     * @param string $locale
     * @return string
     */
    public function currentRouteLocaleURL(string $locale): string
    {
        $route = Route::current();
        $params = $route->parameters;
        $params['locale'] = $locale;
        $query = str_replace(
            ['%5B', '%5D', '%2C'], ['[', ']', ','],
            $this->request->getQueryString()
        );

        return route(
            $route->getName(),
            $params
        ) . ($query != '' ? '?' . $query : '');
    }

    /**
     * Check if the locales are valid
     *
     * @param array $locales
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
     * @throws LocalesNotDefined::class
     */
    protected function configHasLocales()
    {
        if (count($this->getLocales()) < 1) {
            throw LocalesNotDefined::make();
        }
    }

    /**
     * Check if the App locale is in Locales
     * 
     * @throws UnsupportedLocale::class
     */
    protected function localesHasDefaultLocale()
    {
        if (!$this->localeIsValid($this->getDefaultLocale(), config('app.locale'))) {
            throw UnsupportedLocale::make();
        }
    }
    
    /**
     * Check if the users database is currupted
     * 
     * @throws UsersDatabaseCorreupted::class
     */
    protected function usersDatabaseHasDetails()
    {
        if (
            !config('localization.store_users_database')
            &&
            !Schema::hasColumn(
                config('localization.database.users_table_name'),
                config('localization.database.prefered_locale_column_name')
            )
        ) {
            throw UsersDatabaseCorreupted::make();
        }
    }
}
