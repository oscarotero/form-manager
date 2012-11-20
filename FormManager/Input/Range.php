<?php
namespace FormManager\Input;

use FormManager\Input;

class Range extends Number {
	public static $error_message = 'This value is not a valid number';
	protected $attributes = array('type' => 'range');
}
