<?php

namespace Nexmo\Tests\Service;

use Nexmo\Service\VerifyCheck;
use Nexmo\Tests\TestCase;

class VerifyCheckTest extends TestCase
{
    /**
     * @var VerifyCheckMock
     */
    private $service;

    protected function setUp()
    {
        $this->service = new VerifyCheckMock();
        $this->service->setClient($this->guzzle());
    }

    public function testInvoke()
    {
        $this->service->invoke('req_id', '1234', '0.0.0.0');
        $this->assertSame($this->service->executedParams, [
            'request_id' => 'req_id',
            'code' => '1234',
            'ip_address' => '0.0.0.0'
        ]);
    }

    public function testGetEndpoint()
    {
        $this->assertEquals($this->service->getEndpoint(), 'https://api.nexmo.com/verify/check/json');
    }

    public function testRequestIdParameterRequired()
    {
        $this->setExpectedException('\Nexmo\Exception', '$requestId parameter cannot be blank');
        $this->service->invoke();
    }

    public function testCodeParameterRequired()
    {
        $this->setExpectedException('\Nexmo\Exception', '$code parameter cannot be blank');
        $this->service->invoke('request_id');
    }

    public function testValidateResponseStatusProperty()
    {
        $this->setExpectedException('\Nexmo\Exception', 'status property expected');

        $this->service->testValidateResponse([]);
    }

    public function testValidateResponseStatusNotZero()
    {
        $this->setExpectedException('\Nexmo\Exception', 'Unable to verify number: status 1');

        $this->service->testValidateResponse(['status' => 1]);
    }

    public function testValidateResponseErrorText()
    {
        $this->setExpectedException('\Nexmo\Exception', 'Unable to verify number: error - status 2');

        $this->service->testValidateResponse(['status' => 2, 'error_text' => 'error']);
    }


    public function testValidateResponseSuccess()
    {
        $this->assertTrue($this->service->testValidateResponse(['status' => 0]));
    }
}


class VerifyCheckMock extends VerifyCheck
{
    use TestServiceTrait;
}
