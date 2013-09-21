<?php
namespace FormManager\Fieldsets;

use FormManager\Traits\InputIteratorTrait;
use FormManager\Form;
use FormManager\Element;

class Fieldset extends Element implements \Iterator, \ArrayAccess, FieldsetInterface {
	use InputIteratorTrait;

	protected $name = 'fieldset';
	protected $close = true;
	protected $form;

	public function offsetSet ($offset, $value) {
		$this->inputs[$offset] = $value;
		$value->setFieldset($this);
		$this->form[$offset] = $value;
	}

	public function __construct (Form $form) {
		$this->form = $form;
	}

	public function html () {
		$html = '';

		foreach ($this->inputs as $input) {
			$html .= (string)$input;
		}

		return $html;
	}
}
