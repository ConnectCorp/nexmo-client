<?php

class VerifyTest extends PHPUnit_Framework_TestCase
{
    private $service;

    protected function setUp()
    {
        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $this->service = $this->getMockBuilder('VerifyMock')->setMethods(['exec'])->setConstructorArgs([$client])->getMock();
    }

    public function testInvoke()
    {
        $this->service->expects($this->once())->method('exec')->with(
            [
                'number' => 12345,
                'brand' => 'brand',
                'sender_id' => 'id',
                'code_length' => 4,
                'lg' => 'lg',
                'require_type' => 'type'
            ]);

        $this->service->invoke(12345, 'brand', 'id', 4, 'lg', 'type');
    }

    public function testCheck()
    {
        $this->assertInstanceOf('\Nexmo\Service\VerifyCheck', $this->service->check);
    }

    public function testNumberParameterRequired()
    {
        $this->setExpectedException('\Nexmo\Exception', '$number parameter cannot be blank');
        $this->service->invoke();
    }


    public function testBrandParameterRequired()
    {
        $this->setExpectedException('\Nexmo\Exception', '$brand parameter cannot be blank');
        $this->service->invoke(5005550000);
    }


    public function testGetEndpoint()
    {
        $this->assertEquals($this->service->getEndpoint(), 'https://api.nexmo.com/verify/json');
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


    public function testValidateResponseRequestIdRequired()
    {
        $this->setExpectedException('\Nexmo\Exception', 'request_id property expected');

        $this->service->testValidateResponse(['status' => 0]);
    }

    public function testValidateResponseSuccess()
    {
        $this->assertTrue($this->service->testValidateResponse(['status' => 0, 'request_id' => 1]));
    }
}

class VerifyMock extends \Nexmo\Service\Verify
{
    public function testValidateResponse($params)
    {
        return $this->validateResponse($params);
    }
}
 