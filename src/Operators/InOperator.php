<?php

namespace PhpJunior\PricingEngine\Operators;

class InOperator implements OperatorInterface
{
    /**
     * Evaluate if the attribute value is in the array of condition values.
     *
     * @param mixed $attributeValue The value from the context.
     * @param mixed $conditionValue The array of values from the condition.
     * @return bool
     */
    public function evaluate(mixed $attributeValue, mixed $conditionValue): bool
    {
        return in_array($attributeValue, $conditionValue);
    }
}
