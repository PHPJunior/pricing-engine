<?php

namespace PhpJunior\PricingEngine\Operators;

class LessThanOrEqualOperator implements OperatorInterface
{
    /**
     * Evaluate if the attribute value is less than or equal to the condition value.
     *
     * @param mixed $attributeValue The value from the context.
     * @param mixed $conditionValue The value from the condition.
     * @return bool
     */
    public function evaluate(mixed $attributeValue, mixed $conditionValue): bool
    {
        return $attributeValue <= $conditionValue;
    }
}
