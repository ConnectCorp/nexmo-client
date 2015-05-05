<?php
namespace Nexmo\Tests\Service\Account;

use Nexmo\Service\Account\Pricing;
use Nexmo\Tests\Service\ResourceCollectionMockTrait;
use Nexmo\Tests\TestCase;

class PricingTest extends TestCase
{
    /**
     * @var PricingMock
     */
    private $pricing;

    protected function setUp()
    {
        $this->pricing = new PricingMock();
        $this->pricing->setClient($this->guzzle());
    }

    public function testProperties()
    {
        $this->assertInstanceOf('\Nexmo\Service\Account\Pricing\Country', $this->pricing->country);
        $this->assertInstanceOf('\Nexmo\Service\Account\Pricing\International', $this->pricing->international);
        $this->assertInstanceOf('\Nexmo\Service\Account\Pricing\Phone', $this->pricing->phone);
    }

    public function testCountry()
    {
        $this->pricing->country('US');
        $this->assertResourceInitialized('country');
    }

    public function testPricingInternational()
    {
        $this->pricing->international(1);
        $this->assertResourceInitialized('international');
    }

    public function testPricingSms()
    {
        $this->pricing->sms(1234567890);
        $this->assertResourceInitialized('phone');
    }

    public function testPricingVoice()
    {
        $this->pricing->voice(1234567890);
        $this->assertResourceInitialized('phone');
    }

    protected function assertResourceInitialized($resource)
    {
        $this->assertTrue($this->pricing->isResourceInitialized($resource), $resource . ' has not been initialized');
    }
}

class PricingMock extends Pricing
{
    use ResourceCollectionMockTrait;
}
