<?php

namespace Nexmo\Service;

use GuzzleHttp\Client;

/**
 * A Resource has a Guzzle client
 */
abstract class Resource
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }
}
