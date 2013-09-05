<?php
namespace FormManager;

use FormManager\Input;

class Form extends Element implements \Iterator, \ArrayAccess {
	protected $inputs = array();
	protected $groups = array();
	protected $template;

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
		$value->form = $this;
		$this->inputs[$offset] = $value;
	}

	public function offsetExists ($offset) {
		return isset($this->inputs[$offset]);
	}

	public function offsetUnset ($offset) {
		unset($this->inputs[$offset]);

		foreach ($this->groups as &$group) {
			if (($key = array_search($offset, $group)) !== false) {
				unset($group[$key]);
				break;
			}
		}
	}

	public function offsetGet ($offset) {
		return isset($this->inputs[$offset]) ? $this->inputs[$offset] : null;
	}

	public function template (callable $template) {
		$this->template = $template;

		return $this;
	}

	public function inputs ($inputs = null, $group = null) {
		if ($inputs === null) {
			return $this->inputs;
		}

		if (is_string($inputs)) {
			if (!isset($this->groups[$inputs])) {
				throw new \InvalidArgumentException("The group '$inputs' does not exist in this form");
			}

			$selectedInputs = array();

			foreach ($this->groups[$inputs] as $name) {
				$selectedInputs[$name] = $this->inputs[$name];
			}

			return $selectedInputs;
		}

		if (is_array($inputs)) {
			foreach ($inputs as $name => $value) {
				$this[$name] = $value;
			}

			if ($group !== null) {
				$this->groups[$group] = array_keys($inputs);
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

	protected function render (array $attributes = null, $group = null) {
		$inputs = $this->inputs($group);
		
		$input = $this->toHtml($attributes);
		$label = $this->label->toHtml($labelAttributes);
		$errorLabel = $this->errorLabel->html() ? $this->errorLabel->toHtml($errorLabelAttributes) : '';

		if ($this->template) {
			return $this->template($input, $label, $errorLabel);
		}

		return $this->defaultTemplate($input, $label, $errorLabel);
	}

	protected function defaultTemplate ($openHtml, array $inputs, $closeHtml) {
		$html = $openHtml;

		foreach ($inputs as $input) {
			$html .= (string)$input;
		}

		$html .= $closeHtml;

		return $html;
	}
}
