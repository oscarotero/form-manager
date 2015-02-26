<?php
namespace FormManager\Validators;

class Week extends Datetime
{
    public static $error_message = 'This value is not a valid week';
    protected static $format = 'Y-\WW';
}
