<?php

namespace Nexmo\Tests\Service;

use Nexmo\Service\Message;
use Nexmo\Tests\TestCase;

class MessageTest extends TestCase
{
    private $service;

    protected function setUp()
    {
        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $this->service = $this->getMockBuilder('MessageMock')->setMethods(['exec'])->setConstructorArgs([$client])->getMock();
    }

    public function testInvoke()
    {
        $this->service->expects($this->once())->method('exec')->with(
            [
                'from' => 5005550000,
                'to' => '5005551111',
                'type' => 'text',
                'text' => 'message',
                'status_report_req' => 'status_rep_req',
                'client_ref' => 'client_ref',
                'network_code' => 'net_code',
                'vcard' => 'vcard',
                'vcal' => 'vcal',
                'ttl' => 1,
                'message_class' => 'class',
                'body' => 'body',
                'udh' => 'udh'
            ]);

        $this->service->invoke(5005550000, 5005551111, 'text', 'message', 'status_rep_req', 'client_ref', 'net_code', 'vcard', 'vcal', 1, 'class', 'body', 'udh');
    }

    public function testGetEndpoint()
    {
        $this->assertEquals($this->service->getEndpoint(), 'https://rest.nexmo.com/sms/json');
    }

    public function testFromParameterRequired()
    {
        $this->setExpectedException('\Nexmo\Exception', '$from parameter cannot be blank');
        $this->service->invoke();
    }


    public function testToParameterRequired()
    {
        $this->setExpectedException('\Nexmo\Exception', '$to parameter cannot be blank');
        $this->service->invoke(5005550000);
    }

    public function testTextParameterRequired()
    {
        $this->setExpectedException('\Nexmo\Exception', '$text parameter cannot be blank');
        $this->service->invoke(5005550000, 5005550001);
    }

    public function testValidateResponseMessageCountProperty()
    {
        $this->setExpectedException('\Nexmo\Exception', 'message-count property expected');

        $this->service->testValidateResponse([]);
    }

    public function testValidateResponseMessagesProperty()
    {
        $this->setExpectedException('\Nexmo\Exception', 'messages property expected');

        $this->service->testValidateResponse(['message-count' => 1]);
    }

    public function testValidateResponseStatusProperty()
    {
        $this->setExpectedException('\Nexmo\Exception', 'status property expected');

        $this->service->testValidateResponse(['message-count' => 1, 'messages' => ['error']]);
    }

    public function testValidateResponseStatusNotZero()
    {
        $this->setExpectedException('\Nexmo\Exception', 'Unable to send sms message: status 1');

        $this->service->testValidateResponse(['message-count' => 1, 'messages' => [['status' => 1]]]);
    }


    public function testValidateResponseErrorText()
    {
        $this->setExpectedException('\Nexmo\Exception', 'Unable to send sms message: error - status 2');

        $this->service->testValidateResponse(['message-count' => 1, 'messages' => [['error-text' => 'error', 'status' => 2]]]);
    }


    public function testValidateResponseSuccess()
    {
        $this->assertTrue($this->service->testValidateResponse(['message-count' => 1, 'messages' => [['status' => 0]]]));
    }
}

class MessageMock extends Message
{
    public function testValidateResponse($params)
    {
        return $this->validateResponse($params);
    }
}
