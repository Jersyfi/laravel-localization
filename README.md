# laravel-localization

## Initialise

`php artisan vendor:publish --provider="Jersyfi\Localization\LocalizationServiceProvider" --tag="config"`

## How to use

```html
<link rel="canonical" href="{{ Localization::currentRouteDefaultLocaleURL() }}">
```

```html
@foreach(Localization::getLocalesWithoutDefault() as $locale)
    <link rel="alternate" hreflang="{{ $locale }}" href="{{ Localization::currentRouteLocaleURL($locale) }}">
@endforeach
```

```html
Route::get('/', [LocaleController::class, 'localize'])
    ->name('locale');
```

```html
Route::prefix('{locale}')
    ->middleware('locale')
    ->group(function () {

        // your localized routes

    }
```

## Config
```php
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
     * When no locale is stored in session user gets redirected
     */
    'detect_locale' => false,

];
```


## All functions

`Localization::`
or
`app('localization')->`

Return all available locales
`Localization::getLocales()`

Return application locale
`Localization::getDefaultLocale()`

Return all available locales without the default locale.
`Localization::getLocalesWithoutDefault()`

Return the current Route URL with different locale
`Localization::currentRouteLocaleURL()`

Return the current Route URL with default locale
`Localization::currentRouteDefaultLocaleURL()`

Check if the locales are valid
`Localization::localeIsValid()`