<?php
namespace FormManager;

use FormManager\Inputs\Input;

class Label extends Element {
	protected $name = 'label';
	protected $close = true;
	protected $input;

	public function __construct (Input $input, array $attributes = null, $html = null) {
		$this->input = $input;

		parent::__construct($attributes, $html);
	}

	public function toHtml () {
		if ($this->input) {
			$this->attr('for', $this->input->id());
		}

		return parent::toHtml();
	}
}
