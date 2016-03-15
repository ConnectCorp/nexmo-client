<?php

namespace Nexmo\Service;

use GuzzleHttp\Exception\ParseException as GuzzleParseException;
use Nexmo\Exception;

/**
 * Class Service
 * @package Nexmo\Service
 */
abstract class Service extends Resource
{
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
    protected function exec($params, $method = 'GET')
    {
        $params = array_filter($params);

        $response = $this->client->send($this->client->createRequest($method, $this->getEndpoint(), [
            'query' => $params
        ]));

        try {
            $json = $response->json();
        } catch (GuzzleParseException $e) {
            throw new Exception($e->getMessage(), 0, $e);
        }

        // Because validateResponse() expects an array, we can only do so if the response body is not empty (which in some cases is a valid response), otherwise $json will be null.
        if (strlen($response->getBody()) > 0) {
            $this->validateResponse($json);
        }

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
