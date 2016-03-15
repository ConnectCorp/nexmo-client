<?php

namespace Nexmo\Tests;

use GuzzleHttp as Guzzle;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MockHandler
     */
    private $mockHandler;

    /**
     * @return Guzzle\Client|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function guzzle()
    {
        $mockHandler = $this->guzzleMockHandler();
        $handler = Guzzle\HandlerStack::create($mockHandler);

        return new Guzzle\Client(['handler' => $handler]);
    }

    /**
     * @return MockHandler
     */
    protected function guzzleMockHandler()
    {
        if (!$this->mockHandler) {
            $this->mockHandler = new MockHandler();
        }

        return $this->mockHandler;
    }

    /**
     * @param $string
     */
    protected function addResponse($string)
    {
        $response = new Response(200, [], $string);
        $this->guzzleMockHandler()->append($response);
    }

    /**
     * @param $json
     */
    protected function addJsonResponse($json)
    {
        $this->addResponse(json_encode($json));
    }
}
