<?php

namespace Nexmo\Entity;

/**
 * An object representation of a network property under {@see Pricing}
 *
 * @author Carson Full <carsonfull@gmail.com>
 */
class Network extends Collection
{
    /**
     * Network operator MCCMNC
     *
     * @see http://en.wikipedia.org/wiki/Mobile_country_code
     *
     * @return string|int
     */
    public function code()
    {
        return $this->get('code');
    }

    /**
     * Price for outbound message in Euro
     *
     * @return float
     */
    public function defaultPrice()
    {
        return (float)$this->get('mtPrice');
    }

    /**
     * Network operator name
     *
     * @return string
     */
    public function name()
    {
        return $this->get('network');
    }
}
