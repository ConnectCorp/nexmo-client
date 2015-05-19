<?php

namespace Nexmo\Service\Account\Pricing;

use Nexmo\Entity;
use Nexmo\Exception;
use Nexmo\Service\Service;

/**
 * Retrieve Nexmo's outbound pricing for a given country.
 *
 * @author Carson Full <carsonfull@gmail.com>
 */
class Country extends Service
{
    /**
     * @inheritdoc
     */
    public function getEndpoint()
    {
        return 'account/get-pricing/outbound';
    }

    /**
     * @param string $country
     *
     * @return Entity\Pricing
     * @throws Exception
     */
    public function invoke($country = null)
    {
        if (!$country) {
            throw new Exception('$country parameter cannot be blank');
        }

        return new Entity\Pricing($this->exec([
            'country' => $country,
        ]));
    }

    /**
     * @inheritdoc
     */
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
        if (!isset($json['networks']) || !is_array($json['networks'])) {
            return;
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
        }
    }
}
