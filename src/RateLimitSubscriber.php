<?php
namespace Nexmo;
use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Event\CompleteEvent;
use GuzzleHttp\Event\SubscriberInterface;

class RateLimitSubscriber implements SubscriberInterface
{
    /**
     * @param array $time
     * Rate limit for the SMS and Voice API is on a per-LVN/shortcode basis, so we record durations in an array with the LVN as the key.
     * For maximum throughput messages should be sent from different LVNs in an interleaved patter, e.g., 1, 2, 3, 1, 2, 3 instead of 1, 1, 2, 2, 3, 3
     * (or better, send from each LVN in parallel, concurrent threads).
     */
    private static $time = [];
    private static $counter = [];

    /**
     * @param float $max_requests_per_sec
     * Max number of requests per second. Nexmo's most restrictive API is the SMS API for US/Canada -> US/Canada routing at 1/sec, let's be safe and use that as default.
     */
    private $maxRequestsPerSec = 1;

    /**
     * @param string $timeKey
     * LVN/shortcode when using the SMS or Voice API. Left as a blank string for the Developer API.
     */
    private $timeKey = '';

    /**
     * @param int $rate
     */
    public function setRate($rate)
    {
        $this->maxRequestsPerSec = $rate;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->timeKey = $key;
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return [
            'before'   => ['onBefore'],
            'complete' => ['onComplete'],
        ];
    }

    /**
     * @param BeforeEvent $event
     */
    public function onBefore(BeforeEvent $event)
    {
        self::$time[$this->timeKey] = microtime(true);
        self::$counter[$this->timeKey] = isset(self::$counter[$this->timeKey]) ? self::$counter[$this->timeKey] + 1 : 1;
    }

    /**
     * @param CompleteEvent $event
     */
    public function onComplete(CompleteEvent $event)
    {
        // Convert requests-per-second to a minimum duration in seconds.
        $min_request_duration_sec = 1 / $this->maxRequestsPerSec;

        // Calculate the duration of the previous request in seconds.
        $elapsed_sec = microtime(true) - self::$time[$this->timeKey];

        // If the duration is greater than the minimum duration, for this LVN, we must delay.
        if ($elapsed_sec < $min_request_duration_sec) {
            $min_request_duration_microsec = ($min_request_duration_sec - $elapsed_sec) * 1000000;
            usleep($min_request_duration_microsec);
        }
    }
}