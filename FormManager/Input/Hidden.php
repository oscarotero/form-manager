<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Hidden extends Input implements InputInterface {
	protected $attributes = array('type' => 'hidden');

	protected function defaultFnRender ($input, $label, $errorLabel) {
		return $input;
	}
}
