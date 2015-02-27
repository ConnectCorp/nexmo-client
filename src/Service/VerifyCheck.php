<?php

namespace Nexmo\Service;

use Nexmo\Exception;

/**
 * Class VerifyCheck
 * @package Nexmo\Service
 */
class VerifyCheck extends Service
{

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return 'https://api.nexmo.com/verify/check/json';
    }

    /**
     * @param $requestId
     * @param $code
     * @param null $ipAddress
     * @return mixed
     */
    public function invoke($requestId = null, $code = null, $ipAddress = null)
    {
        return $this->exec([
            'request_id' => $requestId,
            'code' => $code,
            'ip_address' => $ipAddress
        ]);
    }

    /**
     * @param array $response
     * @return bool
     * @throws Exception
     */
    protected function validateResponse(array $response)
    {
        if (!isset($response['status'])) {
            throw new Exception('status property expected');
        }

        if (!empty($response['error_text'])) {
            throw new Exception('Unable to verify number: ' . $response['error_text'] . ' - status ' . $response['status']);
        }

        if ($response['status'] > 0) {
            throw new Exception('Unable to verify number: status ' . $response['status']);
        }

        return true;
    }
}