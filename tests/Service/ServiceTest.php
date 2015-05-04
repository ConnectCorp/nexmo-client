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

    /**
     * @var Guzzle\ClientInterface
     */
    protected $client;
    /**
     * @var Guzzle\Subscriber\Mock
     */
    protected $mock;

    protected function setUp()
    {
        parent::setUp();
        $this->client = new Guzzle\Client();
        $this->mock = new Guzzle\Subscriber\Mock();
        $this->client->getEmitter()->attach($this->mock);
        $this->service = new ServiceMock();
        $this->service->setClient($this->client);
    }

    protected function addResponse($json)
    {
        $response = new Guzzle\Message\Response(200, [], Guzzle\Stream\Stream::factory($json));
        $this->mock->addResponse($response);
    }

    public function testInvoke()
    {
        $expected = [
            'status' => 1,
            'error_text' => 'Error',
        ];
        $this->addResponse(json_encode($expected));

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

        $this->setExpectedException('\Nexmo\Exception', 'Unable to parse JSON data: JSON_ERROR_SYNTAX - Syntax error, malformed JSON');

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
