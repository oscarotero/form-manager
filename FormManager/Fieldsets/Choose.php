<?php
namespace FormManager\Fieldsets;

use FormManager\InputCollectionInterface;

class Choose extends Fieldset implements InputCollectionInterface {
	protected $value = null;

	public function generateName () {
		parent::generateName();

		$name = $this->attr('name');

		foreach ($this->inputs as $key => $input) {
			$input->val($key);
			$input->attr('name', $name);
		}
	}

	public function load ($value = null, $file = null) {
		if (isset($this[$value])) {
			$this->value = $value;
			$this[$value]->load($value);
		}

		return $this;
	}

	public function val ($value = null) {
		if ($value === null) {
			if ($this->value !== null) {
				return $this->value;
			}

			foreach ($this->inputs as $input) {
				if (($value = $input->val()) !== null) {
					return $value;
				}
			}

			return null;
		}

		if (isset($this[$value])) {
			$this->value = $value;
			$this[$value]->val($value);
		}

		return $this;
	}
}
