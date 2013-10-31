<?php
namespace FormManager\Fieldsets;

use FormManager\Traits\InputIteratorTrait;
use FormManager\Form;
use FormManager\Element;

abstract class Fieldset extends Element implements \Iterator, \ArrayAccess {
	use InputIteratorTrait;

	protected $name = 'fieldset';
	protected $close = true;
	protected $form;

	public static function __callStatic ($name, $arguments) {
		$class = __NAMESPACE__.'\\'.ucfirst($name);

		if (class_exists($class)) {
			if (isset($arguments[0])) {
				return new $class($arguments[0]);
			}

			return new $class();
		}
	}

	public function offsetSet ($offset, $value) {
		$this->inputs[$offset] = $value;
		$this->form[$offset] = $value;
	}

	public function setForm (Form $form) {
		$this->form = $form;
	}

	public function error ($error = null) {
		if ($error === null) {
			return $this->error;
		}

		$this->error = $error;

		return $this;
	}

	public function attr ($name = null, $value = null) {
		if (is_array($name)) {
			foreach ($name as $name => $value) {
				$this->attr($name, $value);
			}

			return $this;
		}

		if ($value !== null) {
			if ($name === 'name') {
				$value = $this->attr('name').'-'.$value;
			}

			foreach ($this->inputs as $input) {
				$input->attr($name, $value);
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

	public function sanitize (callable $sanitizer) {
		$this->sanitizer = $sanitizer;
	}

	public function id ($id = null) {
		if ($id === null) {
			if (!$this->attributes['id']) {
				$this->attributes['id'] = uniqid($this->attr('name'), true);
			}

			return $this->attributes['id'];
		}

		$this->attributes['id'] = $id;

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

	public function load ($value = null, $file = null) {
		$this->input->load($value, $file);

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

	public function html () {
		$html = '';

		foreach ($this->inputs as $input) {
			$html .= (string)$input;
		}

		return $html;
	}
}
