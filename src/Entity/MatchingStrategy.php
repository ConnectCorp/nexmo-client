<?php

namespace Nexmo\Entity;

/**
 * Strategies for matching numbers
 *
 * @see \Nexmo\Service\Account\Numbers
 *
 * @author Carson Full <carsonfull@gmail.com>
 */
final class MatchingStrategy
{
    const STARTS_WITH = 0;
    const ANYWHERE = 1;
    const ENDS_WITH = 2;

    private function __construct()
    {
    }
}
