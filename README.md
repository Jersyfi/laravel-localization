# laravel-localization

![Coveralls github](https://img.shields.io/coveralls/github/jersyfi/laravel-localization)
![Packagist Downloads](https://img.shields.io/packagist/dm/jersyfi/laravel-localization)

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

Check if the locale is valid
`Localization::localeIsValid()`
