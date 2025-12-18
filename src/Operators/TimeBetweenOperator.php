<?php

namespace PhpJunior\PricingEngine\Operators;

use Carbon\Carbon;

class TimeBetweenOperator implements OperatorInterface
{
    /**
     * Evaluate if the attribute time is between two condition times.
     *
     * @param mixed $attributeValue The time value from the context.
     * @param mixed $conditionValue An array containing the start and end times.
     * @return bool
     */
    public function evaluate(mixed $attributeValue, mixed $conditionValue): bool
    {
        if (!is_array($conditionValue) || count($conditionValue) !== 2) {
            return false;
        }

        $time = Carbon::parse($attributeValue);
        $startTime = Carbon::parse($conditionValue[0]);
        $endTime = Carbon::parse($conditionValue[1]);

        if ($startTime->gt($endTime)) {
            return $time->gte($startTime) || $time->lte($endTime);
        }

        return $time->between($startTime, $endTime, true);
    }
}

