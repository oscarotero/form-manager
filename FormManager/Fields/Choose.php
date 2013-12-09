<?php
namespace FormManager\Fields;

use FormManager\CollectionInterface;

class Choose extends Collection implements CollectionInterface {

	public function prepareChild ($child, $key, $parentPath = null) {
		if ($child instanceof CollectionInterface) {
			throw new \Exception("The Choose field cannot have collections inside", 1);
		}

		$child->val($key);
		$child->attr('name', $parentPath);
	}

	public function load ($value = null, $file = null) {
		$this->val($value);

		return $this;
	}

	public function val ($value = null) {
		if ($value === null) {
			return $this->value;
		}

		$this->value = null;

		foreach ($this as $v => $input) {
			if ($v == $value) {
				$input->check();
				$this->value = $value;
			} else {
				$input->uncheck();
			}
		}

		return $this;
	}
}
