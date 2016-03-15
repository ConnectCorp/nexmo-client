<?php

namespace Nexmo\Tests\Service;

use GuzzleHttp as Guzzle;
use Nexmo\Service\Service;
use Nexmo\Tests\TestCase;

class ServiceTest extends TestCase
{
    /**
     * @var ServiceMock
     */
    protected $service;

    protected function setUp()
    {
        parent::setUp();
        $this->service = new ServiceMock();
        $this->service->setClient($this->guzzle());
    }

    public function testInvoke()
    {
        $expected = [
            'status' => 1,
            'error_text' => 'Error',
        ];
        $this->addJsonResponse($expected);

        $params = [
            'param1' => 'value1',
            'param2' => 'value2',
            'param3' => 'value3'
        ];

        $this->assertEquals($expected, $this->service->testExec($params));
        $this->assertTrue($this->service->responseValidated);
    }

    public function testInvokeJsonException()
    {
        $this->addResponse('nonjsonstring');

        $this->setExpectedException('\Nexmo\Exception', null, 4);

        $this->service->testExec([]);
    }

    public function testCallable()
    {
        $service = $this->service;
        $service('a');
        $this->assertSame($this->service->invokedParams, ['a']);
    }
}

class ServiceMock extends Service
{
    public $responseValidated = false;
    public $invokedParams;

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return 'path';
    }

    public function testExec(array $params)
    {
        return $this->exec($params);
    }

    /**
     * @return mixed
     */
    public function invoke()
    {
        $this->invokedParams = func_get_args();
    }

    /**
     * @param array $json
     * @return bool
     */
    protected function validateResponse(array $json)
    {
        $this->responseValidated = true;
        return true;
    }
}
