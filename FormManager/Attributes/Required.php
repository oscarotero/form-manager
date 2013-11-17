<?php
namespace FormManager\Attributes;

class Required {
	public static $error_message = 'This value is required';

	public static function attr ($value) {
		if (!is_bool($value)) {
			throw new \InvalidArgumentException('The required value must be a boolean');
		}

		return $value;
	}

	public static function validate ($value, $attr) {
		return (empty($attr) || !empty($value) || strlen($value) > 0) ? true : sprintf(static::$error_message, $attr);
	}
}
