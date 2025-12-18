<?php

namespace PhpJunior\PricingEngine\Handlers;

class CalculatePriceQuery
{
    public function __construct(
        public readonly float $basePrice,
        public readonly array $context
    ) {
    }
}
