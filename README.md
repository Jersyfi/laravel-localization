# A package to make your application localized

![Packagist Downloads](https://img.shields.io/packagist/dt/jersyfi/laravel-localization)
![Packagist Version](https://img.shields.io/packagist/v/jersyfi/laravel-localization)
![GitHub License](https://img.shields.io/github/license/jersyfi/laravel-localization)

## Installation

You can install the package via composer
```bash
composer require jersyfi/laravel-localization
```
You need to publish the config file to customize the package
```bash
php artisan vendor:publish --provider="Jersyfi\Localization\LocalizationServiceProvider" --tag="config"
```
The published config `localization`looks like so
```php
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

## How to use

### Routing

You can redirect to the `default_locale` by accessing the `LocaleController` function called `localize` with the example:
```php
Route::get('/', [LocaleController::class, 'localize'])
    ->name('locale');
```

To group a route it is the easiest way to set a prefix named `{locale}` together with the middleware `locale`.
Inside this group you can set your own localized routes.
An example to get this localized route group:
```php
Route::prefix('{locale}')
    ->middleware('locale')
    ->group(function () {

        // your localized routes here
    });
```




## How to use

```html
<link rel="canonical" href="{{ Localization::currentRouteDefaultLocaleURL() }}">
```

```html
@foreach(Localization::getLocalesWithoutDefault() as $locale)
    <link rel="alternate" hreflang="{{ $locale }}" href="{{ Localization::currentRouteLocaleURL($locale) }}">
@endforeach
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




## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Credits

- [Jérôme Bastian Winkel](https://github.com/jersyfi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
