<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class DatetimeLocal extends Datetime implements FormElementInterface
{
    public static $error_message = 'This value is not a valid local datetime';

    protected static $format = 'Y-m-d\TH:i:s';

    protected $attributes = ['type' => 'datetime-local'];
}
