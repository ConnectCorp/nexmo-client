<?php

namespace Nexmo;

use GuzzleHttp\Client as HttpClient;
use Nexmo\Service;
use Nexmo\Service\ResourceCollection;

/**
 * Class Client
 *
 * @property-read Service\Account           $account                Account management APIs
 * @property-read Service\MarketingMessage  $marketingmessage
 * @property-read Service\Message           $message
 * @property-read Service\Voice             $voice
 * @property-read Service\Verify            $verify
 *
 * @package Nexmo\Client
 */
class Client extends ResourceCollection
{
    const BASE_URL = 'https://rest.nexmo.com/';

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $apiSecret;

    /**
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
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
            'base_url' => static::BASE_URL,
            'defaults' => [
                'query' => [
                    'api_key' => $this->apiKey,
                    'api_secret' => $this->apiSecret
                ]
            ]
        ]);
    }
}
