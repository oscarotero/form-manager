<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Date extends Datetime implements FormElementInterface
{
    public static $error_message = 'This value is not a valid date';

    protected static $format = 'Y-m-d';

    protected $attributes = ['type' => 'date'];
}
