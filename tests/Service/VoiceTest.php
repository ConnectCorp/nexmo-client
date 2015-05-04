<?php

namespace Nexmo\Tests\Service;

use Nexmo\Service\Voice;
use Nexmo\Tests\TestCase;

class VoiceTest extends TestCase
{
    public function testExec()
    {
        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $this->setExpectedException('Nexmo\Exception');
        $service = new Voice($client);
        $service->invoke();
    }

    public function testGetEndpoint()
    {
        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $service = new Voice($client);
        $this->assertEquals($service->getEndpoint(), 'https://rest.nexmo.com/call/json');
    }

    public function testValidateResponse()
    {
        $client = $this->getMockBuilder('\GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $service = new VoiceMock($client);
        $this->assertTrue($service->testValidateResponse([]));
    }
}

class VoiceMock extends Voice
{
    public function testValidateResponse($params)
    {
        return $this->validateResponse($params);
    }
}
