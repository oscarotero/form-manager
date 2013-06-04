<?php
namespace FormManager;

class Form extends Element implements \Iterator, \ArrayAccess {
	protected $inputs;
	protected $valid;

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
		$value->attr('name', $offset);
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

	public function inputs (array $inputs = null) {
		if ($inputs === null) {
			return $this->inputs;
		}

		foreach ($inputs as $name => $value) {
			$this[$name] = $value;
		}

		return $this;
	}

	public function load (array $get, array $post, array $file) {
		$data = ($this->attr('method') === 'post') ? $post : $get;

		foreach ($file as $name => $file) {
			if (!empty($this->inputs[$name]->isFile)) {
				$data[$name] = $file;
			}
		}

		return $this->val($data);
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

		$this->validate();

		return $this;
	}

	public function validate () {
		$this->valid = true;

		foreach ($this->inputs as $Input) {
			if ($Input->validate() === false) {
				$this->valid = false;
			}
		}

		return $this;
	}

	public function isValid () {
		if ($this->valid === null) {
			$this->validate();
		}

		return $this->valid;
	}

	public function openHtml (array $attributes = null) {
		return '<form'.static::attrHtml($this->attributes, $attributes).'>'."\n";
	}

	public function toHtml (array $attributes = null) {
		$html = $this->openHtml();

		foreach ($this->inputs as $name => $Input) {
			$html .= '<div>'."\n";
			$html .= "\t".$Input->__toString()."\n";
			$html .= '</div>'."\n";
		}

		$html .= '</form>'."\n";

		return $html;
	}
}
