<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Time extends Datetime implements FormElementInterface
{
    public static $error_message = 'This value is not a valid time';

    protected static $format = 'H:i:s';

    protected $attributes = ['type' => 'time'];
}
