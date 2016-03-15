<?php

namespace Nexmo\Tests\Service\Account\Pricing;

use Nexmo\Service\Account\Pricing\Phone;
use Nexmo\Tests\Service\Account\AccountTestCase;

class PhoneTest extends AccountTestCase
{
    /**
     * @var PhoneMock
     */
    private $service;

    protected function setUp()
    {
        $this->service = new PhoneMock();
        $this->service->setClient($this->guzzle());
    }

    public function testInvokeSms()
    {
        $this->addResponse($this->validResponse());
        $pricing = $this->service->invoke('sms', 1234567890);
        $this->assertSame([
            'phone' => 1234567890,
        ], $this->service->executedParams);
        $this->assertSame('account/get-phone-pricing/outbound/sms', $this->service->getEndpoint());
        $this->assertInstanceOf('\Nexmo\Entity\PricingPhone', $pricing);
    }

    public function testInvokeVoice()
    {
        $this->addResponse($this->validResponse());
        $pricing = $this->service->invoke('voice', 1234567890);
        $this->assertSame([
            'phone' => 1234567890,
        ], $this->service->executedParams);
        $this->assertSame('account/get-phone-pricing/outbound/voice', $this->service->getEndpoint());
        $this->assertInstanceOf('\Nexmo\Entity\PricingPhone', $pricing);
    }

    public function testMissingProductParameter()
    {
        $this->setExpectedException('\Nexmo\Exception', '$product parameter cannot be blank');
        $this->service->invoke(null, 1234567890);
    }

    public function testInvalidProductParameter()
    {
        $this->setExpectedException('\Nexmo\Exception', '$product parameter must be "sms" or "voice"');
        $this->service->invoke('foo', 1234567890);
    }

    public function testMissingPhoneParameter()
    {
        $this->setExpectedException('\Nexmo\Exception', '$phone parameter cannot be blank');
        $this->service->invoke('sms', null);
    }

    public function testValidateResponseCountryCodeProperty()
    {
        $response = $this->validResponse();
        unset($response['country-code']);
        $this->assertInvalidResponseException($response, 'country-code');
    }

    public function testValidateResponsePhoneProperty()
    {
        $response = $this->validResponse();
        unset($response['phone']);
        $this->assertInvalidResponseException($response, 'phone');
    }

    public function testValidateResponsePriceProperty()
    {
        $response = $this->validResponse();
        unset($response['price']);
        $this->assertInvalidResponseException($response, 'price');
    }

    protected function assertInvalidResponseException($response, $field)
    {
        $this->addResponse($response);
        $this->setExpectedException('\Nexmo\Exception', $field . ' property expected');
        $this->service->invoke('sms', 124567890);
    }

    protected function validResponse()
    {
        return [
            'country-code' => 'US',
            'phone' => '1234567890',
            'price' => '0.05',
        ];
    }
}

class PhoneMock extends Phone
{
    public $executedParams;

    protected function exec($params, $method = 'GET')
    {
        $this->executedParams = $params;
        return parent::exec($params);
    }
}
