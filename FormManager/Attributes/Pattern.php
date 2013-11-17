<?php
namespace FormManager\Attributes;

class Pattern {
	public static $error_message = 'This value is not valid';

	public static function validate ($value, $attr) {
		return (empty($attr) || empty($value) || filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^($attr)$/")))) ? true : sprintf(static::$error_message, $attr);
	}
}
