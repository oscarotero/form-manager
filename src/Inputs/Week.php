<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Week extends Datetime implements InputInterface
{
    public static $error_message = 'This value is not a valid week';

    protected static $format = 'Y-\WW';

    protected $attributes = ['type' => 'week'];
}
