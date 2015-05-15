<?php

namespace Nexmo\Service;

use Nexmo\Exception as NexmoException;
use Nexmo\Exception;

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
        return 'sms/json';
    }

    /**
     * Send a message.
     *
     * Nexmo supports Unicode for multiple language support. Text length, however, is limited to
     * 70 characters-exceeding 70 characters will have your message split into parts.
     * Further, the mobile device must support the character encoding, for example, a US device may not display Arabic.
     *
     * In the event your text is longer than 160 characters, Nexmo will split the message into parts.
     * Nexmo's response, in that case, will tell you how many parts the message has been sent in.
     *
     * @param string|int $from            Sender address may be alphanumeric (Ex: from=MyCompany20).
     *                                    Restrictions may apply, depending on the destination.
     * @param string|int $to              Mobile number in international format.
     *                                    Ex: 447525856424 or 00447525856424 when sending to UK.
     * @param string     $type            This can be omitted for text (default),
     *                                    but is required when sending a Binary (binary),
     *                                    WAP Push (wappush), Unicode message (unicode), vcal (vcal) or vcard (vcard).
     * @param string     $text            Required when type='text'.
     *                                    Body of the text message (with a maximum length of 3200 characters).
     * @param string     $statusReportReq Set to 1 if you want to receive a delivery report (DLR) for this request.
     *                                    Make sure to configure your "Callback URL" in your "API Settings"
     * @param string     $clientRef       Include any reference string for your reference.
     *                                    Useful for your internal reports (40 characters max).
     * @param string     $networkCode     Force the recipient network operator MCCMNC, make sure to supply the
     *                                    correct information otherwise the message won't be delivered.
     * @param string     $vcard           vcard text body correctly formatted.
     * @param string     $vcal            vcal text body correctly formatted.
     * @param integer    $ttl             Message life span in milliseconds.
     * @param string     $messageClass    Set to 0 for Flash SMS.
     * @param string     $body            Hex encoded binary data. Ex: 0011223344556677
     * @param string     $udh             To set your custom UDH (Hex encoded). Ex: 06050415811581
     * @throws Exception
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
        if(!$from) {
            throw new Exception("\$from parameter cannot be blank");
        }

        if(!$to) {
            throw new Exception("\$to parameter cannot be blank");
        }

        if(!$text) {
            throw new Exception("\$text parameter cannot be blank");
        }

        if ($this->containsUnicode($text)) {
            $type = 'unicode';
        }

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

    protected function containsUnicode($text)
    {
        return max(array_map('ord', str_split($text))) > 127;
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
