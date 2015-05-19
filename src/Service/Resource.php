<?php

namespace Nexmo\Service;

use GuzzleHttp\ClientInterface;

/**
 * A Resource has a Guzzle client
 */
abstract class Resource
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }
}
