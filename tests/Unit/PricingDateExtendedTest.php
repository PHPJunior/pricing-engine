<?php

namespace PhpJunior\PricingEngine\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpJunior\PricingEngine\Data\ActionData;
use PhpJunior\PricingEngine\Data\ConditionData;
use PhpJunior\PricingEngine\Facades\PricingEngine;
use PhpJunior\PricingEngine\Tests\TestCase;

class PricingDateExtendedTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_match_date_after_condition()
    {
        PricingEngine::make()->savePricingRule(
            name: 'Last Minute Deal',
            priority: 1,
            conditions: [
                new ConditionData(
                    attribute: 'booking_date',
                    operator: 'after',
                    value: '2024-01-01'
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
                'booking_date' => '2024-02-15'
            ]
        );
        $this->assertEquals(170, $result['final_price']);
    }

    public function test_can_match_date_after_condition_not_matching()
    {
        PricingEngine::make()->savePricingRule(
            name: 'Last Minute Deal',
            priority: 1,
            conditions: [
                new ConditionData(
                    attribute: 'booking_date',
                    operator: 'after',
                    value: '2024-01-01'
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
                'booking_date' => '2023-12-31'
            ]
        );
        $this->assertEquals(200, $result['final_price']);
    }

    public function test_can_match_date_equals_condition()
    {
        PricingEngine::make()->savePricingRule(
            name: 'Special Event Discount',
            priority: 1,
            conditions: [
                new ConditionData(
                    attribute: 'event_date',
                    operator: 'date_equals',
                    value: '2024-12-25'
                )
            ],
            actions: [
                new ActionData(
                    type: 'fixed_discount',
                    value: 30
                )
            ]
        );

        $result = PricingEngine::calculatePrice(
            basePrice: 150,
            context: [
                'event_date' => '2024-12-25'
            ]
        );
        $this->assertEquals(120, $result['final_price']);
    }

    public function test_can_match_date_equals_condition_not_matching()
    {
        PricingEngine::make()->savePricingRule(
            name: 'Special Event Discount',
            priority: 1,
            conditions: [
                new ConditionData(
                    attribute: 'event_date',
                    operator: 'date_equals',
                    value: '2024-12-25'
                )
            ],
            actions: [
                new ActionData(
                    type: 'fixed_discount',
                    value: 30
                )
            ]
        );

        $result = PricingEngine::calculatePrice(
            basePrice: 150,
            context: [
                'event_date' => '2024-12-24'
            ]
        );
        $this->assertEquals(150, $result['final_price']);
    }
}
