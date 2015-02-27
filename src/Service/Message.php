<?php

namespace Nexmo\Service;

use Nexmo\Exception as NexmoException;

/**
 * Class Message
 * @package Nexmo\Service
 */
class Message extends Service
{
    /**
     * @return string
     */
    public function getEndpoint()
    {
        return 'https://rest.nexmo.com/sms/json';
    }

    /**
     * @param $from
     * @param $to
     * @param string $type
     * @param string $text
     * @param string $statusReportReq
     * @param string $clientRef
     * @param string $networkCode
     * @param string $vcard
     * @param string $vcal
     * @param integer $ttl
     * @param string $messageClass
     * @param string $body
     * @param string $udh
     * @return array
     */
    public function invoke(
        $from = null,
        $to = null,
        $type = 'text',
        $text = '',
        $statusReportReq = null,
        $clientRef = null,
        $networkCode = null,
        $vcard = null,
        $vcal = null,
        $ttl = null,
        $messageClass = null,
        $body = null,
        $udh = null
    )
    {
        return $this->exec([
            'from' => $from,
            'to' => $to,
            'type' => $type,
            'text' => $text,
            'status_report_req' => $statusReportReq,
            'client_ref' => $clientRef,
            'network_code' => $networkCode,
            'vcard' => $vcard,
            'vcal' => $vcal,
            'ttl' => $ttl,
            'message_class' => $messageClass,
            'body' => $body,
            'udh' => $udh
        ]);
    }

    /**
     * @param $json
     * @return bool
     * @throws NexmoException
     */
    protected function validateResponse(array $json)
    {
        if (!isset($json['message-count'])) {
            throw new NexmoException('message-count property expected');
        }

        if (!isset($json['messages'])) {
            throw new NexmoException('messages property expected');
        }

        foreach ($json['messages'] as $message) {
            if (!isset($message['status'])) {
                throw new NexmoException('status property expected');
            }

            if (!empty($message["error-text"])) {
                throw new NexmoException("Unable to send sms message: " . $message["error-text"] . ' - status ' . $message['status']);
            }

            if ($message['status'] > 0) {
                throw new NexmoException("Unable to send sms message: status " . $message['status']);
            }
        }

        return true;
    }
}