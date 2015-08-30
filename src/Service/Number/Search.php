<?php
namespace Nexmo\Service\Number;

use Nexmo\Entity\MatchingStrategy;
use Nexmo\Entity\NumberCollection;
use Nexmo\Exception;
use Nexmo\Service\Service;

class Search extends Service
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
        return 'number/search';
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
    public function invoke($country = null, $index = 1, $size = 10, $pattern = null, $searchPattern = MatchingStrategy::STARTS_WITH, $features = 'SMS')
    {
        if (!$country) {
            throw new Exception("\$country parameter cannot be blank");
        }

        $size = min($size, 100);

        return new NumberCollection($this->exec([
            // Nexmo API requires $country value to be uppercase.
            'country' => strtoupper($country),
            'index' => $index,
            'size' => $size,
            'pattern' => $pattern,
            'search_pattern' => $searchPattern,
            'features' => $features,
        ]));
    }

    /**
     * @inheritdoc
     */
    protected function validateResponse(array $json)
    {
        // If the 'numbers' element exists (which it won't if no numbers are available for a search), validate it is an array.
        if (isset($json['numbers']) && !is_array($json['numbers'])) {
            throw new Exception('numbers property not an array');
        }
    }
}
