<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Date extends Datetime implements InputInterface
{
	public static $error_message = 'This value is not a valid date';

    protected static $format = 'Y-m-d';

    protected $attributes = ['type' => 'date'];
}
