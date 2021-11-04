<?php

return [

    /**
     * Applications default locale need to be set because the config('app.locale')
     * gives back the current locale and not the value from config
     */
    'default_locale' => 'de',

    /**
     * Application locales determines all locals that exists in the application
     * You can ignore or delete the locales from app.locales if you set some
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
     * When no locale is stored in session or in auth users database table user gets redirected
     */
    'detect_locale' => false,
    
    /**
     * Application can store the prefered_locale in the users database table
     */
    'store_users_database' => true,
    
    /**
     * Setup for the users database table
     * Only if 'store_users_database' is set to true
     */
    'database' => [
        'users_table_name' => 'users',
        'prefered_locale_column_name' => 'prefered_locale',
    ],

];
