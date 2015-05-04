<?php
namespace Nexmo\Entity;

class PricingPhone extends Collection
{
    /**
     * Country code
     * @return string
     */
    public function countryCode()
    {
        return $this->get('country-code');
    }

    /**
     * Network operator MCCMNC
     *
     * @see http://en.wikipedia.org/wiki/Mobile_country_code
     *
     * @return string|null
     */
    public function networkCode()
    {
        return $this->get('network');
    }

    /**
     * Phone number
     * @return string
     */
    public function number()
    {
        return $this->get('phone');
    }

    /**
     * Price for outbound SMS message/Voice call in Euro
     * @return float
     */
    public function price()
    {
        return (float)$this->get('price');
    }
}
