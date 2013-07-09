<?php
namespace FormManager\Input;

use FormManager\Element;
use FormManager\Input;
use FormManager\InputInterface;

class Collection extends Element implements \Iterator, \ArrayAccess, InputInterface {
	public $parent;
	public $group;
	
	protected $inputContainer;
	protected $inputs = array();
	protected $value = null;

	public function rewind () {
		return reset($this->inputs);
	}
	public function current () {
		return current($this->inputs);
	}
	public function key () {
		return key($this->inputs);
	}
	public function next () {
		return next($this->inputs);
	}
	public function valid () {
		return key($this->inputs) !== null;
	}

	public function offsetSet ($offset, $value) {
		if (!($value instanceof Input)) {
			throw new \InvalidArgumentException('Only FormManager\\Input instances must be added to forms');
		}

		if ($offset === null) {
			$offset = $value->val();
		} else {
			$value->val($offset);
		}
		
		$value->attr($this->attr());
		$value->group($this->group);
		$value->parent = $this;
		$this->inputs[$offset] = $value;
	}

	public function offsetExists ($offset) {
		return isset($this->inputs[$offset]);
	}

	public function offsetUnset ($offset) {
		unset($this->inputs[$offset]);
	}

	public function offsetGet ($offset) {
		return isset($this->inputs[$offset]) ? $this->inputs[$offset] : null;
	}

	public function __toString () {
		return $this->inputsHtml();
	}

	public function __construct (array $inputs = null) {
		if ($inputs !== null) {
			$this->inputs($inputs);
		}
	}

	public function attr ($name = null, $value = null) {
		if (($value !== null) || is_array($name)) {
			foreach ($this->inputs as $Input) {
				$Input->attr($name, $value);
			}
		}

		return parent::attr($name, $value);
	}

	public function removeAttr ($name) {
		foreach ($this->inputs as $Input) {
			$Input->removeAttr($name);
		}

		return parent::removeAttr($name);
	}

	public function inputs (array $inputs = null) {
		if ($inputs === null) {
			return $this->inputs;
		}

		foreach ($inputs as $name => $value) {
			$this[$name] = $value;
		}

		return $this;
	}

	public function load ($value = null) {
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

			foreach ($this->inputs as $Input) {
				if (($value = $Input->val()) !== null) {
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

	public function isValid () {
		foreach ($this->inputs as $Input) {
			if ($Input->isValid() === false) {
				return false;
			}
		}

		return true;
	}

	public function setInputContainer ($html) {
		$this->inputContainer = $html;

		return $this;
	}

	public function getInputContainer () {
		if (isset($this->inputContainer)) {
			return $this->inputContainer;
		}

		if (isset($this->parent)) {
			return $this->parent->getInputContainer();
		}
	}

	public function inputsHtml () {
		$html = '';

		foreach ($this->inputs as $name => $Input) {
			$html .= (string)$Input;
		}

		return $html;
	}
}
