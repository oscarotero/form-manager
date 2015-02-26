<?php
namespace FormManager\Validators;

class Time extends Datetime
{
    public static $error_message = 'This value is not a valid time';
    protected static $format = 'H:i:s';
}
