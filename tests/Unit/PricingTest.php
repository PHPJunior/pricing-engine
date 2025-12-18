<?php

namespace PhpJunior\PricingEngine\Tests\Unit;

use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpJunior\PricingEngine\Data\ActionData;
use PhpJunior\PricingEngine\Data\ConditionData;
use PhpJunior\PricingEngine\Facades\PricingEngine;
use PhpJunior\PricingEngine\Models\PricingRule;
use PhpJunior\PricingEngine\Tests\TestCase;

class PricingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_pricing_rule()
    {
        $rule = PricingEngine::make()->savePricingRule(
            name: 'Test Rule',
            priority: 1,
            conditions: [
                new ConditionData(
                    attribute: 'price_total',
                    operator: '>',
                    value: '50'
                )
            ],
            actions: [
                new ActionData(
                    type: 'fixed_discount',
                    value: 5
                )
            ]
        );

        $this->assertDatabaseHas(config('pricing-engine.table_names.pricing_rules'), [
            'name' => 'Test Rule',
            'priority' => 1,
        ]);

        $this->assertInstanceOf(PricingRule::class, $rule);
    }

    public function test_can_update_pricing_rule()
    {
        $rule = PricingEngine::make()->savePricingRule(
            name: 'Initial Rule',
            priority: 1,
            conditions: [
                new ConditionData(
                    attribute: 'price_total',
                    operator: '>',
                    value: '50'
                )
            ],
            actions: [
                new ActionData(
                    type: 'fixed_discount',
                    value: 5
                )
            ]
        );

        $updatedRule = PricingEngine::make($rule->id)->savePricingRule(
            name: 'Updated Rule',
            priority: 2,
            conditions: [
                new ConditionData(
                    attribute: 'price_total',
                    operator: '>=',
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

        $this->assertDatabaseHas(config('pricing-engine.table_names.pricing_rules'), [
            'id' => $rule->id,
            'name' => 'Updated Rule',
            'priority' => 2,
        ]);

        $this->assertEquals('Updated Rule', $updatedRule->name);
        $this->assertEquals(2, $updatedRule->priority);
    }

    public function test_can_delete_pricing_rule()
    {
        $rule = PricingEngine::make()->savePricingRule(
            name: 'Delete Me',
            priority: 1,
            conditions: [
                new ConditionData(
                    attribute: 'price_total',
                    operator: '>',
                    value: '50'
                )
            ],
            actions: [
                new ActionData(
                    type: 'fixed_discount',
                    value: 5
                )
            ]
        );

        $deleted = PricingEngine::make($rule->id)->deletePricingRule();

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing(config('pricing-engine.table_names.pricing_rules'), [
            'id' => $rule->id,
        ]);
    }

    /**
     * @throws Exception
     */
    public function test_can_calculate_price_with_matching_rule()
    {
        PricingEngine::make()->savePricingRule(
            name: 'VIP Discount',
            priority: 1,
            conditions: [
                new ConditionData(
                    attribute: 'role',
                    operator: '=',
                    value: 'vip'
                )
            ],
            actions: [
                new ActionData(
                    type: 'percentage_discount',
                    value: 20
                )
            ]
        );

        $result = PricingEngine::calculatePrice(
            basePrice: 250,
            context: ['role' => 'vip']
        );

        $this->assertEquals(200, $result['final_price']);
        $this->assertCount(1, $result['applied_rules']);
    }

    public function test_calculate_price_no_matching_rule()
    {
        PricingEngine::make()->savePricingRule(
            name: 'VIP Discount',
            priority: 1,
            conditions: [
                new ConditionData(
                    attribute: 'role',
                    operator: '=',
                    value: 'vip'
                )
            ],
            actions: [
                new ActionData(
                    type: 'percentage_discount',
                    value: 20
                )
            ]
        );

        $result = PricingEngine::calculatePrice(
            basePrice: 150,
            context: ['role' => 'regular']
        );

        $this->assertEquals(150, $result['final_price']);
        $this->assertCount(0, $result['applied_rules']);
    }
}
