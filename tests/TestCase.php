<?php

namespace Nexmo\Tests;

use GuzzleHttp as Guzzle;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Guzzle\Client|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function guzzle()
    {
        return $this->getMock('\GuzzleHttp\ClientInterface');
    }
}
