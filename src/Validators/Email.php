<?php
namespace FormManager\Validators;

use FormManager\InputInterface;
use FormManager\InvalidValueException;

class Email extends Url
{
    const FILTER = FILTER_VALIDATE_EMAIL;

    public static $error_message = 'This value is not a valid email';
}
