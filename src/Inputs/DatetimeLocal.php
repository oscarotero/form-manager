<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class DatetimeLocal extends Datetime implements InputInterface
{
    public static $error_message = 'This value is not a valid local datetime';

    protected static $format = 'Y-m-d\TH:i:s';

    protected $attributes = ['type' => 'datetime-local'];
}
