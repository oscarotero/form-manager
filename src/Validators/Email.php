<?php
namespace FormManager\Validators;

class Email extends Url
{
    const FILTER = FILTER_VALIDATE_EMAIL;

    public static $error_message = 'This value is not a valid email';
}
