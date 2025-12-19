<?php

namespace PhpJunior\PricingEngine\Operators;

use Illuminate\Support\Str;

class NotContainsOperator implements OperatorInterface
{

    /**
     * Evaluate if the attribute value does not contain the condition value.
     *
     * @param mixed $attributeValue the value from the context
     * @param mixed $conditionValue the value from the condition
     * @return bool
     */
    public function evaluate(mixed $attributeValue, mixed $conditionValue): bool
    {
        if (! is_string($attributeValue) && ! is_array($attributeValue)) {
            return false;
        }

        $attributeValues = (array) $attributeValue;
        $conditionValues = (array) $conditionValue;

        foreach ($attributeValues as $attributeVal) {
            foreach ($conditionValues as $conditionVal) {
                if (Str::contains($attributeVal, $conditionVal) || Str::contains($conditionVal, $attributeVal)) {
                    return false;
                }
            }
        }

        return true;
    }
}
