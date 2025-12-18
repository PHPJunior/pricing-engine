# Pricing Engine

[![Latest Version on Packagist](https://img.shields.io/packagist/v/php-junior/pricing-engine.svg?style=flat-square)](https://packagist.org/packages/php-junior/pricing-engine)
[![Total Downloads](https://img.shields.io/packagist/dt/php-junior/pricing-engine.svg?style=flat-square)](https://packagist.org/packages/php-junior/pricing-engine)

A dynamic pricing rule engine for Laravel. This package allows you to define flexible pricing rules based on various conditions and apply actions like discounts or markups.

## Installation

You can install the package via composer:

```bash
composer require php-junior/pricing-engine
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="PhpJunior\PricingEngine\Providers\PricingEngineServiceProvider"
```

You can run the migrations with:

```bash
php artisan migrate
```

## Configuration

The configuration file `config/pricing-engine.php` allows you to customize:
- Model classes
- Table names
- Priority order (highest first or lowest first)
- Available operators
- Available actions

## Usage

### Creating Pricing Rules

You can create pricing rules using the `PricingEngine` facade or service.

```php
use PhpJunior\PricingEngine\Facades\PricingEngine;
use PhpJunior\PricingEngine\Data\ConditionData;
use PhpJunior\PricingEngine\Data\ActionData;

PricingEngine::make()->savePricingRule(
    name: 'VIP Discount',
    priority: 1,
    conditions: [
        new ConditionData(
            attribute: 'customer_group',
            operator: '=',
            value: 'vip'
        ),
        new ConditionData(
            attribute: 'price_total',
            operator: '>',
            value: '100'
        )
    ],
    actions: [
        new ActionData(
            type: 'percentage_discount',
            value: 10
        )
    ]
);

```
Attributes in conditions can be any key.

To update an existing rule, provide the rulr ID in them `make` method:

```php
PricingEngine::make(id: 1)->savePricingRule( ... );
```

To delete a rule, use the `deletePricingRule` method:

```php
PricingEngine::make(id: 1)->deletePricingRule();
```

Fetch all pricing rules:

```php
$rules = PricingEngine::make()->getAllPricingRules();
```

### Calculating Price

To calculate the price based on the defined rules, use the `calculatePrice` method. You need to provide the base price and a context array containing attributes used in your conditions.

```php
use PhpJunior\PricingEngine\Facades\PricingEngine;

$result = PricingEngine::calculatePrice(
    basePrice: 200,
    context: [
        'customer_group' => 'vip',
        'price_total' => 200
    ]
);

// $result will contain:
// [
//     'original_price' => 200,
//     'final_price' => 180,
//     'applied_rules' => [ ... ]
// ]
```

### Available Operators

- `=`
- `!=`
- `>`
- `>=`
- `<`
- `<=`
- `in`
- `not_in`
- `after` (for dates)
- `before` (for dates)
- `date_equals`
- `date_between`
- `time_between`
- `day_of_week`

### Available Actions

- `percentage_discount`
- `fixed_discount`
- `percentage_markup`
- `fixed_markup`

### Adding Custom Operators and Actions
You can create custom operators and actions by implementing the respective interfaces and registering them in the configuration file.

```php
use PhpJunior\PricingEngine\Operators\OperatorInterface;

class CustomOperator implements OperatorInterface
{
    public function evaluate($attributeValue, $conditionValue): bool
    {
        // Custom logic here
    }
}

use PhpJunior\PricingEngine\Actions\ActionInterface;
class CustomAction implements ActionInterface
{
    public function execute(...$parameters): mixed
    {
        // Custom logic here
        // $parameters[0] - base price
        // $parameters[1] - action value
        // $parameters[2] - context array
    }
}
```
Register your custom classes in `config/pricing-engine.php`:

```php
'operators' => [
    'custom_operator' => App\Operators\CustomOperator::class,
],
'actions' => [
    'custom_action' => App\Actions\CustomAction::class,
],
```

Then you can use them in your pricing rules.

```php

use PhpJunior\PricingEngine\Facades\PricingEngine;
use PhpJunior\PricingEngine\Data\ConditionData;
use PhpJunior\PricingEngine\Data\ActionData;

PricingEngine::make()->savePricingRule(
    name: 'Custom Rule',
    priority: 2,
    conditions: [
        new ConditionData(
            attribute: 'custom_attribute',
            operator: 'custom_operator',
            value: 'some_value'
        )
    ],
    actions: [
        new ActionData(
            type: 'custom_action',
            value: 15
        )
    ]
);
```


## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

