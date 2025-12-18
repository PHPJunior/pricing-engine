<?php

namespace PhpJunior\PricingEngine\Actions;

class PercentageMarkupAction implements ActionInterface
{
    /**
     * Applies a percentage markup to a given value.
     *
     * @param mixed $value The original value.
     * @param mixed $markup The percentage to add (e.g., 10 for 10%).
     * @return float|int
     */
    public function execute(...$parameters): mixed
    {
        [$value, $markup] = $parameters;

        return $value + ($value * ($markup / 100));
    }
}


