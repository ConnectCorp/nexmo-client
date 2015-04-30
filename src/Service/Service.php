<?php

namespace Nexmo\Service;

use GuzzleHttp\Client;
use Nexmo\Exception;

/**
 * Class Service
 * @package Nexmo\Service
 */
abstract class Service
{
    /**
     * @var Client
     */
    protected $client;

    protected $baseUrl;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    abstract public function getEndpoint();

    /**
     * @return mixed
     */
    abstract public function invoke();

    /**
     * @param array $json
     * @return bool
     */
    abstract protected function validateResponse(array $json);

    /**
     * @param $params
     * @throws Exception
     * @return array
     */
    protected function exec($params)
    {
        $params = array_filter($params);

        $response = $this->client->get($this->getEndpoint(), [
            'query' => $params
        ]);

        $body = $response->getBody();

        $json = json_decode($body, true);
        if (json_last_error()) {
            throw new Exception('Unable to parse JSON');
        }

        $this->validateResponse($json);

        return $json;
    }

    /**
     * @return array
     */
    public function __invoke()
    {
        return call_user_func_array(array($this, 'invoke'), func_get_args());
    }
}
