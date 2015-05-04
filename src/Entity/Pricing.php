<?php
namespace Nexmo\Entity;

class Pricing extends Collection
{
    /**
     * Country code
     * @return string
     */
    public function countryCode()
    {
        return $this->get('country');
    }

    /**
     * Country name
     * @return string
     */
    public function countryName()
    {
        return $this->get('name');
    }

    /**
     * The international calling prefix
     * @return int
     */
    public function prefix()
    {
        return (int)$this->get('prefix');
    }

    /**
     * Default price for outbound message in Euro
     * @return float
     */
    public function price()
    {
        return (float)$this->get('mt');
    }

    /**
     * Supported networks
     * @return Network[]
     */
    public function networks()
    {
        $networks = $this->get('networks');
        if (!is_array($networks)) {
            return [];
        }
        return array_map(function ($network) {
            return new Network($network);
        }, $networks);
    }
}
