<?php
namespace FormManager;

use FormManager\Traits\InputIteratorTrait;
use FormManager\Fieldsets\FieldsetInterface;
use FormManager\Fieldsets\Fieldset;
use FormManager\Fieldsets\NoFieldset;
use FormManager\Inputs\InputInterface;

class Form extends Element implements \Iterator, \ArrayAccess {
	use InputIteratorTrait;

	protected $name = 'form';
	protected $close = true;
	protected $fieldsets = [];

	public function offsetSet ($offset, $value) {
		if (!($value instanceof InputInterface)) {
			throw new \InvalidArgumentException('Only elements implementing FormManager\\Inputs\\InputInterface must be added to forms');
		}

		if ($offset === null) {
			$offset = $value->attr('name');
		} else {
			$value->attr('name', $offset);
		}

		if (!$value->fieldset) {
			if (!isset($this->fieldsets[-1])) {
				$this->fieldsets[-1] = new NoFieldset($this);
			}

			$this->fieldsets[-1][$offset] = $value;
		}

		$this->inputs[$offset] = $value;
	}

	public function addFieldset ($fieldset) {
		if (is_array($fieldset)) {
			$fieldset = (new Fieldset($this))->add($fieldset);
		}
		if (!($fieldset instanceof FieldsetInterface)) {
			throw new \Exception('Only objects with FormManager\\Fieldsets\\FieldsetInterface implemented must be added');
		}

		return $this->fieldsets[] = $fieldset;
	}

	public function getFieldsets ($name = null) {
		return $this->fieldsets;
	}

	public function load (array $get = array(), array $post = array(), array $file = array()) {
		$data = ($this->attr('method') === 'post') ? $post : $get;

		foreach ($this->inputs as $name => $input) {
			$input->load((isset($data[$name]) ? $data[$name] : null), (isset($file[$name]) ? $file[$name] : null));
		}

		return $this;
	}

	public function val (array $value = null) {
		if ($value === null) {
			$value = array();

			foreach ($this->inputs as $name => $input) {
				$value[$name] = $input->val();
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
		foreach ($this->inputs as $input) {
			if ($input->isValid() === false) {
				return false;
			}
		}

		return true;
	}

	public function html () {
		$html = '';

		foreach ($this->fieldsets as $fieldset) {
			$html .= (string)$fieldset;
		}

		return $html;
	}
}
