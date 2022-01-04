<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        return self::initialize();
    }

    public static function initialize()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->loadEnvironmentFrom('.env.testing');

        $app->make(Kernel::class)->bootstrap();

        Artisan::call('migrate --database=testing --seed');

        return $app;
    }
}
