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

	public function addDuplicate () {
		$field = clone $this->field;

		$this->children[$this->index] = $field->setParent($this);
		$this->prepareChild($field, $this->index, $this->parentPath);

		++$this->index;

		return $field;
	}

	public function prepareChildren ($parentPath) {
		$this->parentPath = $parentPath;
	}
}
