<?php

namespace Nexmo\Service\Account;

use Nexmo\Exception;

class InternationalPricing extends Pricing
{
    public function getEndpoint()
    {
        return 'https://rest.nexmo.com/account/get-prefix-pricing/outbound';
    }

    public function invoke($prefix = null)
    {
        if (!$prefix) {
            throw new Exception('$prefix parameter cannot be blank');
        }
        return $this->exec([
            'prefix' => $prefix,
        ]);
    }
}
