<?php

namespace PhpJunior\PricingEngine\Actions;

class FixedDiscountAction implements ActionInterface
{
    /**
     * Applies a fixed discount to a given value.
     *
     * @param mixed $value The original value.
     * @param mixed $discount The fixed amount to deduct.
     * @return float|int
     */
    public function execute(...$parameters): mixed
    {
        [$value, $discount] = $parameters;

        return $value - $discount;
    }
}

