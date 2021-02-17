<?php

namespace Jersyfi\Localization;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Jersyfi\Localization\Http\Middleware\Locale;
use Jersyfi\Localization\Console\InstallLocalization;

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

        // Register the command if we are using the application via the CLI
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallLocalization::class,
            ]);
        }
    }
}
