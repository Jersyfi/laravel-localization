<?php

namespace Jersyfi\Localization;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
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
    public function boot(Kernel $kernel)
    {
        // Publish Configuration File
        $this->publishes([
            __DIR__.'/../config/localization.php' => config_path('localization.php'),
        ], 'config');

        // Boot Middleware
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('locale', Locale::class);
    }
}
