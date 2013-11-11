<?php
namespace FormManager\Fieldsets;

use FormManager\InputCollectionInterface;
use FormManager\Traits\PropagateTrait;
use FormManager\Element;

class Multiple extends Element implements \Iterator, \ArrayAccess, InputCollectionInterface {
	use PropagateTrait;

	protected $name = 'fieldset';
	protected $close = true;
	protected $count = 1;

	protected $fieldsets = [];

	public $duplicable;

	public function __construct (array $inputs = null) {
		$this->duplicable = new Generic($inputs);
	}

	public function rewind () {
		return reset($this->fieldsets);
	}

	public function current () {
		return current($this->fieldsets);
	}

	public function key () {
		return key($this->fieldsets);
	}

	public function next () {
		return next($this->fieldsets);
	}

	public function valid () {
		return key($this->fieldsets) !== null;
	}

	public function offsetSet ($offset, $value) {
		throw new \InvalidArgumentException('You cannot add new elements manually to multiple fieldsets');
	}

	public function offsetExists ($offset) {
		return isset($this->fieldsets[$offset]);
	}

	public function offsetUnset ($offset) {
		unset($this->fieldsets[$offset]);
	}

	public function offsetGet ($offset) {
		return isset($this->fieldsets[$offset]) ? $this->fieldsets[$offset] : null;
	}

	public function add (array $inputs) {
		$this->duplicable->add($inputs);

		return $this;
	}

	public function load ($value = null, $file = null) {
		foreach ($value as $k => $value) {
			$this->createCopy(true)->load($value, isset($file[$k]) ? $file[$k] : null);
		}

		return $this;
	}

	public function createCopy ($insert = false) {
		$key = (string)$this->getKey();

		$duplicable = clone $this->duplicable;
		$duplicable->setParent($this);
		$duplicable->setKey($this->count);

		$duplicable->generateName();

		if ($insert === true) {
			$this->fieldsets[$this->count] = $duplicable;
		}

		$this->count++;

		return $duplicable;
	}

	public function val ($value = null) {
		if ($value === null) {
			$values = [];

			foreach ($this->fieldsets as $k => $fieldset) {
				$values[$k] = $fieldset->val();
			}

			return $values;
		}

		foreach ($value as $k => $value) {
			if (isset($this->fieldsets[$k])) {
				$this->fieldsets[$k]->val($value);
			} else {
				$this->createCopy(true)->val($value);
			}
		}

		return $this;
	}

	public function isValid () {
		foreach ($this->fieldsets as $fieldset) {
			if ($fieldset->isValid() === false) {
				return false;
			}
		}

		return true;
	}

	public function html ($html = null) {
		if ($html === null) {
			$html = parent::html();

			foreach ($this->fieldsets as $fieldset) {
				$html .= $fieldset;
			}

			$html .= $this->createCopy();

			return $html;
		}

		parent::html($html);

		return $this;
	}
}