<?php
namespace FormManager\Inputs;

class Url extends Input implements InputInterface {
	public static $error_message = 'This value is not a valid url';

	protected $attributes = ['type' => 'url'];

	public function validate () {
		$value = $this->val();

		if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
			$this->error(static::$error_message);
			return false;
		}

		return parent::validate();
	}
}
