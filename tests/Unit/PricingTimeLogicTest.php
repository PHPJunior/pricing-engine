<?php

namespace PhpJunior\PricingEngine\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpJunior\PricingEngine\Data\ActionData;
use PhpJunior\PricingEngine\Data\ConditionData;
use PhpJunior\PricingEngine\Facades\PricingEngine;
use PhpJunior\PricingEngine\Tests\TestCase;

class PricingTimeLogicTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @throws \Exception
     */
    public function test_happy_hour_pricing()
    {
        PricingEngine::make()->savePricingRule(
            name: 'Test Rule',
            priority: 1,
            conditions: [
                new ConditionData(
                    attribute: 'order_time',
                    operator: 'time_between',
                    value: [
                        '17:00',
                        '19:00'
                    ]
                )
            ],
            actions: [
                new ActionData(
                    type: 'fixed_discount',
                    value: 5
                )
            ]
        );

        $result = PricingEngine::calculatePrice(
            basePrice: 50,
            context: [
                'order_time' => '18:00'
            ]
        );
        $this->assertEquals(45, $result['final_price']);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function test_happy_hour_pricing_outside_time()
    {
        PricingEngine::make()->savePricingRule(
            name: 'Test Rule',
            priority: 1,
            conditions: [
                new ConditionData(
                    attribute: 'order_time',
                    operator: 'time_between',
                    value: [
                        '17:00',
                        '19:00'
                    ]
                )
            ],
            actions: [
                new ActionData(
                    type: 'fixed_discount',
                    value: 5
                )
            ]
        );

        $result = PricingEngine::calculatePrice(
            basePrice: 50,
            context: [
                'order_time' => '16:00'
            ]
        );
        $this->assertEquals(50, $result['final_price']);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function test_weekend_pricing()
    {
        PricingEngine::make()->savePricingRule(
            name: 'Weekend Discount',
            priority: 1,
            conditions: [
                new ConditionData(
                    attribute: 'order_day',
                    operator: 'in',
                    value: ['Saturday', 'Sunday']
                )
            ],
            actions: [
                new ActionData(
                    type: 'percentage_discount',
                    value: 15
                )
            ]
        );

        $result = PricingEngine::calculatePrice(
            basePrice: 200,
            context: [
                'order_day' => 'Sunday'
            ]
        );
        $this->assertEquals(170, $result['final_price']);
    }
}
