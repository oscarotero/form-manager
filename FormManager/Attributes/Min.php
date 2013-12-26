<?php
namespace FormManager\Attributes;

class Min {
	public static $error_message = 'The min value allowed is %s';

	public static function onAdd ($input, $value) {
		if (!is_float($value) && !is_int($value)) {
			throw new \InvalidArgumentException('The min value must be a float number');
		}

		$input->addValidator('min', array(__CLASS__, 'validate'));

		return $value;
	}

	public static function onRemove ($input) {
		$input->removeValidator('min');
	}

	public static function validate ($input) {
		$value = $input->val();
		$attr = $input->attr('min');

		return ((strlen($value) === 0) || ($value >= $attr)) ? true : sprintf(static::$error_message, $attr);
	}
}
