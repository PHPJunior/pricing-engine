<?php

namespace PhpJunior\PricingEngine\Operators;

use Carbon\Carbon;
use PhpJunior\PricingEngine\Operators\OperatorInterface;

class DateEqualsOperator implements OperatorInterface
{
    /**
     * Evaluate if the attribute date is the same day as the condition date.
     *
     * @param mixed $attributeValue The date value from the context.
     * @param mixed $conditionValue The date value from the condition.
     * @return bool
     */
    public function evaluate(mixed $attributeValue, mixed $conditionValue): bool
    {
        if (empty($attributeValue) || empty($conditionValue)) {
            return false;
        }

        return Carbon::parse($attributeValue)->isSameDay(Carbon::parse($conditionValue));
    }
}

