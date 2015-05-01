<?php

namespace Nexmo;

use GuzzleHttp\Client as HttpClient;
use Nexmo\Service;
use Nexmo\Service\ServiceCollection;

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
class Client extends ServiceCollection
{
    const BASE_URL = 'https://rest.nexmo.com/';

    /**
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct($apiKey, $apiSecret)
    {
        $client = new HttpClient([
            'base_url' => static::BASE_URL,
            'defaults' => [
                'query' => [
                    'api_key' => $apiKey,
                    'api_secret' => $apiSecret
                ]
            ]
        ]);
        parent::__construct($client);
    }

    protected function getNamespaceSuffix()
    {
        return 'Service';
    }
}
