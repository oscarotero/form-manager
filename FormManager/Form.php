<?php
namespace FormManager;

use FormManager\Input;
use FormManager\Input\Collection;

class Form extends Element implements \Iterator, \ArrayAccess {
	protected $inputContainer;
	protected $inputs;

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
		if (!($value instanceof InputInterface)) {
			throw new \InvalidArgumentException('Only elements implementing FormManager\\InputInterface must be added to forms');
		}

		$value->attr('name', $offset);
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

	public function inputs ($inputs = null, $group = null) {
		if ($inputs === null) {
			return $this->inputs;
		}

		if (is_string($inputs)) {
			$selectedInputs = array();

			foreach ($this->inputs as $name => $value) {
				if ($value->group === $inputs) {
					$selectedInputs[$name] = $value;
				}
			}

			return $selectedInputs;
		}

		if (is_array($inputs)) {
			foreach ($inputs as $name => $value) {
				$value->group = $group;
				$this[$name] = $value;
			}
		}

		return $this;
	}

	public function load (array $get = array(), array $post = array(), array $file = array()) {
		$data = ($this->attr('method') === 'post') ? $post : $get;

		foreach ($this->inputs as $name => $Input) {
			if (empty($Input->isFile)) {
				$Input->load(isset($data[$name]) ? $data[$name] : null);
			} else {
				$Input->load(isset($file[$name]) ? $file[$name] : null);
			}
		}

		return $this;
	}

	public function val (array $value = null) {
		if ($value === null) {
			$value = array();

			foreach ($this->inputs as $name => $Input) {
				$value[$name] = $Input->val();
			}

			return $value;
		}

		foreach ($value as $name => $value) {
			if (isset($this->inputs[$name])) {
				$this->inputs[$name]->val($value);
			}
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
	}

	public function getInputContainer () {
		return $this->inputContainer;
	}

	public function openHtml (array $attributes = null) {
		return '<form'.static::attrHtml($this->attributes, $attributes).'>'."\n";
	}

	public function closeHtml () {
		return '</form>'."\n";
	}

	public function inputsHtml ($group = null) {
		$html = '';

		$inputs = $this->inputs($group);

		foreach ($inputs as $name => $Input) {
			$html .= (string)$Input;
		}

		return $html;
	}

	public function toHtml (array $attributes = null) {
		return $this->openHtml($attributes)
				. $this->inputsHtml()
				. $this->closeHtml();
	}
}
