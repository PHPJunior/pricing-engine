<?php

namespace PhpJunior\PricingEngine\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use PhpJunior\PricingEngine\Data\ActionData;
use PhpJunior\PricingEngine\Data\ConditionData;
use PhpJunior\PricingEngine\Data\RuleData;

class PricingRuleRepository
{
    public $model;

    /**
     *
     */
    public function __construct()
    {
        $this->model = config('pricing-engine.models.pricing_rule');
    }

    /**
     * @param RuleData $rule
     * @return Model
     */
    public function save(RuleData $rule): Model
    {
        return $this->model::updateOrCreate(
            [
                'id' => $rule->id ?? (string) Str::uuid()
            ],
            [
                'name' => $rule->name,
                'priority' => $rule->priority,
                'conditions' => Arr::map($rule->conditions, fn($condition) => $condition->toArray()),
                'actions' => Arr::map($rule->actions, fn($action) => $action->toArray()),
            ]
        );
    }

    /**
     * @param string $id
     * @return RuleData|null
     */
    public function find(string $id): ?Model
    {
        return $this->model::find($id);
    }

    /**
     * @return array
     */
    public function findAllActive(): array
    {
        return $this->model::all()->map(fn($m) => $this->toRuleData($m))->toArray();
    }

    /**
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        return $this->model::where('id', $id)->delete();
    }

    /**
     * @param Model $pricingRule
     * @return RuleData
     */
    private function toRuleData(Model $pricingRule): RuleData
    {
        return new RuleData(
            id: $pricingRule->id,
            name: $pricingRule->name,
            priority: $pricingRule->priority,
            conditions: Arr::map($pricingRule->conditions, fn($condition) => ConditionData::fromArray($condition)),
            actions: Arr::map($pricingRule->actions, fn($action) => ActionData::fromArray($action)),
        );
    }
}
