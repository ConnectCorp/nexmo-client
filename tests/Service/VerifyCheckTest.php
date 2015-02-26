<?php

class VerifyCheckTest extends PHPUnit_Framework_TestCase
{
    private $service;

    protected function setUp()
    {
        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $this->service = $this->getMockBuilder('TestVerifyCheck')->setMethods(['exec'])->setConstructorArgs([$client])->getMock();
    }

    public function testInvoke()
    {
        $this->service->expects($this->once())->method('exec')->with(
            [
                'request_id' => 'req_id',
                'code' => '1234',
                'ip_address' => '0.0.0.0'
            ]);

        $this->service->invoke('req_id', '1234', '0.0.0.0');
    }

    public function testGetPath()
    {
        $this->assertEquals($this->service->getPath(), '/verify/check/json');
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


class TestVerifyCheck extends \Nexmo\Service\VerifyCheck
{
    public function testValidateResponse($params)
    {
        return $this->validateResponse($params);
    }
}

 