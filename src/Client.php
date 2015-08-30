<?php

namespace Nexmo;

use GuzzleHttp\Client as HttpClient;
use Nexmo\Service;
use Nexmo\Service\ResourceCollection;

/**
 * Class Client
 *
 * @property-read Service\Account $account Account management APIs
 * @property-read Service\Message $message
 * @property-read Service\Voice   $voice
 * @property-read Service\Verify  $verify
 *
 * @package Nexmo\Client
 */
class Client extends ResourceCollection
{
    /**
     * @var array
     */
    private $options = array(
        'apiKey' => null,
        'apiSecret' => null,
        'baseURL' => 'https://rest.nexmo.com/',
        'debug' => false,
        'timeout' => 5.0,
    );

    /**
     * @param array $options
     */
    public function __construct(Array $options = [])
    {
        // Override default options with options provided during instantiation.
        $this->options = array_merge($this->options, $options);
    }

    protected function getNamespace()
    {
        return 'Nexmo\Service';
    }

    public function __get($name)
    {
        $this->loadClient();
        return parent::__get($name);
    }

    protected function loadClient()
    {
        if ($this->client) {
            return;
        }
        $this->client = new HttpClient([
            'base_url' => $this->options['baseURL'],
            'defaults' => [
                'timeout' => $this->options['timeout'],
                'debug' => $this->options['debug'],
                'query' => [
                    'api_key' => $this->options['apiKey'],
                    'api_secret' => $this->options['apiSecret']
                ]
            ]
        ]);
    }
}
