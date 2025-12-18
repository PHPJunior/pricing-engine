<?php

namespace PhpJunior\PricingEngine\Data;

use InvalidArgumentException;

class ConditionData
{
    public function __construct(
        public readonly string $attribute,
        public readonly string $operator,
        public readonly mixed $value
    )
    {
        if (empty($this->attribute)) {
            throw new InvalidArgumentException('Attribute cannot be empty');
        }

        $operators = array_keys(config('pricing-engine.operators'));
        if (!in_array($this->operator, $operators, true)) {
            throw new InvalidArgumentException("Invalid operator: {$this->operator}");
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'attribute' => $this->attribute,
            'operator' => $this->operator,
            'value' => $this->value,
        ];
    }

    /**
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['attribute'],
            $data['operator'],
            $data['value']
        );
    }
}
