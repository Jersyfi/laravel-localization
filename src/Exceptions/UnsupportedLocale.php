<?php

namespace Jersyfi\Localization\Exceptions;

use Exception;

class UnsupportedLocale extends Exception
{
    public static function make()
    {
        $locale = config('app.locale');

        return new static("Laravel default locale `{$locale}` ist not in the config localization locales array");
    }
}
