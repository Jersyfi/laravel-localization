<?php

return [

    /**
     * Applications default locale need to be set because the config('app.locale')
     * gives back the current locale and not the value from config
     */
    'default_locale' => 'de',

    /**
     * Application locales determines all locals that exists in the application
     */
    'locales' => [
        'en',
        'de'
    ],
    
    /**
     * Redirect to default locale when not found
     */
    'redirect_default' => false,

    /**
     * Detect user locale via http header
     * When no locale is stored in session or in auth users database user gets redirected
     */
    'detect_locale' => false,
    
    /**
     * 
     */
    'database' => [
        'users_table_name' => 'users',
        'prefered_locale_columne_name' => 'prefered_locale',
    ],

];
