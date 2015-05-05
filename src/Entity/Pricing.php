<?php

namespace Nexmo\Entity;

/**
 * An object representation of Nexmo's pricing
 *
 * @see    \Nexmo\Service\Account\Pricing::country
 * @see    \Nexmo\Service\Account\Pricing::international
 *
 * @author Carson Full <carsonfull@gmail.com>
 */
class Pricing extends Collection
{
    /**
     * Country code
     *
     * @return string
     */
    public function countryCode()
    {
        return $this->get('country');
    }

    /**
     * Country name
     *
     * @return string
     */
    public function countryName()
    {
        return $this->get('name');
    }

    /**
     * International calling prefix
     *
     * @return int
     */
    public function countryPrefix()
    {
        return (int)$this->get('prefix');
    }

    /**
     * Default price for outbound message in Euro
     *
     * @return float
     */
    public function price()
    {
        return (float)$this->get('mt');
    }

    /**
     * Supported networks
     *
     * @return Network[]
     */
    public function networks()
    {
        return $this->getArray('networks', function ($network) {
            return new Network($network);
        });
    }
}
