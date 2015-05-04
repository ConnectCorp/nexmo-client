<?php
namespace Nexmo\Tests\Service;

use Nexmo\Service\Account;
use Nexmo\Tests\TestCase;

class AccountTest extends TestCase
{
    /**
     * @var AccountMock
     */
    private $account;

    protected function setUp()
    {
        $this->account = new AccountMock();
        $this->account->setClient($this->guzzle());
    }

    public function testProperties()
    {
        $this->assertInstanceOf('\Nexmo\Service\Account\Balance', $this->account->balance);
        $this->assertInstanceOf('\Nexmo\Service\Account\Numbers', $this->account->numbers);
        $this->assertInstanceOf('\Nexmo\Service\Account\Pricing', $this->account->pricing);
        $this->assertInstanceOf('\Nexmo\Service\Account\PricingInternational', $this->account->pricingInternational);
        $this->assertInstanceOf('\Nexmo\Service\Account\PricingPhone', $this->account->pricingPhone);
    }

    public function testInvalidProperty()
    {
        $this->setExpectedException('\Nexmo\Exception', 'Class \Nexmo\Service\Account\Foo is not a Nexmo Resource');
        $this->account->foo;
    }

    public function testBalance()
    {
        $this->account->balance();
        $this->assertResourceInitialized('balance');
    }

    public function testNumbers()
    {
        $this->account->numbers(2, 12, 1234, 2);
        $this->assertResourceInitialized('numbers');
    }

    public function testPricing()
    {
        $this->account->pricing('US');
        $this->assertResourceInitialized('pricing');
    }

    public function testPricingInternational()
    {
        $this->account->pricingInternational(1);
        $this->assertResourceInitialized('pricingInternational');
    }

    public function testPricingSms()
    {
        $this->account->pricingSms(1234567890);
        $this->assertResourceInitialized('pricingPhone');
    }

    public function testPricingVoice()
    {
        $this->account->pricingVoice(1234567890);
        $this->assertResourceInitialized('pricingPhone');
    }

    protected function assertResourceInitialized($resource)
    {
        $this->assertTrue($this->account->isResourceInitialized($resource), $resource . ' has not been initialized');
    }
}

class AccountMock extends Account
{
    protected $generator;

    public function __construct()
    {
        $this->generator = new \PHPUnit_Framework_MockObject_Generator;
    }

    public function getNamespace()
    {
        return '\\Nexmo\\Service\\' . $this->getNamespaceSuffix();
    }

    protected function initializeClass($class)
    {
        return $this->generator->getMock($class);
    }

    public function isResourceInitialized($resource)
    {
        return isset($this->resources[$resource]);
    }
}
