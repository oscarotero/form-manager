<?php
namespace FormManager\Fieldsets;

use FormManager\InputCollectionInterface;

class Choose extends Fieldset implements InputCollectionInterface {
	public function generateName () {
		parent::generateName();

		$name = $this->attr('name');

		foreach ($this->inputs as $key => $input) {
			$input->val($key);
			$input->attr('name', $name);
		}
	}
}
