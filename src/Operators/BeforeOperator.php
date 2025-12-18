<?php

namespace PhpJunior\PricingEngine\Operators;

use Carbon\Carbon;

class BeforeOperator implements OperatorInterface
{
    /**
     * Evaluate if the attribute date is before the condition date.
     *
     * @param mixed $attributeValue The date value from the context.
     * @param mixed $conditionValue The date value from the condition.
     * @return bool
     */
    public function evaluate(mixed $attributeValue, mixed $conditionValue): bool
    {
        return Carbon::parse($attributeValue)->isBefore(Carbon::parse($conditionValue));
    }
}
