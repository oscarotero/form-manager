<?php
namespace FormManager\Fields;

use FormManager\InputInterface;
use FormManager\Inputs\Input;

class Checkbox extends Field implements InputInterface {
	public function __construct () {
		$this->input = Input::checkbox();
	}

	public function toHtml () {
		$label = isset($this->label) ? (string)$this->label : '';

		return "$this->input $label $this->errorLabel";
	}
}
