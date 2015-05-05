<?php

namespace Nexmo\Service;

use Nexmo\Entity;
use Nexmo\Entity\MatchingStrategy;
use Nexmo\Exception;

/**
 * Account management APIs
 *
 * @property-read Account\Balance $balance
 * @property-read Account\Numbers $numbers
 * @property-read Account\Pricing $pricing
 */
class Account extends ResourceCollection
{
    /**
     * Returns the balance in euros
     *
     * @return float
     * @throws Exception
     */
    public function balance()
    {
        return $this->balance->invoke();
    }

    /**
     * Get all inbound numbers associated with your Nexmo account
     *
     * @param int $index                Page index
     * @param int $size                 Page size (max 100)
     * @param int $pattern              A matching pattern
     * @param int $searchPattern        Strategy for matching pattern.
     *                                  0 = starts with
     *                                  1 = anywhere
     *                                  2 = ends with
     * @return Entity\NumberCollection|Entity\Number[]
     * @throws Exception
     */
    public function numbers($index = 1, $size = 10, $pattern = null, $searchPattern = MatchingStrategy::STARTS_WITH)
    {
        return $this->numbers->invoke($index, $size, $pattern, $searchPattern);
    }
}
