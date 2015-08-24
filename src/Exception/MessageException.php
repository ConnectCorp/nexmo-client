<?php

namespace Nexmo\Exception;

use Nexmo\Exception;

/**
 * For errors when sending messages
 *
 * @author Carson Full <carsonfull@gmail.com>
 */
class MessageException extends Exception
{
    /** @var string */
    protected $errorText;

    public function __construct($code = 0, $errorText = '', $message = '', \Exception $previous = null)
    {
        $this->errorText = $errorText;
        $message = $message ?: 'Unable to send sms message: ' . $errorText . ' - status code: ' . $code;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getErrorText()
    {
        return $this->errorText;
    }
}
