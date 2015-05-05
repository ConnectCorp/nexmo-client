<?php
namespace Nexmo\Tests\Entity;

use Nexmo\Entity\PricingPhone;
use Nexmo\Tests\TestCase;

class PricingPhoneTest extends TestCase
{
    /**
     * @var PricingPhone
     */
    protected $pricing;

    protected function setUp()
    {
        parent::setUp();
        $this->pricing = new PricingPhone($this->getPricing());
    }

    protected function getPricing()
    {
        return [
            'country-code' => 'US',
            'network'      => '12345',
            'phone'        => '1234567890',
            'price'        => '0.05',
        ];
    }

    public function testCountryCode()
    {
        $this->assertSame('US', $this->pricing->countryCode());
    }

    public function testNetworkCode()
    {
        $this->assertSame('12345', $this->pricing->networkCode());
    }

    public function testNumber()
    {
        $this->assertSame('1234567890', $this->pricing->number());
    }

    public function testPrice()
    {
        $this->assertSame(0.05, $this->pricing->price());
    }
}
