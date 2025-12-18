<?php

namespace PhpJunior\PricingEngine\Operators;

use Carbon\Carbon;

class DayOfWeekOperator implements OperatorInterface
{
    /**
     * Evaluate if the attribute date's day of the week matches the condition value.
     *
     * @param mixed $attributeValue The date value from the context.
     * @param mixed $conditionValue The day of the week (e.g., 'Monday', 1).
     * @return bool
     */
    public function evaluate(mixed $attributeValue, mixed $conditionValue): bool
    {
        $dayOfWeek = Carbon::parse($attributeValue)->dayOfWeek;

        if (is_numeric($conditionValue)) {
            return $dayOfWeek === (int) $conditionValue;
        }

        if (is_string($conditionValue)) {
            return strtolower(Carbon::parse($attributeValue)->format('l')) === strtolower($conditionValue);
        }

        return false;
    }
}

