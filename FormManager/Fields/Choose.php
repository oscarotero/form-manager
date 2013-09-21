<?php
namespace FormManager\Fields;

use FormManager\Element;
use FormManager\Inputs\InputInterface;
use FormManager\Form;
use FormManager\Fieldsets\FieldsetInterface;
use FormManager\Traits\InputIteratorTrait;

abstract class Choose extends Element implements \Iterator, \ArrayAccess {
	use InputIteratorTrait;

	protected $value = null;
	protected $sanitizer = null;

	public $form;
	public $fieldset;

	public function offsetSet ($offset, $value) {
		if (!($value instanceof InputInterface)) {
			throw new \InvalidArgumentException('Only elements implementing FormManager\\InputInterface must be added to choose');
		}

		if ($offset === null) {
			$offset = $value->val();
		} else {
			$value->val($offset);
		}
		
		$value->attr($this->attr());
		$this->inputs[$offset] = $value;
	}

	public function setForm (Form $form) {
		$this->form = $form;
	}

	public function setFieldset (FieldsetInterface $fieldset) {
		$this->fieldset = $fieldset;
	}

	public function error ($error = null) {
		if ($error === null) {
			return $this->error;
		}

		$this->error = $error;

		return $this;
	}

	public function attr ($name = null, $value = null) {
		if (($value !== null) || is_array($name)) {
			foreach ($this->inputs as $Input) {
				$Input->attr($name, $value);
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

	public function load ($value = null, $file = null) {
		if (($sanitizer = $this->sanitizer) !== null) {
			$value = $sanitizer($value);
		}

		if (isset($this[$value])) {
			$this->value = $value;
			$this[$value]->load($value);
		}

		return $this;
	}

	public function val ($value = null) {
		if ($value === null) {
			if ($this->value !== null) {
				return $this->value;
			}

			foreach ($this->inputs as $input) {
				if (($value = $input->val()) !== null) {
					return $value;
				}
			}

			return null;
		}

		if (isset($this[$value])) {
			$this->value = $value;
			$this[$value]->val($value);
		}

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

	public function toHtml () {
		$html = '';

		foreach ($this->inputs as $input) {
			$html .= (string)$input;
		}

		return $html;
	}
}
