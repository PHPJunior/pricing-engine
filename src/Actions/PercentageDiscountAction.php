<?php

namespace PhpJunior\PricingEngine\Actions;

class PercentageDiscountAction implements ActionInterface
{
    /**
     * Applies a percentage discount to a given value.
     *
     * @param mixed $value The original price.
     * @param mixed $discount The percentage to deduct (e.g., 10 for 10%).
     * @return float|int
     */
    public function execute(...$parameters): mixed
    {
        [$value, $discount] = $parameters;

        return $value - ($value * ($discount / 100));
    }
}

