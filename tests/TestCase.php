<?php

namespace PhpJunior\PricingEngine\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use PhpJunior\PricingEngine\Providers\PricingEngineServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            PricingEngineServiceProvider::class,
        ];
    }
}
