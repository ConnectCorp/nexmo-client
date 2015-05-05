<?php

namespace Nexmo\Service\Account\Pricing;

use Nexmo\Entity;
use Nexmo\Exception;

/**
 * Retrieve Nexmo's outbound pricing for a given international prefix.
 *
 * @author Carson Full <carsonfull@gmail.com>
 */
class International extends Country
{
    /**
     * @inheritdoc
     */
    public function getEndpoint()
    {
        return 'account/get-prefix-pricing/outbound';
    }

    /**
     * @param int $prefix
     * @return Entity\Pricing[]
     * @throws Exception
     */
    public function invoke($prefix = null)
    {
        if (!$prefix) {
            throw new Exception('$prefix parameter cannot be blank');
        }
        $data = $this->exec([
            'prefix' => $prefix,
        ]);
        return array_map(function ($price) {
            return new Entity\Pricing($price);
        }, $data['prices']);
    }

    /**
     * @inheritdoc
     */
    protected function validateResponse(array $json)
    {
        if (!isset($json['prices']) || !is_array($json['prices'])) {
            throw new Exception('prices array property expected');
        }
        foreach ($json['prices'] as $price) {
            parent::validateResponse($price);
        }
    }
}
