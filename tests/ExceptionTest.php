<?php

namespace Nexmo\Tests;

class ExceptionTest extends TestCase
{
    public function testInstanceOf()
    {
        $this->assertInstanceOf('\Exception', new \Nexmo\Exception());
    }
}
