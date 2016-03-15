<?php

namespace Nexmo\Service\Number;

use Nexmo\Entity\MatchingStrategy;
use Nexmo\Entity\NumberCollection;
use Nexmo\Exception;
use Nexmo\Service\Service;

/**
 * Get all inbound numbers associated with your account.
 *
 * @author Carson Full <carsonfull@gmail.com>
 */
class Buy extends Service
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
        return 'number/buy';
    }

    /**
     * @param string     $country
     * @param string     $msisdn
     *
     * @return boolean
     * @throws Exception
     */
    public function invoke($country = null, $msisdn = null)
    {
        if (!$country) {
            throw new Exception("\$country parameter cannot be blank");
        }
        if (!$msisdn) {
            throw new Exception("\$msisdn parameter cannot be blank");
        }

        return $this->exec([
            // Nexmo API requires $country value to be uppercase.
            'country' => strtoupper($country),
            'msisdn' => $msisdn,
        ], 'POST');
    }


    /**
     * @inheritdoc
     */
    protected function validateResponse(array $json)
    {
        if (!isset($json['error-code'])) {
            throw new Exception('no error code');
        }

        switch ($json['error-code']) {
        case '200':
            return true;

        case '401':
            throw new Exception('error 401 wrong credentials');

        case '420':
            throw new Exception('error 420 wrong parameters');

        default:
            throw new Exception('unknown error code');
        }
    }
}
