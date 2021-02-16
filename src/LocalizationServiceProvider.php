<?php

namespace Jersyfi\Localization;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Jersyfi\Localization\Http\Middleware\Localization;

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
        $router->aliasMiddleware('locale', Localization::class);
    }
}
