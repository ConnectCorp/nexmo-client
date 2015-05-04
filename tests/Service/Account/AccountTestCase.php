<?php
namespace Nexmo\Tests\Service\Account;

use Nexmo\Tests\TestCase;
use GuzzleHttp as Guzzle;

class AccountTestCase extends TestCase
{
    /**
     * @var Guzzle\Client
     */
    private $guzzle;

    /**
     * @var Guzzle\Subscriber\Mock
     */
    private $mock;

    protected function guzzle()
    {
        if (!$this->guzzle) {
            $this->guzzle = new Guzzle\Client();
        }
        return $this->guzzle;
    }

    protected function guzzleMock()
    {
        $this->guzzle();
        if (!$this->mock) {
            $this->mock = new Guzzle\Subscriber\Mock();
            $this->guzzle->getEmitter()->attach($this->mock);
        }
        return $this->mock;
    }

    protected function addResponse($json)
    {
        $response = new Guzzle\Message\Response(200, [], Guzzle\Stream\Stream::factory(json_encode($json)));
        $this->guzzleMock()->addResponse($response);
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->guzzle = null;
        $this->mock = null;
    }
}
