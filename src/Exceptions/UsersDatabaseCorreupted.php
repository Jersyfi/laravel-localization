<?php

namespace Jersyfi\Localization\Exceptions;

use Exception;

class UsersDatabaseCorreupted extends Exception
{
    public static function make()
    {
        return new static("Users database table is corrupted or just the prefered_local column is missing");
    }
}
