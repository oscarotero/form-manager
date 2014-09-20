<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Month extends Datetime implements InputInterface
{
	public static $error_message = 'This value is not a valid month';

    protected static $format = 'Y-m';

    protected $attributes = ['type' => 'month'];
}
