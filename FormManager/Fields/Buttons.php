<?php
namespace FormManager\Fields;

use FormManager\Fields\Field;
use FormManager\Inputs\InputInterface;

class Buttons extends Choose implements InputInterface {
	public function options (array $options) {
		foreach ($options as $value => $html) {
			$this[$value] = Field::button()->type('submit')->html($html);
		}

		return $this;
	}
}
