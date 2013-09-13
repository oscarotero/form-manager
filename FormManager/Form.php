<?php
namespace FormManager;

use FormManager\Input;

class Form extends Element implements \Iterator, \ArrayAccess {
	protected $name = 'form';
	protected $inputs = array();
	protected $fieldsets = array();

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
		if ($value instanceof Fieldset) {
			$this->addFieldset($value);
			return;
		}

		if (!($value instanceof InputInterface)) {
			throw new \InvalidArgumentException('Only elements implementing FormManager\\InputInterface must be added to forms');
		}

		if ($offset === null) {
			$offset = $value->attr('name');
		} else {
			$value->attr('name', $offset);
		}

		$value->form = $this;
		$this->inputs[$offset] = $value;

		if (!$value->fieldset) {
			if (!isset($this->fieldsets[-1])) {
				$this->fieldsets[-1] = new Fieldset;
			}

			$this->fieldsets[-1][] = $value;
		}
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

	public function addInputs (array $inputs) {
		foreach ($inputs as $name => $input) {
			$this[$name] = $input;
		}
	}

	public function addFieldset (Fieldset $fieldset) {
		foreach ($fieldset as $name => $input) {
			$this[$name] = $input;
		}

		$this->fieldsets[] = $fieldset;
	}

	public function load (array $get = array(), array $post = array(), array $file = array()) {
		$data = ($this->attr('method') === 'post') ? $post : $get;

		foreach ($this->inputs as $name => $Input) {
			if (empty($Input::IS_FILE)) {
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

	public function html () {
		$html = '';

		foreach ($this->fieldsets as $fieldset) {
			$html .= (string)$fieldset;
		}

		return $html;
	}
}
