<?php
namespace FormManager\Attributes;

class Pattern {
	public static $error_message = 'This value is not valid';

	public static function onAdd ($input, $value) {
		$input->addValidator('pattern', array(__CLASS__, 'validate'));

		return $value;
	}

	public static function onRemove ($input) {
		$input->removeValidator('pattern');
	}

	public static function validate ($input) {
		$value = $input->val();
		$attr = str_replace('/', '\\/', $input->attr('pattern'));

		return (empty($attr) || empty($value) || filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/'.$attr.'/')))) ? true : sprintf(static::$error_message, $attr);
	}
}
