<?php

namespace PhpJunior\PricingEngine\Data;

use InvalidArgumentException;

class ActionData
{
    public function __construct(
        public readonly string $type,
        public readonly mixed $value,
    ) {
        if (empty($type)) {
            throw new InvalidArgumentException('ActionData type cannot be empty');
        }

        $actionTypes = array_keys(config('pricing-engine.actions'));
        if (!in_array($this->type, $actionTypes, true)) {
            throw new InvalidArgumentException("Invalid action type: {$this->type}");
        }
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
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
            $data['type'],
            $data['value']
        );
    }
}
