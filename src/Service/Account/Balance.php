<?php

namespace Nexmo\Service\Account;

use Nexmo\Exception;
use Nexmo\Service\Service;

/**
 * Retrieve current account balance
 *
 * @author Carson Full <carsonfull@gmail.com>
 */
class Balance extends Service
{
    /**
     * @inheritdoc
     */
    public function getRateLimit()
    {
        // Max number of requests per second. Nexmo developer API claims 3/sec max, but actually more than 2/sec causes error 429 Too Many Requests.
        return 2;
    }

    /**
     * @inheritdoc
     */
    public function getEndpoint()
    {
        return 'account/get-balance';
    }

    /**
     * @return float
     * @throws Exception
     */
    public function invoke()
    {
        $json = $this->exec([]);
        return (float)$json['value'];
    }

    /**
     * @inheritdoc
     */
    protected function validateResponse(array $json)
    {
        if (!isset($json['value'])) {
            throw new Exception('value property expected');
        }
    }
}
