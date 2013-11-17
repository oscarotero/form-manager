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

			if (class_exists($class)) {
				if (method_exists($class, 'validate')) {
					$this->validators[$name] = array($class, 'validate');
				}

				if (method_exists($class, 'attr')) {
					$value = call_user_func(array($class, 'attr'), $value);
				}
			}
		}

		return parent::attr($name, $value);
	}

	public function removeAttr ($name) {
		parent::removeAttr($name);

		unset($this->validators[$name]);
	}

	public function val ($value = null) {
		if ($value === null) {
			return $this->attr('value');
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
			$value = $sanitizer($value);
		}

		$this->val($value);

		return $this;
	}

	public function validate () {
		$this->error = null;
		$value = $this->val();

		foreach ($this->validators as $name => $validator) {
			if (($error = call_user_func($validator, $value, $this->attributes[$name])) !== true) {
				$this->error($error);

				return false;
			}
		}

		return true;
	}

	public function isValid () {
		return $this->validate();
	}
}
