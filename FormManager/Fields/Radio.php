<?php
namespace FormManager\Fields;

use FormManager\Inputs\InputInterface;
use FormManager\Inputs\Input;

class Radio extends Field implements InputInterface {
	public function __construct () {
		$this->input = Input::radio();
	}

	public function toHtml () {
		$label = isset($this->label) ? (string)$this->label : '';

		return "$this->input $label $this->errorLabel";
	}
}
