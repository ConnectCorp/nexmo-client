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
     *                                    Body of the text message (with a maximum length of 3200 characters),
     *                                    UTF-8 and URL encoded value.
     *                                    Ex: "Déjà vu" content would be "D%c3%a9j%c3%a0+vu"
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

        // If $type is empty, 'text' will be assumed by Nexmo's SMS API.
        if (($type == '' || $type === 'text') && $this->containsUnicode($text)) {
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

    /**
     * @param string $text
     * @return int
     */
    protected function containsUnicode($text)
    {
        // Valid GSM default character-set codepoint values from http://unicode.org/Public/MAPPINGS/ETSI/GSM0338.TXT
        $gsm_0338_codepoints = [0x0040, 0x00A3, 0x0024, 0x00A5, 0x00E8, 0x00E9, 0x00F9, 0x00EC, 0x00F2, 0x00E7, 0x000A, 0x00D8, 0x00F8, 0x000D, 0x00C5, 0x00E5, 0x0394, 0x005F, 0x03A6, 0x0393, 0x039B, 0x03A9, 0x03A0, 0x03A8, 0x03A3, 0x0398, 0x039E, 0x00A0, 0x000C, 0x005E, 0x007B, 0x007D, 0x005C, 0x005B, 0x007E, 0x005D, 0x007C, 0x20AC, 0x00C6, 0x00E6, 0x00DF, 0x00C9, 0x0020, 0x0021, 0x0022, 0x0023, 0x00A4, 0x0025, 0x0026, 0x0027, 0x0028, 0x0029, 0x002A, 0x002B, 0x002C, 0x002D, 0x002E, 0x002F, 0x0030, 0x0031, 0x0032, 0x0033, 0x0034, 0x0035, 0x0036, 0x0037, 0x0038, 0x0039, 0x003A, 0x003B, 0x003C, 0x003D, 0x003E, 0x003F, 0x00A1, 0x0041, 0x0042, 0x0043, 0x0044, 0x0045, 0x0046, 0x0047, 0x0048, 0x0049, 0x004A, 0x004B, 0x004C, 0x004D, 0x004E, 0x004F, 0x0050, 0x0051, 0x0052, 0x0053, 0x0054, 0x0055, 0x0056, 0x0057, 0x0058, 0x0059, 0x005A, 0x00C4, 0x00D6, 0x00D1, 0x00DC, 0x00A7, 0x00BF, 0x0061, 0x0062, 0x0063, 0x0064, 0x0065, 0x0066, 0x0067, 0x0068, 0x0069, 0x006A, 0x006B, 0x006C, 0x006D, 0x006E, 0x006F, 0x0070, 0x0071, 0x0072, 0x0073, 0x0074, 0x0075, 0x0076, 0x0077, 0x0078, 0x0079, 0x007A, 0x00E4, 0x00F6, 0x00F1, 0x00FC, 0x00E0];

        // Split $text into an array in a way that respects multibyte characters.
        $text_chars = preg_split('//u', $text, null, PREG_SPLIT_NO_EMPTY);

        // Array of codepoint values for characters in $text.
        $text_codepoints = array_map([$this, 'uord'], $text_chars);

        // Filter the array to contain only codepoints from $text that are not in the set of valid GSM codepoints.
        $non_gsm_codepoints = array_diff($text_codepoints, $gsm_0338_codepoints);

        // The text contains unicode if the result is not empty.
        return !empty($non_gsm_codepoints);
    }

    /**
     * @param char $unicode_char
     * @return int
     */
    public function uord($unicode_char)
    {
        $k = mb_convert_encoding($unicode_char, 'UCS-2LE', 'UTF-8');
        $k1 = ord(substr($k, 0, 1));
        $k2 = ord(substr($k, 1, 1));
        return $k2 * 256 + $k1;
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
