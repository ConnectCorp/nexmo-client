<?php

namespace Nexmo\Tests\Service;

use Nexmo\Service\MarketingMessage;
use Nexmo\Tests\TestCase;

class MarketingMessageTest extends TestCase
{
    /**
     * @var MarketingMessageMock
     */
    private $service;
    protected function setUp()
    {
        $this->service = new MarketingMessageMock();
        $this->service->setClient($this->guzzle());
    }
    public function testInvoke()
    {
        $this->service->invoke(62687, 'test-keyword', 5005551111, 'test message');
        $this->assertSame($this->service->executedParams, [
            'from' => 62687,
            'keyword' => 'test-keyword',
            'to' => 5005551111,
            'text' => 'test message'
        ]);
    }
    public function testGetEndpoint()
    {
        $this->assertEquals($this->service->getEndpoint(), 'sc/us/marketing/json');
    }
    public function testFromParameterRequired()
    {
        $this->setExpectedException('\Nexmo\Exception', '$from parameter cannot be blank');
        $this->service->invoke();
    }
    public function testKeywordParameterRequired()
    {
        $this->setExpectedException('\Nexmo\Exception', '$keyword parameter cannot be blank');
        $this->service->invoke(62687);
    }
    public function testToParameterRequired()
    {
        $this->setExpectedException('\Nexmo\Exception', '$to parameter cannot be blank');
        $this->service->invoke(62687, 'test-keyword');
    }
    public function testTextParameterRequired()
    {
        $this->setExpectedException('\Nexmo\Exception', '$text parameter cannot be blank');
        $this->service->invoke(62687, 'test-keyword', 5005551111);
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
class MarketingMessageMock extends MarketingMessage
{
    use TestServiceTrait;
}
