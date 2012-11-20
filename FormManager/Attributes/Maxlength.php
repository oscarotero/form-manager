<?php
namespace FormManager\Attributes;

class Maxlength {
	public static $error_message = 'The max length allowed is %s';

	public static function attr ($value) {
		if (!is_int($value) || ($value < 0)) {
			throw new \InvalidArgumentException('The maxlength value must be a non-negative integer');
		}

		return $value;
	}

	public static function validate ($value, $attr) {
		return (empty($attr) || (strlen($value) <= $attr));
	}
}
