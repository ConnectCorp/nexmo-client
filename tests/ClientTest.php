<?php

namespace Nexmo\Tests;

class ClientTest extends TestCase
{

    private $client;

    protected function setUp()
    {
        $this->client = new \Nexmo\Client('key', 'secret');
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('\Nexmo\Service\Message', $this->client->message);
        $this->assertInstanceOf('\Nexmo\Service\Verify', $this->client->verify);
        $this->assertInstanceOf('\Nexmo\Service\voice', $this->client->voice);
    }

}
