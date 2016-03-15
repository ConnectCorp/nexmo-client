<?php

namespace Nexmo\Tests\Service\Account\Pricing;

use Nexmo\Service\Account\Pricing\Country;
use Nexmo\Tests\Service\Account\AccountTestCase;

class CountryTest extends AccountTestCase
{
    /**
     * @var CountryMock
     */
    private $service;

    protected function setUp()
    {
        $this->service = new CountryMock();
        $this->service->setClient($this->guzzle());
    }

    public function testInvoke()
    {
        $this->addJsonResponse($this->validResponse());
        $this->service->invoke('US');
        $this->assertSame([
            'country' => 'US',
        ], $this->service->executedParams);
    }

    public function testMissingCountryParameter()
    {
        $this->setExpectedException('\Nexmo\Exception', '$country parameter cannot be blank');
        $this->service->invoke();
    }

    public function testResponse()
    {
        $this->addJsonResponse($this->validResponse());
        $pricing = $this->service->invoke('US');
        $this->assertInstanceOf('\Nexmo\Entity\Pricing', $pricing);
    }

    public function testGetEndpoint()
    {
        $this->assertSame('account/get-pricing/outbound', $this->service->getEndpoint());
    }

    public function testValidateResponseCountryProperty()
    {
        $response = $this->validResponse();
        unset($response['country']);
        $this->assertInvalidResponseException($response, 'country');
    }

    public function testValidateResponseNameProperty()
    {
        $response = $this->validResponse();
        unset($response['name']);
        $this->assertInvalidResponseException($response, 'name');
    }

    public function testValidateResponsePrefixProperty()
    {
        $response = $this->validResponse();
        unset($response['prefix']);
        $this->assertInvalidResponseException($response, 'prefix');
    }

    public function testValidateResponseNoNetworksProperty()
    {
        $response = $this->validResponse();
        unset($response['networks']);
        $this->addJsonResponse($response);
        $this->service->invoke('US');
    }

    public function testValidateResponseNetworkCodeProperty()
    {
        $response = $this->validResponse();
        unset($response['networks'][0]['code']);
        $this->assertInvalidResponseException($response, 'network.code');
    }

    public function testValidateResponseNetworkNetworkProperty()
    {
        $response = $this->validResponse();
        unset($response['networks'][0]['network']);
        $this->assertInvalidResponseException($response, 'network.network');
    }

    public function testValidateResponseNetworkPriceProperty()
    {
        $response = $this->validResponse();
        unset($response['networks'][0]['mtPrice']);
        $this->assertInvalidResponseException($response, 'network.mtPrice');
    }

    protected function assertInvalidResponseException($response, $field)
    {
        $this->addJsonResponse($response);
        $this->setExpectedException('\Nexmo\Exception', $field . ' property expected');
        $this->service->invoke('US');
    }

    protected function validResponse()
    {
        return [
            'country' => 'US',
            'name' => '',
            'prefix' => '1',
            'networks' => [
                [
                    'code' => '',
                    'network' => '',
                    'mtPrice' => '',
                ],
            ],
        ];
    }
}

class CountryMock extends Country
{
    public $executedParams;

    protected function exec($params, $method = 'GET')
    {
        $this->executedParams = $params;
        return parent::exec($params);
    }
}
