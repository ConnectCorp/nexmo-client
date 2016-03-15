<?php

namespace Nexmo\Service;

use Nexmo\Exception;
use GuzzleHttp\Psr7;

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

        //Add default params
        $params += $this->getDefaultQuery();

        $response = $this->client->request($method, $this->getEndpoint(), [
            'query' => $params
        ]);

        $body = $response->getBody()->getContents();

        // Because validateResponse() expects an array, we can only do so if the response body is not empty (which in some cases is a valid response), otherwise $json will be null.
        if (strlen($body) > 0) {
            $json = @json_decode($body, true);

            //Check for json decode errors and throw exception if any
            $jsonErrorCode = json_last_error();
            if ($jsonErrorCode) {
                throw new Exception(
                    json_last_error_msg(),
                    $jsonErrorCode
                );
            }
        } else {
            $json = [];
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
