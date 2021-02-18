<?php

namespace Jersyfi\Localization\Exceptions;

use Exception;

class UnsupportedLocale extends Exception
{
    public static function make()
    {
        $locale = config('app.locale');

        return new static("Locale `{$locale}` ist not defined in locales array of config localization");
    }
}
