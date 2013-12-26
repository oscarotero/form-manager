<?php
namespace FormManager\Inputs;

use FormManager\Traits\ChildTrait;

use FormManager\Element;

abstract class Input extends Element {
	use ChildTrait;

	protected $name = 'input';
	protected $validators = [];
	protected $sanitizer;
	protected $error;


	public static function __callStatic ($name, $arguments) {
		$class = __NAMESPACE__.'\\'.ucfirst($name);

		if (class_exists($class)) {
			return new $class;
		}
	}

	public function attr ($name = null, $value = null) {
		if (is_array($name)) {
			foreach ($name as $name => $value) {
				$this->attr($name, $value);
			}

			return $this;
		}

		if ($value !== null) {
			$class = 'FormManager\\Attributes\\'.ucfirst($name);

			if (class_exists($class) && method_exists($class, 'onAdd')) {
				$value = $class::onAdd($this, $value);
			}
		}

		return parent::attr($name, $value);
	}

	public function removeAttr ($name) {
		parent::removeAttr($name);

		$class = 'FormManager\\Attributes\\'.ucfirst($name);

		if (class_exists($class) && method_exists($class, 'onRemove')) {
			$class::onRemove($this);
		}
	}

	public function val ($value = null) {
		if ($value === null) {
			return $this->attr('value');
		}

		if ($this->attr('multiple') && !is_array($value)) {
			$value = array($value);
		}

		return $this->attr('value', $value);
	}

	public function error ($error = null) {
		if ($error === null) {
			return $this->error;
		}

		$this->error = $error;

		return $this;
	}

	public function id ($id = null) {
		if ($id === null) {
			if (empty($this->attributes['id'])) {
				$this->attributes['id'] = uniqid('id_', true);
			}

			return $this->attributes['id'];
		}

		$this->attributes['id'] = $id;

		return $this;
	}

	public function sanitize (callable $sanitizer) {
		$this->sanitizer = $sanitizer;

		return $this;
	}

	public function load ($value = null, $file = null) {
		if (($sanitizer = $this->sanitizer) !== null) {
			if ($this->attr('multiple') && is_array($value)) {
				foreach ($value as &$val) {
					$val = $sanitizer($val);
				}
			} else {
				$value = $sanitizer($value);
			}
		}

		$this->val($value);

		return $this;
	}

	public function addValidator ($name, $validator) {
		$this->validators[$name] = $validator;

		return $this;
	}

	public function removeValidator ($name) {
		unset($this->validators[$name]);

		return $this;
	}

	public function validate () {
		$this->error = null;

		foreach ($this->validators as $validator) {
			if (($error = $validator($this)) !== true) {
				$this->error = $error;
				return false;
			}
		}

		return true;
	}

	public function isValid () {
		return $this->validate();
	}

	public function check () {
		return $this;
	}

	public function uncheck () {
		return $this;
	}
}
