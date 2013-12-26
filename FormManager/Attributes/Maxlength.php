<?php
namespace FormManager\Attributes;

class Maxlength {
	public static $error_message = 'The max length allowed is %s';
	
	public static function onAdd ($input, $value) {
		if (!is_int($value) || ($value < 0)) {
			throw new \InvalidArgumentException('The maxlength value must be a non-negative integer');
		}

		$input->addValidator('maxlength', array(__CLASS__, 'validate'));

		return $value;
	}

	public static function onRemove ($input) {
		$input->removeValidator('maxlength');
	}

	public static function validate ($input) {
		$value = $input->val();
		$attr = $input->attr('maxlength');

		return (empty($attr) || (strlen($value) <= $attr)) ? true : sprintf(static::$error_message, $attr);
	}
}
