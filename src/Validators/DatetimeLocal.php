<?php
namespace FormManager\Validators;

class DatetimeLocal extends Datetime
{
    public static $error_message = 'This value is not a valid local datetime';
    protected static $format = 'Y-m-d\TH:i:s';
}
