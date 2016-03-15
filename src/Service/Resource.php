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
     * @var array
     */
    protected $defaultQuery = [];

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function getDefaultQuery()
    {
        return $this->defaultQuery;
    }

    /**
     * @param array $defaultQuery
     */
    public function setDefaultQuery(array $defaultQuery)
    {
        $this->defaultQuery = $defaultQuery;
    }
}
