<?php
namespace FormManager;

class Fieldset extends Element implements \Iterator, \ArrayAccess {
	protected $name = 'fieldset';
	protected $inputs = array();

	public $form;

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
			throw new \InvalidArgumentException('Only elements implementing FormManager\\InputInterface must be added to fieldsets');
		}

		if ($offset === null) {
			$offset = $value->attr('name');
		} else {
			$value->attr('name', $offset);
		}

		$value->fieldset = $this;
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

	public function __construct (array $inputs = null) {
		if ($inputs !== null) {
			foreach ($inputs as $name => $input) {
				$this[$name] = $input;
			}
		}
	}

	public function html () {
		$html = '';

		foreach ($this->inputs as $name => $input) {
			$html .= $input->render();
		}

		return $html;
	}
}
