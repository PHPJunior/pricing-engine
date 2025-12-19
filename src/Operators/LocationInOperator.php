<?php

namespace PhpJunior\PricingEngine\Operators;

use Stevebauman\Location\Facades\Location;

class LocationInOperator implements OperatorInterface
{
    /**
     * Evaluate if the attribute value matches the condition location.
     *
     * @param mixed $attributeValue The value from the context.
     * @param mixed $conditionValue The value from the condition.
     * @return bool
     */
    public function evaluate(mixed $attributeValue, mixed $conditionValue): bool
    {
        $location = Location::get($attributeValue);
        return in_array($location->countryCode, $conditionValue);
    }
}
