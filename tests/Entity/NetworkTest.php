<?php

namespace Nexmo\Tests\Entity;

use Nexmo\Entity\Network;
use Nexmo\Tests\TestCase;

class NetworkTest extends TestCase
{
    public function testProperties()
    {
        $network = new Network([
            'code'    => '123456',
            'mtPrice' => '0.05',
            'network' => 'Network name',
        ]);

        $this->assertSame('123456', $network->code());
        $this->assertSame(0.05, $network->defaultPrice());
        $this->assertSame('Network name', $network->name());
    }
}
