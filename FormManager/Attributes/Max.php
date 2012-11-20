<?php
namespace FormManager\Attributes;

class Max {
	public static $error_message = 'The max value allowed is %s';

	public static function attr ($value) {
		if (!is_float($value) && !is_int($value)) {
			throw new \InvalidArgumentException('The max value must be a float number');
		}

		return $value;
	}

	public static function validate ($value, $attr) {
		return (empty($attr) || ($value <= $attr));
	}
}
