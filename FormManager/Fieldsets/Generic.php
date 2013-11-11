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
}
