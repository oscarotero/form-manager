<?php
namespace FormManager;

use FormManager\Inputs\Input;

class Label extends Element {
	protected $name = 'label';
	protected $close = true;
	protected $input;

	public function __construct (Input $input = null, array $attributes = null, $html = null) {
		if ($input !== null) {
			$this->setInput($input);
		}

		if ($attributes !== null) {
			$this->attr($attributes);
		}

		if ($html !== null) {
			$this->html = $html;
		}
	}

	public function setInput (Input $input) {
		$this->input = $input;
	}

	public function toHtml () {
		if ($this->input) {
			$this->attr('for', $this->input->id());
		}

		return parent::toHtml();
	}
}
