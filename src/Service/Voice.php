<?php

namespace Nexmo\Service;

use Nexmo\Exception;

/**
 * Class Voice
 * @package Nexmo\Service
 */
class Voice extends Service
{
    /**
     * @inheritdoc
     */
    public function getRateLimit()
    {
        // Max number of requests per second. Nexmo Voice API has a 30/sec rate limit.
        return 30;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return 'call/json';
    }

    /**
     * @return array
     * @throws Exception
     */
    public function invoke()
    {
        throw new Exception("Not Implemented");
    }

    /**
     * @param array $json
     * @return bool
     */
    protected function validateResponse(array $json)
    {
        return true;
    }
}
