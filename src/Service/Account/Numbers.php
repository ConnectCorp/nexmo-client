<?php

namespace Nexmo\Service\Account;

use Nexmo\Entity\MatchingStrategy;
use Nexmo\Entity\NumberCollection;
use Nexmo\Exception;
use Nexmo\Service\Service;

/**
 * Get all inbound numbers associated with your account.
 *
 * @author Carson Full <carsonfull@gmail.com>
 */
class Numbers extends Service
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
     * @inheritdoc
     */
    public function getEndpoint()
    {
        return 'account/numbers';
    }

    /**
     * @param int        $index
     * @param int        $size
     * @param string|int $pattern
     * @param int        $searchPattern
     *
     * @return NumberCollection
     * @throws Exception
     */
    public function invoke($index = 1, $size = 10, $pattern = null, $searchPattern = MatchingStrategy::STARTS_WITH)
    {
        $size = min($size, 100);

        return new NumberCollection($this->exec([
            'index'          => $index,
            'size'           => $size,
            'pattern'        => $pattern,
            'search_pattern' => $searchPattern,
        ]));
    }

    /**
     * @inheritdoc
     */
    protected function validateResponse(array $json)
    {
        if (!isset($json['count'])) {
            throw new Exception('count property expected');
        }
        if (!isset($json['numbers']) || !is_array($json['numbers'])) {
            throw new Exception('numbers array property expected');
        }
        foreach ($json['numbers'] as $number) {
            if (!isset($number['country'])) {
                throw new Exception('number.country property expected');
            }
            if (!isset($number['msisdn'])) {
                throw new Exception('number.msisdn property expected');
            }
            if (!isset($number['type'])) {
                throw new Exception('number.type property expected');
            }
            if (!isset($number['features']) || !is_array($number['features'])) {
                throw new Exception('number.features array property expected');
            }
            if (!isset($number['moHttpUrl'])) {
                throw new Exception('number.moHttpUrl property expected');
            }
        }
    }
}
