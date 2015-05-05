<?php

namespace Nexmo\Tests\Entity;

use Nexmo\Entity\Pricing;
use Nexmo\Tests\TestCase;

class PricingTest extends TestCase
{
    /**
     * @var Pricing
     */
    protected $pricing;

    protected function setUp()
    {
        parent::setUp();
        $this->pricing = new Pricing($this->getPricing());
    }

    protected function getPricing()
    {
        return [
            'country' => 'US',
            'name' => 'United States',
            'prefix' => '1',
            'mt' => '0.05',
            'networks' => [
                [
                    'code'    => '123456',
                    'mtPrice' => '0.05',
                    'network' => 'Network name',
                ],
                [
                    'code'    => '123457',
                    'mtPrice' => '0.07',
                    'network' => 'Network name 2',
                ]
            ],
        ];
    }

    public function testCountryCode()
    {
        $this->assertSame('US', $this->pricing->countryCode());
    }

    public function testCountryName()
    {
        $this->assertSame('United States', $this->pricing->countryName());
    }

    public function testPrefix()
    {
        $this->assertSame(1, $this->pricing->countryPrefix());
    }

    public function testPrice()
    {
        $this->assertSame(0.05, $this->pricing->price());
    }

    public function testNetworkObjects()
    {
        foreach ($this->pricing->networks() as $network) {
            $this->assertInstanceOf('\Nexmo\Entity\Network', $network);
        }
    }
}
