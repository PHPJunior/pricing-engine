<?php

return [
    'models' => [
        'pricing_rule' => \PhpJunior\PricingEngine\Models\PricingRule::class,
        'rule_usage' => \PhpJunior\PricingEngine\Models\RuleUsage::class,
    ],
    'table_names' => [
        'pricing_rules' => 'pricing_rules',
        'rule_usages' => 'rule_usages',
    ],
    'highest_priority_first' => true, // true for highest priority first, false for lowest priority first
    'save_usage_records' => false, // whether to save rule usage records
    'operators' => [
        '=' => \PhpJunior\PricingEngine\Operators\EqualOperator::class,
        '!=' => \PhpJunior\PricingEngine\Operators\NotEqualOperator::class,
        '>' => \PhpJunior\PricingEngine\Operators\GreaterThanOperator::class,
        '>=' => \PhpJunior\PricingEngine\Operators\GreaterThanOrEqualOperator::class,
        '<' => \PhpJunior\PricingEngine\Operators\LessThanOperator::class,
        '<=' => \PhpJunior\PricingEngine\Operators\LessThanOrEqualOperator::class,
        'in' => \PhpJunior\PricingEngine\Operators\InOperator::class,
        'not_in' => \PhpJunior\PricingEngine\Operators\NotInOperator::class,
        'after' => \PhpJunior\PricingEngine\Operators\AfterOperator::class,
        'before' => \PhpJunior\PricingEngine\Operators\BeforeOperator::class,
        'date_equals' => \PhpJunior\PricingEngine\Operators\DateEqualsOperator::class,
        'date_between' => \PhpJunior\PricingEngine\Operators\DateBetweenOperator::class,
        'time_between' => \PhpJunior\PricingEngine\Operators\TimeBetweenOperator::class,
        'day_of_week' => \PhpJunior\PricingEngine\Operators\DayOfWeekOperator::class,
        'location_in' => \PhpJunior\PricingEngine\Operators\LocationInOperator::class,
        'location_not_in' => \PhpJunior\PricingEngine\Operators\LocationNotInOperator::class,
    ],
    'actions' => [
        'percentage_discount' => \PhpJunior\PricingEngine\Actions\PercentageDiscountAction::class,
        'fixed_discount' => \PhpJunior\PricingEngine\Actions\FixedDiscountAction::class,
        'percentage_markup' => \PhpJunior\PricingEngine\Actions\PercentageMarkupAction::class,
        'fixed_markup' => \PhpJunior\PricingEngine\Actions\FixedMarkupAction::class,
    ],
];
