<?php
namespace FormManager;

abstract class Input extends Element {
	const LABEL_POSITION_BEFORE = 1;
	const LABEL_POSITION_AFTER = 2;

	public $isFile = false;
	public $form;

	protected $inputContainer;
	protected $attributes_validators = array();
	protected $label;
	protected $label_position = self::LABEL_POSITION_BEFORE;
	protected $error_label_position = self::LABEL_POSITION_AFTER;
	protected $error;
	protected $sanitizer;

	public static function __callStatic ($name, $arguments) {
		$class = __NAMESPACE__.'\\Input\\'.ucfirst($name);

		if (class_exists($class)) {
			return (new \ReflectionClass($class))->newInstanceArgs($arguments);
		}
	}

	public function __toString () {
		return $this->toHtml();
	}

	public function label ($label = null) {
		if ($label === null) {
			return $this->label;
		}

		$this->label = $label;

		return $this;
	}

	public function error ($error = null) {
		if ($error === null) {
			return $this->error;
		}

		if (func_num_args() > 1) {
			$this->error = vsprintf($error, array_slice(func_get_args(), 1));
		} else {
			$this->error = $error;
		}

		return $this;
	}

	public function attr ($name, $value = null) {
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

	public function setInputContainer ($html) {
		$this->inputContainer = $html;

		return $this;
	}

	public function getInputContainer () {
		if (isset($this->inputContainer)) {
			return $this->inputContainer;
		}

		if (isset($this->form)) {
			return $this->form->getInputContainer();
		}
	}

	public function toHtml (array $attributes = null) {
		$html = '';
		$label = $this->labelToHtml();
		$errorLabel = $this->errorLabelToHtml();
		$input = $this->inputToHtml($attributes);

		switch ($this->label_position) {
			case self::LABEL_POSITION_BEFORE:
				$html = $label.$input;
				break;

			case self::LABEL_POSITION_AFTER:
				$html = $input.$label;
				break;
		}

		switch ($this->error_label_position) {
			case self::LABEL_POSITION_BEFORE:
				$html = $errorLabel.$html;
				break;

			case self::LABEL_POSITION_AFTER:
				$html = $html.$errorLabel;
				break;
		}

		if (($inputContainer = $this->getInputContainer())) {
			return sprintf($inputContainer, $html);
		}

		return $html;
	}

	public function inputToHtml (array $attributes = null) {
		return '<input'.static::attrHtml($this->attributes, $attributes).'>';
	}

	public function labelToHtml (array $attributes = array()) {
		if ($this->label() === null) {
			return '';
		}

		if (!$this->attr('id')) {
			$this->attr('id', uniqid('input-'));
		}

		$attributes['for'] = $this->attr('id');

		return '<label'.static::attrHtml($attributes).'>'.$this->label().'</label>';
	}

	public function errorLabelToHtml (array $attributes = array()) {
		if (empty($this->error)) {
			return '';
		}

		if (!$this->attr('id')) {
			$this->attr('id', uniqid('input-'));
		}

		$attributes['for'] = $this->attr('id');
		
		if (empty($attributes['class'])) {
			$attributes['class'] = ' error';
		} else {
			$attributes['class'] .= 'error';
		}

		return '<label'.static::attrHtml($attributes).'>'.$this->error.'</label>';
	}
}
