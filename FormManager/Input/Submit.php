<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Submit extends Input implements InputInterface {
	protected $attributes = array('type' => 'submit');

	protected function defaultFnRender ($input, $label, $errorLabel) {
		return $input;
	}
}
