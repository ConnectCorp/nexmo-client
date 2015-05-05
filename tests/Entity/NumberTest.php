<?php
namespace Nexmo\Tests\Entity;

use Nexmo\Entity\Number;
use Nexmo\Tests\TestCase;

class NumberTest extends TestCase
{
    public function testProperties()
    {
        $number = new Number([
            'type'                   => 'mobile-lvn',
            'country'                => 'US',
            'features'               => ['SMS'],
            'msisdn'                 => '1234567890',
            'moHttpUrl'              => 'http://www.nexmo.com/foo',
            'voiceCallbackType'      => 'sip',
            'voiceCallbackValue'     => 'foo',
            'voiceStatusCallbackUrl' => 'http://www.nexmo.com/status',
        ]);

        $this->assertSame('mobile-lvn', $number->type());
        $this->assertSame('US', $number->countryCode());
        $this->assertSame(['SMS'], $number->features());
        $this->assertSame('1234567890', $number->number());
        $this->assertSame('http://www.nexmo.com/foo', $number->callbackUrl());
        $this->assertSame('sip', $number->voiceCallbackType());
        $this->assertSame('foo', $number->voiceCallbackValue());
        $this->assertSame('http://www.nexmo.com/status', $number->voiceStatusCallbackUrl());
    }

    public function testShortcutsMobile()
    {
        $number = new Number([
            'type'     => 'mobile-lvn',
            'features' => ['SMS'],
        ]);

        $this->assertTrue($number->isMobile());
        $this->assertFalse($number->isLandline());
        $this->assertFalse($number->isShortCode());
        $this->assertTrue($number->isSms());
        $this->assertFalse($number->isVoice());
    }

    public function testShortcutsMobileShortCode()
    {
        $number = new Number([
            'type'     => 'mobile-shortcode',
            'features' => ['SMS'],
        ]);

        $this->assertFalse($number->isMobile());
        $this->assertFalse($number->isLandline());
        $this->assertTrue($number->isShortCode());
        $this->assertTrue($number->isSms());
        $this->assertFalse($number->isVoice());
    }

    public function testShortcutsLandline()
    {
        $number = new Number([
            'type'     => 'landline',
            'features' => ['VOICE'],
        ]);

        $this->assertFalse($number->isMobile());
        $this->assertTrue($number->isLandline());
        $this->assertFalse($number->isShortCode());
        $this->assertFalse($number->isSms());
        $this->assertTrue($number->isVoice());
    }
}
