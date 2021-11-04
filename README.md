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
The published config `localization` looks like so
```php
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
     * When no locale is stored in session user gets redirected
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
```


## How to use

More information can be found in the original Laravel documentation with version 8.x.
There you need to know everything about [Routing](https://laravel.com/docs/8.x/routing) and [Localization](https://laravel.com/docs/8.x/localization). When you also want to have translatable models i prefere to use [laravel-translatable](https://github.com/spatie/laravel-translatable) from Spatie.

### Routing

The middleware is using `redirect_default` to redirect any request when the requested locale was not in `locales`. To detect the browser language when entering the page for the first time the `LocaleController` is using `detect_locale`.

You can redirect to the `default_locale` by accessing the `LocaleController` function called `localize` with the example:
```php
use Jersyfi\Localization\Http\Controllers\LocaleController;

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

### Helpers

The helpers can be accesed directly by aliases or by facades. When using aliases in your controller you need to include `use Localization`. The facade can be accessed by calling simply `app('localization')`.

Return the given locale or the app locale with replaced separator
```php
Localization::getLocaleSlug();
app('localization')->getLocaleSlug();

$slug = Localization::getLocaleSlug('en_GB'); // en-gb

// When you leave it empty it returns the current locale slug
// In this example output current locale is 'de'
$slug = Localization::getLocaleSlug(); // de
```

Return all available locales
```php
Localization::getLocales();
app('localization')->getLocales();

$locales = Localization::getLocales(); // ['en', 'de']
```

Return application default locale
```php
Localization::getDefaultLocale();
app('localization')->getDefaultLocale();

$locale = Localization::getDefaultLocale(); // de
```

Return all available locales without the default locale.
```php
Localization::getLocalesWithoutDefault();
app('localization')->getLocalesWithoutDefault();

$locales = Localization::getLocalesWithoutDefault(); // ['en']
```

Return all available locales without the current locale.
```php
Localization::getLocalesWithoutCurrent();
app('localization')->getLocalesWithoutCurrent();

// In this example output current locale is 'en'
$locales = Localization::getLocalesWithoutCurrent(); // ['de']
```

Return the current Route URL
```php
Localization::currentRouteURL();
app('localization')->currentRouteURL();

// Current route url 'https://test.de/de/home'
$url = Localization::currentRouteLocaleURL(); // https://test.de/de/home
```

Return the current Route URL with different locale
```php
Localization::currentRouteLocaleURL();
app('localization')->currentRouteLocaleURL();

// It is replacing the routes parameter {locale} with locale you want
// Current route url 'https://test.de/de/home'
$url = Localization::currentRouteLocaleURL('en'); // https://test.de/en/home
```

Return the current Route URL with default locale
```php
Localization::currentRouteDefaultLocaleURL();
app('localization')->currentRouteDefaultLocaleURL();

// Every route get returned with the default locale set in the config
// Current route url 'https://test.de/en/home'
// Or current route url 'https://test.de/de/home'
// Returns both with the same
$url = Localization::currentRouteDefaultLocaleURL(); // https://test.de/de/home
```

Check if the locales are valid
```php
Localization::localeIsValid();
app('localization')->localeIsValid();

$valid = Localization::localeIsValid('de'); // true

$valid = Localization::localeIsValid('de', 'en'); // true

$valid = Localization::localeIsValid('de', 'sp'); // false
```


## Examples

### Route to named routes

We create a simple index Route named `home` calling whatever you want. In this example we call a Controller. Then you can call your route from whereever you want with `route('home')`.
```php
Route::get('/', [LocaleController::class, 'localize'])
    ->name('locale');

Route::prefix('{locale}')
    ->middleware('locale')
    ->group(function () {

        // your localized routes here
        Route::get('/', [HomeController::class, 'index'])
            ->name('home');
    });
```
```html
<a href="{{ route('home') }}">Home</a>
```

### Create a canonical link

You need to call the helper function `Localization::currentRouteDefaultLocaleURL()`
```html
<link rel="canonical" href="{{ Localization::currentRouteDefaultLocaleURL() }}">
```

### Create alternate links

To get all alternate links without the default locale you can call the helper function `Localization::getLocalesWithoutDefault()` inside a foreach loop. Inside the href of the html you can call the helper function `Localization::currentRouteLocaleURL()` and pass the `$locale` to it.
```html
@foreach(Localization::getLocalesWithoutDefault() as $locale)
    <link rel="alternate" hreflang="{{ Localization::getLocaleSlug($locale) }}" href="{{ Localization::currentRouteLocaleURL($locale) }}">
@endforeach
```

### Create a language selector

When you want to create a language selector first you need the current locale slug. For this you can call the helper function `Localization::getLocaleSlug()`. To loop the other locales you can decide if you want to display all available locales with `Localization::getLocales()` or if you want to display the available locales without the current locale with `Localization::getLocalesWithoutCurrent()`. Inside the foreach loop you can call the helper function `Localization::currentRouteLocaleURL($locale)` to get the link and `Localization::getLocalSlug($locale)` for the locale slug.
```html
<div>{{ Localization::getLocaleSlug() }}</div>
<ul>
    @foreach(Localization::getLocalesWithoutCurrent() as $locale)
        <li>
            <a href="{{ Localization::currentRouteLocaleURL($locale) }}">{{ Localization::getLocalSlug($locale) }}</a>
        </li>
    @endforeach
</ul>
```


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Credits

- [Jérôme Bastian Winkel](https://github.com/jersyfi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
