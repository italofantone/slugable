<?php

namespace Italofantone\Slugable\Tests;

use Italofantone\Slugable\SlugableServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->app->register(SlugableServiceProvider::class);        
    }

    // ...
}