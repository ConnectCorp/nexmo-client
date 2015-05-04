<?php

namespace Nexmo\Service\Account;

use Nexmo\Entity;
use Nexmo\Exception;
use Nexmo\Service\Service;

class PricingPhone extends Service
{
    protected $product;

    public function getEndpoint()
    {
        return 'account/get-phone-pricing/outbound/' . $this->product;
    }

    public function invoke($product = null, $phone = null)
    {
        if (!$product) {
            throw new Exception('$product parameter cannot be blank');
        }
        if (!in_array($product, ['sms', 'voice'], true)) {
            throw new Exception('$product parameter must be "sms" or "voice"');
        }
        $this->product = $product;
        return new Entity\PricingPhone($this->exec([
            'phone' => $phone,
        ]));
    }

    protected function validateResponse(array $json)
    {
        if (!isset($json['country-code'])) {
            throw new Exception('country-code property expected');
        }
        if (!isset($json['network-code'])) {
            throw new Exception('network-code property expected');
        }
        if (!isset($json['phone'])) {
            throw new Exception('phone property expected');
        }
        if (!isset($json['price'])) {
            throw new Exception('price property expected');
        }
    }
}
