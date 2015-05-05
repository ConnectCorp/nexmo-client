<?php

namespace Nexmo\Entity;

/**
 * An object representation of Nexmo's number
 *
 * @see \Nexmo\Service\Account::numbers
 *
 * @author Carson Full <carsonfull@gmail.com>
 */
class Number extends Collection
{
    /**
     * The number's type. Possible values are mobile-lvn, landline, mobile-shortcode
     *
     * @return string
     */
    public function type()
    {
        return $this->get('type');
    }

    /**
     * The number is mobile
     *
     * @return bool
     */
    public function isMobile()
    {
        return $this->type() === 'mobile-lvn';
    }

    /**
     * The number is a landline
     *
     * @return bool
     */
    public function isLandline()
    {
        return $this->type() === 'landline';
    }

    /**
     * The number is a short code
     *
     * @return bool
     */
    public function isShortCode()
    {
        return $this->type() === 'mobile-shortcode';
    }

    /**
     * Country Code
     *
     * @return string
     */
    public function countryCode()
    {
        return $this->get('country');
    }

    /**
     * A list of the number's features.
     * Possible list values are SMS and VOICE.
     *
     * @return string[]
     */
    public function features()
    {
        return $this->getArray('features');
    }

    /**
     * Whether the number supports SMS
     *
     * @return bool
     */
    public function isSms()
    {
        return in_array('SMS', $this->features());
    }

    /**
     * Whether the number supports voice
     *
     * @return bool
     */
    public function isVoice()
    {
        return in_array('VOICE', $this->features());
    }

    /**
     * Phone number
     *
     * @return string
     */
    public function number()
    {
        return $this->get('msisdn');
    }

    /**
     * Inbound callback url
     *
     * @return string
     */
    public function callbackUrl()
    {
        return $this->get('moHttpUrl');
    }

    /**
     * The voice callback type for SIP end point (sip), for a telephone number (tel),
     * or for VoiceXML end point (vxml).
     *
     * @return string|null
     */
    public function voiceCallbackType()
    {
        return $this->get('voiceCallbackType');
    }

    /**
     * The voice callback value based on the voice callback type
     *
     * @return string
     */
    public function voiceCallbackValue()
    {
        return $this->get('voiceCallbackValue');
    }

    /**
     * The URL to which Nexmo will send a request when a call ends.
     *
     * @return string|null
     */
    public function voiceStatusCallbackUrl()
    {
        return $this->get('voiceStatusCallbackUrl');
    }
}
