<?php

namespace PhpJunior\PricingEngine\Data;

use Illuminate\Support\Collection;

class RuleData
{
    public function __construct(
        public readonly ?string $id,
        public string $name,
        public int $priority,
        public array $conditions,
        public array $actions
    ) {
    }

    /**
     * @param array $context
     * @return bool
     */
    public function conditionsMet(array $context): bool
    {
        return collect($this->conditions)->every(fn (ConditionData $condition) => $this->evaluateCondition($condition, $context));
    }

    /**
     * @param ConditionData $condition
     * @param array $context
     * @return bool
     */
    private function evaluateCondition(ConditionData $condition, array $context): bool
    {
        $attributeValue = $context[$condition->attribute] ?? null;
        $operatorClass = config('pricing-engine.operators')[$condition->operator] ?? null;

        if (is_null($attributeValue) || is_null($operatorClass)) {
            return false;
        }

        return app($operatorClass)->evaluate($attributeValue, $condition->value);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'priority' => $this->priority,
            'conditions' => $this->conditions,
            'actions' => $this->actions,
        ];
    }
}
