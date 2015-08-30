<?php

namespace Nexmo\Service\Account\Pricing;

use Nexmo\Entity;
use Nexmo\Exception;
use Nexmo\Service\Service;

/**
 * Retrieve Nexmo's outbound SMS/Voice pricing for a given phone number.
 *
 * @author Carson Full <carsonfull@gmail.com>
 */
class Phone extends Service
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
     * @var string
     */
    protected $product;

    /**
     * @inheritdoc
     */
    public function getEndpoint()
    {
        return 'account/get-phone-pricing/outbound/' . $this->product;
    }

    /**
     * @param string $product
     * @param string $phone
     *
     * @return Entity\PricingPhone
     * @throws Exception
     */
    public function invoke($product = null, $phone = null)
    {
        if (!$product) {
            throw new Exception('$product parameter cannot be blank');
        }
        if (!in_array($product, ['sms', 'voice'], true)) {
            throw new Exception('$product parameter must be "sms" or "voice"');
        }
        if (!$phone) {
            throw new Exception('$phone parameter cannot be blank');
        }
        $this->product = $product;
        return new Entity\PricingPhone($this->exec([
            'phone' => $phone,
        ]));
    }

    /**
     * @inheritdoc
     */
    protected function validateResponse(array $json)
    {
        if (!isset($json['country-code'])) {
            throw new Exception('country-code property expected');
        }
        if (!isset($json['phone'])) {
            throw new Exception('phone property expected');
        }
        if (!isset($json['price'])) {
            throw new Exception('price property expected');
        }
    }
}
