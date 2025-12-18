<?php

namespace PhpJunior\PricingEngine\Operators;

interface OperatorInterface
{
    public function evaluate(mixed $attributeValue, mixed $conditionValue): bool;
}
