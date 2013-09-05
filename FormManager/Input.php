<?php
namespace FormManager;

abstract class Input extends Element {
	const IS_FILE = false;

	protected $template;
	protected $attributes_validators = array();
	protected $sanitizer;

	public $form;
	public $errorLabel;
	public $label;

	public function __construct () {
		$this->label = new Label($this);
		$this->errorLabel = new Label($this);
	}

	public static function __callStatic ($name, $arguments) {
		$class = __NAMESPACE__.'\\Input\\'.ucfirst($name);

		if (class_exists($class)) {
			return (new \ReflectionClass($class))->newInstanceArgs($arguments);
		}
	}

	public function __toString () {
		return $this->toHtml();
	}

	public function template (callable $template) {
		$this->template = $template;

		return $this;
	}

	public function error ($error = null) {
		if ($error === null) {
			return $this->errorLabel->html();
		}

		if (func_num_args() > 1) {
			$error = vsprintf($error, array_slice(func_get_args(), 1));
		}

		$this->errorLabel->html($error);

		return $this;
	}

	public function attr ($name = null, $value = null) {
		if ($name === 'value') {
			return $this->val($value);
		}

		if ($value !== null) {
			$class = 'FormManager\\Attributes\\'.ucfirst($name);

			if (class_exists($class)) {
				if (method_exists($class, 'validate')) {
					$this->attributes_validators[$name] = array($class, 'validate');
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

	public function id ($value = null) {
		if ($value === null) {
			if (!$this->attr('id')) {
				$this->attr('id', uniqid('input-'));
			}

			return $this->attr('id');
		}
		
		return $this->attr('id', $value);
	}

	public function load ($value = null) {
		if (($sanitizer = $this->sanitizer) !== null) {
			$value = $sanitizer($value);
		}

		$this->val($value);

		return $this;
	}

	public function sanitize (callable $sanitizer) {
		$this->sanitizer = $sanitizer;

		return $this;
	}

	public function val ($value = null) {
		if ($value === null) {
			return isset($this->attributes['value']) ? $this->attributes['value'] : null;
		}

		$this->attributes['value'] = $value;
		$this->validate();

		return $this;
	}

	public function validate () {
		$this->error = null;
		$value = $this->val();

		foreach ($this->attributes_validators as $name => $validator) {
			if (!call_user_func($validator, $value, $this->attributes[$name])) {
				$this->error($validator[0]::$error_message, $this->attributes[$name]);

				return false;
			}
		}

		return true;
	}

	public function isValid () {
		return ($this->error === null);
	}

	protected function defaultTemplate ($input, $label, $errorLabel) {
		return "$label $input $errorLabel";
	}

	protected function render (array $attributes = null, array $labelAttributes = null, array $errorLabelAttributes = null) {
		$input = $this->toHtml($attributes);
		$label = $this->label->toHtml($labelAttributes);
		$errorLabel = $this->errorLabel->html() ? $this->errorLabel->toHtml($errorLabelAttributes) : '';

		if ($this->template) {
			return $this->template($input, $label, $errorLabel);
		}

		return $this->defaultTemplate($input, $label, $errorLabel);
	}
}
