<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Number extends Input implements InputInterface {
	public static $error_message = 'This value is not a valid number';

	protected $attributes = ['type' => 'number'];

	/**
     * {@inheritDoc}
     */
	public function validate () {
		$value = $this->val();

		if (!empty($value) && !filter_var($value, FILTER_VALIDATE_FLOAT)) {
			$this->error(static::$error_message);
			return false;
		}

		return parent::validate();
	}
}
