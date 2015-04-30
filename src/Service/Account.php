<?php

namespace Nexmo\Service;

use GuzzleHttp\Client;
use Nexmo\Exception;

class Account
{
    /**
     * @var Account\Balance
     */
    protected $balance;

    /**
     * @var Account\Numbers
     */
    protected $numbers;

    /**
     * @var Account\Pricing
     */
    protected $pricing;

    /**
     * @var Account\InternationalPricing
     */
    protected $internationalPricing;

    /**
     * @var Account\PhonePricing
     */
    protected $phonePricing;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns the balance in euros
     *
     * @return float
     * @throws Exception
     */
    public function balance()
    {
        if (!$this->balance) {
            $this->balance = new Account\Balance($this->client);
        }
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
     * @return array
     * @throws Exception
     */
    public function numbers($index = 1, $size = 10, $pattern = null, $searchPattern = 0)
    {
        if (!$this->numbers) {
            $this->numbers = new Account\Numbers($this->client);
        }
        return $this->numbers->invoke($index, $size, $pattern, $searchPattern);
    }

    /**
     * Retrieve Nexmo's outbound pricing for a given country.
     *
     * @param string $country A 2 letter country code. Ex: CA
     * @return array
     * @throws Exception
     */
    public function pricing($country)
    {
        if (!$this->pricing) {
            $this->pricing = new Account\Pricing($this->client);
        }
        return $this->pricing->invoke($country);
    }

    /**
     * Retrieve Nexmo's outbound pricing for a given international prefix.
     *
     * @param int $prefix International dialing code. Ex: 44
     * @return array
     * @throws Exception
     */
    public function internationalPricing($prefix)
    {
        if (!$this->internationalPricing) {
            $this->internationalPricing = new Account\InternationalPricing($this->client);
        }
        return $this->internationalPricing->invoke($prefix);
    }

    /**
     * Retrieve Nexmo's outbound pricing for a given phone number.
     *
     * @param string $product "sms" or "voice"
     * @param string $phone Phone number in international format Ex: 447525856424
     * @return array
     * @throws Exception
     */
    public function phonePricing($product, $phone)
    {
        if (!$this->phonePricing) {
            $this->phonePricing = new Account\PhonePricing($this->client);
        }
        return $this->phonePricing->invoke($product, $phone);
    }
}
