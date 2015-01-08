<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Week extends Datetime implements FormElementInterface
{
    public static $error_message = 'This value is not a valid week';

    protected static $format = 'Y-\WW';

    protected $attributes = ['type' => 'week'];
}
