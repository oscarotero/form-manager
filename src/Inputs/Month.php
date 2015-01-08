<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Month extends Datetime implements FormElementInterface
{
    public static $error_message = 'This value is not a valid month';

    protected static $format = 'Y-m';

    protected $attributes = ['type' => 'month'];
}
