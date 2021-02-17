<?php

namespace Jersyfi\Locaization;

use Jersyfi\Localization\Exceptions\LocalesNotDefined;
use Jersyfi\Localization\Exceptions\UnsupportedLocale;

trait HasExceptions {
    /**
     * Check if the Locales are defined
     * 
     * @throws LocalesNotDefined
     */
    public function configHasLocales()
    {
        if (count(config('localization.locales')) < 1) {
            throw LocalesNotDefined::make();
        }
    }

    /**
     * Check if the App locale is in Locales
     * 
     * @throws UnsupportedLocale
     */
    public function LocaleInLocales()
    {
        if (!in_array(config('app.locale'), config('localization.locales'))) {
            throw UnsupportedLocale::make();
        }
    }
}