<?php
namespace FormManager\Input;

use FormManager\Input;

class Url extends Input {
	public static $error_message = 'This value is not a valid url';
	protected $attributes = array('type' => 'url');

	public function validate () {
		$value = $this->val();

		if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
			$this->error(static::$error_message);
			return false;
		}

		return parent::validate();
	}
}
