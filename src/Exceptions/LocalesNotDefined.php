<?php

namespace Jersyfi\Localization\Exceptions;

use Exception;

class LocalesNotDefined extends Exception
{
    public static function make()
    {
        $localizationConfigPath = config_path('localization');
        
        return new static("No locales found in config: `localitzation` at `{$localizationConfigPath}`");
    }
}
