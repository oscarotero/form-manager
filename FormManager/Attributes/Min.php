<?php
namespace FormManager\Attributes;

class Min {
	public static $error_message = 'The min value allowed is %s';

	public static function attr ($value) {
		if (!is_float($value) && !is_int($value)) {
			throw new \InvalidArgumentException('The min value must be a float number');
		}

		return $value;
	}

	public static function validate ($value, $attr) {
		return (empty($attr) || (strlen($value) === 0) || ($value >= $attr));
	}
}
