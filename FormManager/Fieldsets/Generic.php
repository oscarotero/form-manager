<?php
namespace FormManager\Fieldsets;

use FormManager\InputCollectionInterface;

class Generic extends Fieldset implements InputCollectionInterface {
	public function generateName () {
		parent::generateName();

		foreach ($this->inputs as $input) {
			$input->generateName();
		}
	}

	public function __clone () {
		foreach ($this->inputs as $key => $input) {
			$this->inputs[$key] = clone $input;
			$this->inputs[$key]->setParent($this);
		}
	}
}
