<?php
namespace FormManager\Fields;

use FormManager\Fields\Field;
use FormManager\Inputs\InputInterface;

class Radios extends Choose implements InputInterface {
	public function options (array $options) {
		foreach ($options as $value => $label) {
			$this[$value] = Field::radio()->label($label);
		}

		return $this;
	}
}
