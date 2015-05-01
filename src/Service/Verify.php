<?php

namespace Nexmo\Service;

use Nexmo\Exception;

/**
 * Class Verify
 * @package Nexmo\Service
 */
class Verify extends Service
{
    /**
     * @var VerifyCheck
     */
    public $check;

    /**
     * @param \GuzzleHttp\Client $client
     */
    public function __construct($client)
    {
        parent::__construct($client);

        $this->check = new VerifyCheck($client);
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return 'verify/json';
    }

    /**
     * @param string $number
     * @param string $brand
     * @param string $senderId
     * @param integer $codeLength
     * @param string $lg
     * @param string $requireType
     * @throws Exception
     * @return array
     */
    public function invoke($number = null, $brand = null, $senderId = null, $codeLength = null, $lg = null, $requireType = null)
    {
        if(!$number) {
            throw new Exception("\$number parameter cannot be blank");
        }

        if(!$brand) {
            throw new Exception("\$brand parameter cannot be blank");
        }

        return $this->exec([
            'number' => $number,
            'brand' => $brand,
            'sender_id' => $senderId,
            'code_length' => $codeLength,
            'lg' => $lg,
            'require_type' => $requireType
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

        if (!isset($response['request_id'])) {
            throw new Exception('request_id property expected');
        }

        return true;
    }
}
