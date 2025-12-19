<?php

namespace PhpJunior\PricingEngine\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use PhpJunior\PricingEngine\Providers\PricingEngineServiceProvider;
use Stevebauman\Location\LocationServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            PricingEngineServiceProvider::class,
            LocationServiceProvider::class
        ];
    }
}
