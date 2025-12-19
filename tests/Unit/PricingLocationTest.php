<?php

namespace PhpJunior\PricingEngine\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpJunior\PricingEngine\Data\ActionData;
use PhpJunior\PricingEngine\Data\ConditionData;
use PhpJunior\PricingEngine\Facades\PricingEngine;
use PhpJunior\PricingEngine\Tests\TestCase;
use Stevebauman\Location\Facades\Location;
use Stevebauman\Location\Position;

class PricingLocationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws \Exception
     */
    public function test_location_in_operator_pricing_rule()
    {
        Location::fake([
            '127.0.0.1' => Position::make([
                'countryName' => 'Wakanda',
                'countryCode' => 'WK',
            ]),
            '127.0.0.2' => Position::make([
                'countryName' => 'Narnia',
                'countryCode' => 'NA'
            ]),
            '127.0.0.3' => Position::make([
                'countryName' => 'Middle Earth',
                'countryCode' => 'ME'
            ]),
            '127.0.0.4' => Position::make([
                'countryName' => 'Asgard',
                'countryCode' => 'AS'
            ])
        ]);

        PricingEngine::make()->savePricingRule(
            name: 'Location Based Discount',
            priority: 1,
            conditions: [
                new ConditionData(
                    attribute: 'ip_address',
                    operator: 'location_in',
                    value: ['WK', 'NA']
                )
            ],
            actions: [
                new ActionData(
                    type: 'percentage_discount',
                    value: 10
                )
            ]
        );

        $result = PricingEngine::calculatePrice(
            basePrice: 100,
            context: [
                'ip_address' => '127.0.0.1'
            ]
        );

        $this->assertEquals(90, $result['final_price']);
    }

    /**
     * @throws \Exception
     */
    public function test_location_not_in_operator_pricing_rule()
    {
        Location::fake([
            '127.0.0.1' => Position::make([
                'countryName' => 'Wakanda',
                'countryCode' => 'WK',
            ]),
            '127.0.0.2' => Position::make([
                'countryName' => 'Narnia',
                'countryCode' => 'NA'
            ]),
            '127.0.0.3' => Position::make([
                'countryName' => 'Middle Earth',
                'countryCode' => 'ME'
            ]),
            '127.0.0.4' => Position::make([
                'countryName' => 'Asgard',
                'countryCode' => 'AS'
            ])
        ]);

        PricingEngine::make()->savePricingRule(
            name: 'Location Based Discount',
            priority: 1,
            conditions: [
                new ConditionData(
                    attribute: 'ip_address',
                    operator: 'location_not_in',
                    value: ['WK', 'NA']
                )
            ],
            actions: [
                new ActionData(
                    type: 'percentage_discount',
                    value: 10
                )
            ]
        );

        $result = PricingEngine::calculatePrice(
            basePrice: 100,
            context: [
                'ip_address' => '127.0.0.4'
            ]
        );
        $this->assertEquals(90, $result['final_price']);

        $result = PricingEngine::calculatePrice(
            basePrice: 100,
            context: [
                'ip_address' => '127.0.0.1'
            ]
        );
        $this->assertEquals(100, $result['final_price']);
    }
}
