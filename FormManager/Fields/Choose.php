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
		if (isset($this[$value])) {
			$this->value = $value;
		}

		return $this;
	}

	public function val ($value = null) {
		if ($value === null) {
			return $this->value;
		}

		if (isset($this[$value])) {
			$this->value = $value;
		}

		return $this;
	}
}
