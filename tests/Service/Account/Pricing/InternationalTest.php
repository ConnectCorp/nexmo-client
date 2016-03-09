<?php

namespace Nexmo\Tests\Service\Account\Pricing;

use Nexmo\Service\Account\Pricing\International;
use Nexmo\Tests\Service\Account\AccountTestCase;

class InternationalTest extends AccountTestCase
{
    /**
     * @var InternationalMock
     */
    private $service;

    protected function setUp()
    {
        $this->service = new InternationalMock();
        $this->service->setClient($this->guzzle());
    }

    public function testInvoke()
    {
        $this->addJsonResponse($this->validResponse());
        $this->service->invoke(1);
        $this->assertSame([
            'prefix' => 1,
        ], $this->service->executedParams);
    }

    public function testNoPrefix()
    {
        $this->setExpectedException('\Nexmo\Exception', '$prefix parameter cannot be blank');
        $this->service->invoke();
    }

    public function testResponse()
    {
        $this->addJsonResponse($this->validResponse());
        $prices = $this->service->invoke(1);
        $this->assertCount(2, $prices);
        foreach ($prices as $price) {
            $this->assertInstanceOf('\Nexmo\Entity\Pricing', $price);
        }
    }

    public function testGetEndpoint()
    {
        $this->assertSame('account/get-prefix-pricing/outbound', $this->service->getEndpoint());
    }

    public function testValidateResponsePricesProperty()
    {
        $response = $this->validResponse();
        unset($response['prices']);
        $this->assertInvalidResponseException($response, 'prices array');
    }

    public function testValidateResponsePricesPropertyIsArray()
    {
        $response = $this->validResponse();
        $response['prices'] = null;
        $this->assertInvalidResponseException($response, 'prices array');
    }

    protected function assertInvalidResponseException($response, $field)
    {
        $this->addJsonResponse($response);
        $this->setExpectedException('\Nexmo\Exception', $field . ' property expected');
        $this->service->invoke(1);
    }

    protected function validResponse()
    {
        $price = [
            'country' => 1,
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
        return [
            'prices' => [
                $price,
                $price
            ],
        ];
    }
}

class InternationalMock extends International
{
    public $executedParams;

    protected function exec($params, $method = 'GET')
    {
        $this->executedParams = $params;
        return parent::exec($params);
    }
}
