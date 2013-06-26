<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Range extends Number implements InputInterface {
	public static $error_message = 'This value is not a valid number';
	protected $attributes = array('type' => 'range');
}
