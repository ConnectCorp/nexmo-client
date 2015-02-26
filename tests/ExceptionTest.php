<?php

class ExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testInstanceOf()
    {
        $this->assertInstanceOf('\Exception', new \Nexmo\Exception());
    }
}