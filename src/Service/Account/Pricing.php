<?php

namespace Nexmo\Service\Account;

use Nexmo\Entity;
use Nexmo\Exception;
use Nexmo\Service\ResourceCollection;

/**
 * Account Pricing APIs
 *
 * @property-read Pricing\Country       $country
 * @property-read Pricing\International $international
 * @property-read Pricing\Phone         $phone
 *
 * @author Carson Full <carsonfull@gmail.com>
 */
class Pricing extends ResourceCollection
{
    /**
     * Retrieve Nexmo's outbound pricing for a given country.
     *
     * @param string $country A 2 letter country code. Ex: CA
     *
     * @return Entity\Pricing
     * @throws Exception
     */
    public function country($country)
    {
        return $this->country->invoke($country);
    }

    /**
     * Retrieve Nexmo's outbound pricing for a given international prefix.
     *
     * @param int $prefix International dialing code. Ex: 44
     *
     * @return Entity\Pricing[]
     * @throws Exception
     */
    public function international($prefix)
    {
        return $this->international->invoke($prefix);
    }

    /**
     * Retrieve Nexmo's outbound SMS pricing for a given phone number.
     *
     * @param string $number Phone number in international format Ex: 447525856424
     *
     * @return Entity\PricingPhone
     * @throws Exception
     */
    public function sms($number)
    {
        return $this->phone->invoke('sms', $number);
    }

    /**
     * Retrieve Nexmo's outbound voice pricing for a given phone number.
     *
     * @param string $number Phone number in international format Ex: 447525856424
     *
     * @return Entity\PricingPhone
     * @throws Exception
     */
    public function voice($number)
    {
        return $this->phone->invoke('voice', $number);
    }
}
