<?php
namespace FormManager\Input;

use FormManager\Input;

class Email extends Input {
	public static $error_message = 'This value is not a valid email';
	protected $attributes = array('type' => 'email');

	public function validate () {
		$value = $this->val();

		if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
			$this->error(static::$error_message);
			return false;
		}

		return parent::validate();
	}
}
