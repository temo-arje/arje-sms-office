<?php

namespace Arje\SmsOffice\Exceptions;

use Exception;

class FailedToSendSms extends Exception
{
    /**
     * @return static
     */
    public static function invalidNumber(): FailedToSendSms
    {
        return new static('ტელეფონის ნომერი არასწორია');
    }

    /**
     * @return static
     */
    public static function apiKeyNotProvided(): FailedToSendSms
    {
        return new static('გთხოვთ მიუთითოთ კონფიგურაციაში API გასაღები');
    }

    /**
     * Thrown when there is no sender provided
     *
     * @return static
     */
    public static function senderNotProvided(): FailedToSendSms
    {
        return new static('გთხოვთ მიუთითოთ გამგზავნის სახელი');
    }

}
