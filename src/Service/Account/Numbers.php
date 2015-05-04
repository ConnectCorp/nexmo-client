<?php

namespace Nexmo\Service\Account;

use Nexmo\Entity\NumberCollection;
use Nexmo\Exception;
use Nexmo\Service\Service;

class Numbers extends Service
{
    public function getEndpoint()
    {
        return 'account/numbers';
    }

    public function invoke($index = 1, $size = 10, $pattern = null, $searchPattern = 0)
    {
        $size = min($size, 100);
        return new NumberCollection($this->exec([
            'index' => $index,
            'size' => $size,
            'pattern' => $pattern,
            'search_pattern' => $searchPattern,
        ]));
    }

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
