<?php
namespace FormManager\Fieldsets;

use FormManager\Traits\InputIteratorTrait;
use FormManager\Form;

class NoFieldset implements FieldsetInterface {
	use InputIteratorTrait;

	protected $form;

	public function __construct (Form $form) {
		$this->form = $form;
	}

	public function __toString () {
		$html = '';

		foreach ($this->inputs as $input) {
			$html .= (string)$input;
		}

		return $html;
	}
}
