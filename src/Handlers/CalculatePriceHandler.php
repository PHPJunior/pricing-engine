<?php

namespace PhpJunior\PricingEngine\Handlers;

use Illuminate\Support\Arr;
use PhpJunior\PricingEngine\Data\RuleData;
use PhpJunior\PricingEngine\Repositories\PricingRuleRepository;

class CalculatePriceHandler
{
    private bool $highestPriorityFirst;

    public function __construct(private readonly PricingRuleRepository $repository)
    {
        $this->highestPriorityFirst = config('pricing-engine.highest_priority_first', true);
    }

    /**
     * @param CalculatePriceQuery $query
     * @return array
     */
    public function handle(CalculatePriceQuery $query): array
    {
        $rules = $this->getSortedRules();

        $price = $query->basePrice;
        $appliedRules = [];

        foreach ($rules as $rule) {
            if ($this->applyRule($rule, $price, $query->context)) {
                $appliedRules[] = Arr::only($rule->toArray(), ['id', 'name']);
            }
        }

        return [
            'original_price' => $query->basePrice,
            'final_price' => max(0, $price),
            'applied_rules' => $appliedRules,
        ];
    }

    /**
     * @return array
     */
    private function getSortedRules(): array
    {
        $rules = $this->repository->findAllActive();

        usort($rules, fn (RuleData $a, RuleData $b) => $this->highestPriorityFirst
            ? $b->priority <=> $a->priority
            : $a->priority <=> $b->priority);

        return $rules;
    }

    /**
     * @param RuleData $rule
     * @param float $currentPrice
     * @param array $context
     * @return bool
     */
    private function applyRule(RuleData $rule, float &$currentPrice, array $context): bool
    {
        if (!$rule->conditionsMet($context)) {
            return false;
        }

        $priceBeforeRule = $currentPrice;

        foreach ($rule->actions as $action) {
            $currentPrice = $this->applyAction($action, $currentPrice, $context);
        }

        if ($priceBeforeRule !== $currentPrice) {
            $this->recordRuleUsage($rule, $priceBeforeRule, $currentPrice);
            return true;
        }

        return false;
    }

    /**
     * @param object $action
     * @param float $price
     * @param array $context
     * @return float
     */
    private function applyAction(object $action, float $price, array $context): float
    {
        $actionClass = config("pricing-engine.actions.{$action->type}");

        if (!$actionClass) {
            return $price;
        }

        return app($actionClass)->execute($price, $action->value, $context);
    }

    /**
     * @param RuleData $rule
     * @param float $priceBefore
     * @param float $priceAfter
     * @return void
     */
    private function recordRuleUsage(RuleData $rule, float $priceBefore, float $priceAfter): void
    {
        $this->repository->find($rule->id)->ruleUsages()->create([
            'discount_amount' => $priceBefore - $priceAfter,
            'final_price' => $priceAfter,
        ]);
    }
}
