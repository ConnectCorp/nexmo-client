<?php

namespace Nexmo\Service\Account;

use Nexmo\Exception;
use Nexmo\Service\Service;

class Pricing extends Service
{
    public function getEndpoint()
    {
        return 'account/get-pricing/outbound';
    }

    public function invoke($country = null)
    {
        if (!$country) {
            throw new Exception('$country parameter cannot be blank');
        }
        return $this->exec([
            'country' => $country,
        ]);
    }

    protected function validateResponse(array $json)
    {
        if (!isset($json['country'])) {
            throw new Exception('country property expected');
        }
        if (!isset($json['name'])) {
            throw new Exception('name property expected');
        }
        if (!isset($json['prefix'])) {
            throw new Exception('prefix property expected');
        }
        if (!isset($json['mt'])) {
            throw new Exception('mt property expected');
        }
        if (!isset($json['networks']) || !is_array($json['networks'])) {
            throw new Exception('networks array property expected');
        }
        foreach ($json['networks'] as $network) {
            if (!isset($network['code'])) {
                throw new Exception('network.code property expected');
            }
            if (!isset($network['network'])) {
                throw new Exception('network.network property expected');
            }
            if (!isset($network['mtPrice'])) {
                throw new Exception('network.mtPrice property expected');
            }
            if (!isset($network['ranges']) || !is_array($network['ranges'])) {
                throw new Exception('network.ranges array property expected');
            }
        }
        return true;
    }
}
