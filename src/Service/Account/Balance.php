<?php

namespace Nexmo\Service\Account;

use Nexmo\Exception;
use Nexmo\Service\Service;

class Balance extends Service
{
    public function getEndpoint()
    {
        return 'account/get-balance';
    }

    public function invoke()
    {
        $json = $this->exec([]);
        return (float)$json['value'];
    }

    protected function validateResponse(array $json)
    {
        if (!isset($json['value'])) {
            throw new Exception('value property expected');
        }
    }
}
