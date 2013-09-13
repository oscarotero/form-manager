<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Url extends Input implements InputInterface {
	protected $attributes = array('type' => 'url');

	public static $error_message = 'This value is not a valid url';

	public function validate () {
		$value = $this->val();

		if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
			$this->error(static::$error_message);
			return false;
		}

		return parent::validate();
	}
}
