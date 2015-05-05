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
