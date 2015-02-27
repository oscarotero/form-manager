<?php
namespace FormManager\Validators;

class Number extends Url
{
    const FILTER = FILTER_VALIDATE_FLOAT;

    public static $error_message = 'This value is not a valid number';
}
