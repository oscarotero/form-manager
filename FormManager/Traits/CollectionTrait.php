<?php
namespace FormManager\Traits;

use FormManager\CommonInterface;

trait CollectionTrait {
	protected $inputs = [];

	public function __construct (array $inputs = null) {
		if ($inputs) {
			$this->add($inputs);
		}
	}

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
		if (!($value instanceof CommonInterface)) {
			throw new \InvalidArgumentException('Only elements implementing FormManager\\CommonInterface must be added to forms');
		}

		if ($offset === null) {
			throw new \InvalidArgumentException('You must define a name to every element added to form');
		}

		$value->setParent($this);
		$value->setKey($offset);

		$this->addInput($value);
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

	public function add (array $inputs) {
		foreach ($inputs as $name => $input) {
			$this[$name] = $input;
		}

		return $this;
	}

	protected function addInput ($input) {
		if (!$this->getParent() || !empty($this->getKey())) {
			$input->generateName();
		}

		$this->inputs[$input->getKey()] = $input;
	}

	public function load ($value = null, $file = null) {
		foreach ($this->inputs as $name => $input) {
			$input->load((isset($value[$name]) ? $value[$name] : null), (isset($file[$name]) ? $file[$name] : null));
		}

		return $this;
	}

	public function val ($value = null) {
		if ($value === null) {
			$values = [];

			foreach ($this->inputs as $name => $input) {
				$values[$name] = $input->val();
			}

			return $values;
		}

		foreach ($value as $name => $value) {
			if (isset($this->inputs[$name])) {
				$this->inputs[$name]->val($value);
			}
		}

		return $this;
	}

	public function isValid () {
		foreach ($this->inputs as $input) {
			if ($input->isValid() === false) {
				return false;
			}
		}

		return true;
	}

	public function html ($html = null) {
		if ($html === null) {
			$html = $this->html;

			foreach ($this->inputs as $input) {
				$html .= (string)$input;
			}

			return $html;
		}

		$this->html = $html;

		return $this;
	}
}
