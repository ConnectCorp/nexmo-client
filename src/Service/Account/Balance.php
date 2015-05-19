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
