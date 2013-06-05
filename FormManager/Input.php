<?php
namespace FormManager;

abstract class Input extends Element {
	const LABEL_POSITION_BEFORE = 1;
	const LABEL_POSITION_AFTER = 2;

	public $isFile = false;

	protected $attributes_validators = array();
	protected $label;
	protected $label_position = self::LABEL_POSITION_BEFORE;
	protected $error;

	public static function __callStatic ($name, $arguments) {
		$class = __NAMESPACE__.'\\Input\\'.ucfirst($name);

		if (class_exists($class)) {
			return new $class;
		}
	}

	public function __toString () {
		switch ($this->label_position) {
			case self::LABEL_POSITION_BEFORE:
				return $this->labelToHtml().$this->toHtml();

			case self::LABEL_POSITION_AFTER:
				return $this->toHtml().$this->labelToHtml();
		}
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
		$this->val($value);
	}

	public function val ($value = null) {
		if ($value === null) {
			return isset($this->attributes['value']) ? $this->attributes['value'] : null;
		}

		$this->attributes['value'] = $value;

		return $this;
	}

	public function validate () {
		$value = $this->val();

		foreach ($this->attributes_validators as $name => $validator) {
			if (!call_user_func($validator, $value, $this->attributes[$name])) {
				$this->error($validator[0]::$error_message, $this->attributes[$name]);

				return false;
			}
		}

		return true;
	}

	public function toHtml (array $attributes = array()) {
		if ($this->error) {
			if (isset($attributes['class'])) {
				$attributes['class'] .= ' error';
			} else {
				$attributes['class'] = 'error';
			}

			$html = '<input'.static::attrHtml($this->attributes, $attributes).'>';
			$html .= '<label class="error">'.$this->error.'</label>';
		} else {
			$html = '<input'.static::attrHtml($this->attributes, $attributes).'>';
		}

		return $html;
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
}
