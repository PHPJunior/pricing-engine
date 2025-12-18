<?php

namespace PhpJunior\PricingEngine\Facades;

use Illuminate\Support\Facades\Facade;

class PricingEngine extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'pricing-engine';
    }
}
