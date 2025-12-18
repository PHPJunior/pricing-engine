<?php

namespace PhpJunior\PricingEngine\Actions;

interface ActionInterface
{
    public function execute(...$parameters): mixed;
}
