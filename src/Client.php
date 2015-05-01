<?php

namespace Nexmo;

use GuzzleHttp\Client as HttpClient;
use Nexmo\Service;

/**
 * Class Client
 *
 * @property Service\Account $account Account management APIs
 * @property Service\Message $message
 * @property Service\Voice   $voice
 * @property Service\Verify  $verify
 *
 * @package Nexmo\Client
 */
class Client
{
    const BASE_URL = 'https://rest.nexmo.com/';

    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var Service\Service[]
     */
    protected $services = [];

    /**
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct($apiKey, $apiSecret)
    {
        $this->client = new HttpClient([
            'base_url' => static::BASE_URL,
            'defaults' => [
                'query' => [
                    'api_key' => $apiKey,
                    'api_secret' => $apiSecret
                ]
            ]
        ]);
    }

    public function __get($name)
    {
        if (!isset($this->services[$name])) {
            $cls = '\\Nexmo\\Service\\' . ucfirst($name);
            $this->services[$name] = new $cls($this->client);
        }
        return $this->services[$name];
    }
}
