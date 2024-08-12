<?php

namespace Italofantone\Slugable;

use Illuminate\Support\ServiceProvider;

class SlugableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/slugable.php', 'slugable'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/slugable.php' => config_path('slugable.php'),
        ], 'slugable-config');
    }
}
