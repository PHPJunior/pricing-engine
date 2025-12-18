<?php

namespace PhpJunior\PricingEngine\Operators;

use Carbon\Carbon;

class DateBetweenOperator implements OperatorInterface
{
    /**
     * Evaluate if the attribute date is between two condition dates.
     *
     * @param mixed $attributeValue The date value from the context.
     * @param mixed $conditionValue An array containing the start and end dates.
     * @return bool
     */
    public function evaluate(mixed $attributeValue, mixed $conditionValue): bool
    {
        if (!is_array($conditionValue) || count($conditionValue) !== 2) {
            return false;
        }

        $date = Carbon::parse($attributeValue);
        $startDate = Carbon::parse($conditionValue[0]);
        $endDate = Carbon::parse($conditionValue[1]);

        return $date->between($startDate, $endDate, true);
    }
}

