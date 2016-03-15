<?php

namespace Nexmo\Service;

use Nexmo\Entity;
use Nexmo\Entity\MatchingStrategy;
use Nexmo\Exception;

/**
 * Class Number
 * @package Nexmo\Service
 */
class Number extends ResourceCollection
{
    /**
     * @return array
     * @throws Exception
     */
    public function search($country = null, $index = 1, $size = 10, $pattern = null, $searchPattern = MatchingStrategy::STARTS_WITH, $features = 'SMS')
    {
        return $this->search->invoke($country, $index, $size, $pattern, $searchPattern, $features);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function buy($country, $msisdn)
    {
        return $this->buy->invoke($country, $msisdn);
    }
    /**
     * @return array
     * @throws Exception
     */
    public function cancel($country, $msisdn)
    {
        return $this->cancel->invoke($country, $msisdn);
    }
}
