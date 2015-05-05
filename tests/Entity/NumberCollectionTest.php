<?php

namespace Nexmo\Tests\Entity;

use Nexmo\Entity\NumberCollection;
use Nexmo\Tests\TestCase;

class NumberCollectionTest extends TestCase
{
    /**
     * @var NumberCollection
     */
    protected $numbers;

    protected function setUp()
    {
        parent::setUp();
        $this->numbers = new NumberCollection($this->getNumbers());
    }

    protected function getNumbers()
    {
        return [
            'count' => 10,
            'numbers' => [
                [
                    'type' => 'mobile-lvn',
                    'country' => 'US',
                    'features' => ['SMS'],
                    'msisdn' => '1234567890',
                    'moHttpUrl' => 'http://www.nexmo.com/foo',
                ],
                [
                    'type' => 'landline',
                    'country' => 'CA',
                    'features' => ['VOICE'],
                    'msisdn' => '1234567891',
                    'moHttpUrl' => 'http://www.nexmo.com/bar',
                ]
            ],
        ];
    }

    public function testCollectionCount()
    {
        $this->assertCount(10, $this->numbers);
    }

    public function testNumbersCount()
    {
        $this->assertCount(2, $this->numbers->numbers());
    }

    public function testNumberObjects()
    {
        foreach ($this->numbers as $number) {
            $this->assertInstanceOf('\Nexmo\Entity\Number', $number);
        }
    }
}
