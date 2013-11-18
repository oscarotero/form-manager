<?php
namespace FormManager\Fields;

use FormManager\CollectionInterface;

class Duplicable extends Collection implements CollectionInterface {
	public $field;

	protected $index = 0;
	protected $parentPath;

	public function __construct ($children = null) {
		if (is_array($children)) {
			$this->field = new Collection($children);
		} else {
			$this->field = clone $children;
		}
	}

	public function add ($key, $value = null) {
		$this->field->add($key, $value);

		return $this;
	}

	public function load ($value = null, $file = null) {
		if (($sanitizer = $this->sanitizer) !== null) {
			$value = $sanitizer($value);
		}

		$this->children = [];
		$this->index = 0;

		if ($value) {
			foreach ($value as $key => $value) {
				$child = $this->createDuplicate();

				$child->load($value, isset($file[$key]) ? $file[$key] : null);
			}
		}

		return $this;
	}

	public function val ($value = null) {
		if ($value === null) {
			return parent::val();
		}

		$this->children = [];

		if ($value) {
			foreach ($value as $key => $value) {
				$child = isset($this->children[$key]) ? $this->children[$key] : $this->createDuplicate($key);
				
				$child->val($value);
			}
		}

		return $this;
	}

	protected function createDuplicate ($index = null, $insert = true) {
		$child = clone $this->field;

		if ($index === null) {
			$index = $this->index++;
		}

		if ($insert) {
			$this->children[$index] = $child;
		}

		$child->setParent($this);
		$this->prepareChild($child, $index, $this->parentPath);

		return $child;
	}

	public function getDuplicate ($index = '::n::') {
		return $this->createDuplicate($index, false);
	}

	public function prepareChildren ($parentPath) {
		$this->parentPath = $parentPath;

		foreach ($this->children as $key => $child) {
			$this->prepareChild($child, $key, $this->parentPath);
		}
	}
}
