<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Time extends Datetime implements InputInterface
{
    public static $error_message = 'This value is not a valid time';

    protected static $format = 'H:i:s';

    protected $attributes = ['type' => 'time'];
}
