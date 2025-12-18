<?php

namespace PhpJunior\PricingEngine\Actions;

class FixedMarkupAction implements ActionInterface
{
    /**
     * Applies a fixed markup to a given value.
     *
     * @param mixed $value The original value.
     * @param mixed $markup The fixed amount to add.
     * @return float|int
     */
    public function execute(...$parameters): mixed
    {
        [$value, $markup] = $parameters;

        return $value + $markup;
    }
}

