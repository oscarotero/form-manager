<?php
namespace FormManager\Attributes;

class Required {
	public static $error_message = 'This value is required';

	public static function onAdd ($input, $value) {
		if (!is_bool($value)) {
			throw new \InvalidArgumentException('The required value must be a boolean');
		}

		$input->addValidator('required', array(__CLASS__, 'validate'));

		return $value;
	}

	public static function onRemove ($input) {
		$input->removeValidator('required');
	}

	public static function validate ($input) {
		$value = $input->val();
		$attr = $input->attr('required');

		return (empty($attr) || !empty($value) || strlen($value) > 0) ? true : sprintf(static::$error_message, $attr);
	}
}
