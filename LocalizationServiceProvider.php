<?php

namespace Jersyfi\Localization;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Jersyfi\Localization\Http\Middleware\Locale;
use Jersyfi\Localization\Exceptions\LocalesNotDefined;
use Jersyfi\Localization\Exceptions\UnsupportedLocale;

class LocalizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Merge Configuration Files
        $this->mergeConfigFrom(
            __DIR__.'/../config/localization.php', 'localization'
        );

        // Register Controller
        $this->app->make('Jersyfi\Localization\Http\Controllers\LocaleController');

        // Bind Facade
        $this->app->singleton('localization', function ($app) {
            return new Localization($app->make('request'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish Configuration File
        $this->publishes([
            __DIR__.'/../config/localization.php' => config_path('localization.php'),
        ]);

        // Boot Middleware
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('locale', Locale::class);

        //$this->configHasLocales();
        //$this->LocaleInLocales();
    }

    /**
     * Check if the Locales are defined
     * 
     * @throws LocalesNotDefined
     */
    public function configHasLocales()
    {
        if (count(config('localization.locales')) < 1) {
            throw LocalesNotDefined::make();
        }
    }

    /**
     * Check if the App locale is in Locales
     * 
     * @throws UnsupportedLocale
     */
    public function LocaleInLocales()
    {
        if (!in_array(config('app.locale'), config('localization.locales'))) {
            throw UnsupportedLocale::make();
        }
    }
}
