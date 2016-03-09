<?php

namespace Nexmo\Tests\Service\Account;

use Nexmo\Service\Account\Numbers;

class NumbersTest extends AccountTestCase
{
    /**
     * @var NumbersMock
     */
    private $service;

    protected function setUp()
    {
        $this->service = new NumbersMock();
        $this->service->setClient($this->guzzle());
    }

    public function testInvoke()
    {
        $this->addResponse($this->validResponse());
        $this->service->invoke(1, 10, 1234, 1);
        $this->assertSame([
            'index' => 1,
            'size' => 10,
            'pattern' => 1234,
            'search_pattern' => 1,
        ], $this->service->executedParams);
    }

    public function testMaxSize()
    {
        $this->addResponse($this->validResponse());
        $this->service->invoke(1, 9000);
        $this->assertSame(100, $this->service->executedParams['size']);
    }

    public function testResponse()
    {
        $this->addResponse($this->validResponse());
        $numbers = $this->service->invoke();
        $this->assertInstanceOf('\Nexmo\Entity\NumberCollection', $numbers);
        $this->assertCount(5, $numbers);
        $this->assertCount(1, $numbers->numbers());
    }

    public function testGetEndpoint()
    {
        $this->assertSame('account/numbers', $this->service->getEndpoint());
    }

    public function testValidateResponseCountProperty()
    {
        $response = $this->validResponse();
        unset($response['count']);
        $this->assertInvalidResponseException($response, 'count');
    }

    public function testValidateResponseNumbersProperty()
    {
        $response = $this->validResponse();
        unset($response['numbers']);
        $this->assertInvalidResponseException($response, 'numbers array');
    }

    public function testValidateResponseNumbersPropertyIsArray()
    {
        $response = $this->validResponse();
        $response['numbers'] = null;
        $this->assertInvalidResponseException($response, 'numbers array');
    }

    public function testValidateResponseNumberCountryProperty()
    {
        $response = $this->validResponse();
        unset($response['numbers'][0]['country']);
        $this->assertInvalidResponseException($response, 'number.country');
    }

    public function testValidateResponseNumberMsisdnProperty()
    {
        $response = $this->validResponse();
        unset($response['numbers'][0]['msisdn']);
        $this->assertInvalidResponseException($response, 'number.msisdn');
    }

    public function testValidateResponseNumberTypeProperty()
    {
        $response = $this->validResponse();
        unset($response['numbers'][0]['type']);
        $this->assertInvalidResponseException($response, 'number.type');
    }

    public function testValidateResponseNumberFeaturesProperty()
    {
        $response = $this->validResponse();
        unset($response['numbers'][0]['features']);
        $this->assertInvalidResponseException($response, 'number.features array');
    }

    public function testValidateResponseNumberFeaturesPropertyIsArray()
    {
        $response = $this->validResponse();
        $response['numbers'][0]['features'] = null;
        $this->assertInvalidResponseException($response, 'number.features array');
    }

    public function testValidateResponseNumberMoHttpUrlProperty()
    {
        $response = $this->validResponse();
        unset($response['numbers'][0]['moHttpUrl']);
        $this->assertInvalidResponseException($response, 'number.moHttpUrl');
    }

    protected function assertInvalidResponseException($response, $field)
    {
        $this->addResponse($response);
        $this->setExpectedException('\Nexmo\Exception', $field . ' property expected');
        $this->service->invoke();
    }

    protected function validResponse()
    {
        return [
            'count' => 5,
            'numbers' => [
                [
                    'country' => 'US',
                    'msisdn' => '1234567890',
                    'type' => 'mobile',
                    'features' => ['SMS'],
                    'moHttpUrl' => 'http://www.nexmo.com',
                ]
            ],
        ];
    }
}

class NumbersMock extends Numbers
{
    public $executedParams;

    protected function exec($params, $method = 'GET')
    {
        $this->executedParams = $params;
        return parent::exec($params);
    }
}
