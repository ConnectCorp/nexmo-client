<?php

namespace Nexmo\Tests\Service;

use Nexmo\Service\Voice;
use Nexmo\Tests\TestCase;

class VoiceTest extends TestCase
{
    /**
     * @var VoiceMock
     */
    protected $service;

    protected function setUp()
    {
        parent::setUp();
        $this->service = new VoiceMock();
        $this->service->setClient($this->guzzle());
    }

    public function testExec()
    {
        $this->setExpectedException('Nexmo\Exception');
        $this->service->invoke();
    }

    public function testGetEndpoint()
    {
        $this->assertEquals($this->service->getEndpoint(), 'call/json');
    }

    public function testValidateResponse()
    {
        $this->assertTrue($this->service->testValidateResponse([]));
    }
}

class VoiceMock extends Voice
{
    use TestServiceTrait;
}
