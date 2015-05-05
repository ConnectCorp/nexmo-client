<?php
namespace Nexmo\Tests\Service;

use Nexmo\Service\Account;

class AccountTest extends ResourceCollectionTestCase
{
    /**
     * @var AccountMock
     */
    protected $account;

    protected function setUp()
    {
        parent::setUp();
        $this->account = $this->service();
    }

    protected function createService()
    {
        return new AccountMock();
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
}

class AccountMock extends Account
{
    use ResourceCollectionMockTrait;
}
