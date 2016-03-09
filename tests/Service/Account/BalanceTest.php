<?php

namespace Nexmo\Tests\Service\Account;

use Nexmo\Service\Account\Balance;

class BalanceTest extends AccountTestCase
{
    /**
     * @var Balance
     */
    private $service;

    protected function setUp()
    {
        $this->service = new Balance();
        $this->service->setClient($this->guzzle());
    }

    public function testInvoke()
    {
        $this->addJsonResponse([
            'value' => '0.05',
        ]);
        $this->assertSame(0.05, $this->service->invoke());
    }

    public function testGetEndpoint()
    {
        $this->assertSame('account/get-balance', $this->service->getEndpoint());
    }

    public function testValidateResponseStatusProperty()
    {
        $this->addJsonResponse([]);
        $this->setExpectedException('\Nexmo\Exception', 'value property expected');
        $this->service->invoke();
    }
}
