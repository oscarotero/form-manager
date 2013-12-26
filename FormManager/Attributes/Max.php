<?php
namespace FormManager\Attributes;

class Max {
	public static $error_message = 'The max value allowed is %s';

	public static function onAdd ($input, $value) {
		if (!is_float($value) && !is_int($value)) {
			throw new \InvalidArgumentException('The max value must be a float number');
		}

		$input->addValidator('max', array(__CLASS__, 'validate'));

		return $value;
	}

	public static function onRemove ($input) {
		$input->removeValidator('max');
	}

	public static function validate ($input) {
		$value = $input->val();
		$attr = $input->attr('max');

		return (empty($attr) || ($value <= $attr)) ? true : sprintf(static::$error_message, $attr);
	}
}
